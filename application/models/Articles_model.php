<?php
class Articles_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_articles()
    {
        $this->db->select("articles.*, MAX(images.image_path) as image_path");
        $this->db->from("articles");
        $this->db->join("images", "images.article_id = articles.id", "left");
        $this->db->where("articles.is_published", 1);
        $this->db->group_by("articles.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_articles_by_category($category_id)
    {
        $this->db->select("articles.*, MAX(images.image_path) as image_path");
        $this->db->from("articles");
        $this->db->join("images", "images.article_id = articles.id", "left");
        $this->db->where("articles.category_id", $category_id);
        $this->db->where("articles.is_published", 1);
        $this->db->group_by("articles.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_articles_by_author($author_id)
    {
        $this->db->select(
            "articles.*, MAX(images.image_path) as image_path, users.name as author_name"
        );
        $this->db->from("articles");
        $this->db->join("images", "images.article_id = articles.id", "left");
        $this->db->join("users", "users.id = articles.author_id");
        $this->db->where("articles.author_id", $author_id);
        $this->db->where("articles.is_published", 1);
        $this->db->group_by("articles.id");
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

}
