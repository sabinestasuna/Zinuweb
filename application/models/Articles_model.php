<?php
class Articles_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function setupArticleQuery($sort) {
        $this->db->select('articles.*, MAX(images.image_path) as image_path, COUNT(DISTINCT comments.id) as comment_count, users.name as author_name, categories.name as category_name');
        $this->db->from('articles');
        $this->db->join('images', 'images.article_id = articles.id', 'left');
        $this->db->join('comments', 'comments.article_id = articles.id', 'left');
        $this->db->join('users', 'users.id = articles.author_id', 'left');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        $this->db->where('articles.is_published', 1);
        $this->db->group_by('articles.id');

        switch ($sort) {
            case 'most_viewed':
                $this->db->order_by('articles.views', 'DESC');
                break;
            case 'most_commented':
                $this->db->order_by('comment_count', 'DESC');
                break;
            case 'newest':
            default:
                $this->db->order_by('articles.publish_date', 'DESC');
                break;
        }
    }

    public function get_articles($sort = 'newest') {
        $this->setupArticleQuery($sort);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_articles_by_category($category_id, $sort = 'newest') {
        $this->setupArticleQuery($sort);
        $this->db->where('articles.category_id', $category_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_articles_by_author($author_id, $sort = 'newest') {
        $this->setupArticleQuery($sort);
        $this->db->where('articles.author_id', $author_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function get_article_by_id($id)
    {
        $this->db->select(
            "articles.*, users.name as author_name, categories.name as category_name, categories.id as category_id"
        );
        $this->db->from("articles");
        $this->db->join("users", "users.id = articles.author_id", "left");
        $this->db->join(
            "categories",
            "categories.id = articles.category_id",
            "left"
        );
        $this->db->where("articles.id", $id);
        $this->db->where("articles.is_published", 1);

        $article = $this->db->get()->row_array();

        if ($article) {
            $this->db->select("image_path");
            $this->db->from("images");
            $this->db->where("article_id", $id);
            $image_query = $this->db->get();

            if ($image_query->num_rows() > 0) {
                $images = $image_query->result_array();
                $article["images"] = array_column($images, "image_path");
            } else {
                $article["images"] = [];
            }
            return $article;
        } else {
            return null;
        }
    }

    public function delete_article($id) {
        $this->db->where('id', $id);
        return $this->db->update('articles', ['is_published' => 0]);
    }

    public function get_category_name($category_id)
    {
        $this->db->select("name");
        $this->db->from("categories");
        $this->db->where("id", $category_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->name;
        } else {
            return null;
        }
    }

    public function increment_views($id) {
        $this->db->set('views', 'views+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('articles');
    }

    public function add_article($article_data) {
        $insert = $this->db->insert('articles', $article_data);
        if ($insert) {
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function upload_images($images, $article_id) {
        $this->load->library('upload');
    
        $uploadData = [];
        $count = count($images['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($images['name'][$i] != '') {
                $_FILES['file']['name'] = $images['name'][$i];
                $_FILES['file']['type'] = $images['type'][$i];
                $_FILES['file']['tmp_name'] = $images['tmp_name'][$i];
                $_FILES['file']['error'] = $images['error'][$i];
                $_FILES['file']['size'] = $images['size'][$i];
    
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 5000;
                $config['file_name'] = time() . '_' . $_FILES['file']['name'];
    
                $this->upload->initialize($config);
    
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $uploadData[] = [
                        'article_id' => $article_id,
                        'image_path' => $config['upload_path'] . $fileData['file_name'],
                        'upload_date' => date("Y-m-d H:i:s")
                    ];
                }
            }
        }
    
        if (!empty($uploadData)) {
            $this->db->insert_batch('images', $uploadData);
        }
    }
}
