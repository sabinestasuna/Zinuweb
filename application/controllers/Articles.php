<?php
require_once APPPATH.'core/MY_Controller.php';

class Articles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('articles_model');
        $this->load->model('comment_model');
        $this->load->library('form_validation');
    }

    public function index($id = null) {
        $sort = $this->input->get('sort', TRUE) ?: 'newest';
        $type = $this->uri->segment(1);
    
        if ($type === 'category' && $id) {
            $this->data['articles'] = $this->articles_model->get_articles_by_category($id, $sort);
            $this->data['title'] = $this->articles_model->get_category_name($id);
        } elseif ($type === 'author' && $id) {
            $this->data['articles'] = $this->articles_model->get_articles_by_author($id, $sort);
            $this->data['title'] = "Raksti no autora: " . $this->data['articles'][0]['author_name'];
        } else {
            $this->data['articles'] = $this->articles_model->get_articles($sort);
            $this->data['title'] = 'Visi raksti';
        }
    
        $this->data['sort'] = $sort;
    
        if ($this->input->is_ajax_request()) {
            $this->load->view('articles/partial_articles', $this->data);
        } else {
            $this->load->view('templates/header', $this->data);
            $this->load->view('articles/index', $this->data);
            $this->load->view('templates/footer');
        }
    }


    public function delete($id) {
        if ($this->session->userdata('is_admin')) {
            $result = $this->articles_model->delete_article($id);
            if ($result) {
                $this->session->set_flashdata('message', 'Raksts veiksmīgi dzēsts.');
            } else {
                $this->session->set_flashdata('error', 'Kļūda dzēšanas procesā.');
            }
        } else {
            $this->session->set_flashdata('error', 'Jums nav tiesību dzēst rakstus.');
        }
        redirect('articles');
    }

    public function view($id) {

        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('access_denied', 'Lūdzu, pieslēdzieties, lai skatītu šo lapu.');
            redirect('login');
        }

        $this->articles_model->increment_views($id);
        
        $article = $this->articles_model->get_article_by_id($id);
        if (empty($article)) {
            show_404();
        }

        $comments = $this->comment_model->get_comments_by_article($id);

        $this->data['title'] = $article['title'];
        $this->data['article'] = $article;
        $this->data['comments'] = $comments;

        $this->load->view('templates/header', $this->data);
        $this->load->view('articles/single', $this->data);
        $this->load->view('templates/footer');
    }

    public function create() {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('not_logged_in', 'Jums ir jāpieslēdzas, lai pievienotu rakstu.');
            redirect('login');
        }
        
        $this->load->model('category_model');
        $this->form_validation->set_rules('title', 'Nosaukums', 'required|trim');
        $this->form_validation->set_rules('content', 'Saturs', 'required');

        $this->data['title'] = 'Pievienot rakstu';
    
        if ($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->category_model->get_categories();
            $this->load->view('templates/header', $this->data);
            $this->load->view('articles/create', $data);
            $this->load->view('templates/footer');
        } else {
            $article_data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'author_id' => $this->session->userdata('user_id'),
                'category_id' => $this->input->post('category_id'),
                'publish_date' => date('Y-m-d H:i:s'),
                'is_published' => true
            );
    
            if ($article_id = $this->articles_model->add_article($article_data)) {
                if (!empty($_FILES['images']['name'][0])) {
                    $this->articles_model->upload_images($_FILES['images'], $article_id);
                }
                $this->session->set_flashdata('message', 'Raksts veiksmīgi pievienots!');
                redirect('article/' . $article_id);
            } else {
                $this->session->set_flashdata('error', 'Raksta pievienošana neizdevās.');
                redirect('add');
            }
        }
    }
}