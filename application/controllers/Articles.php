<?php
require_once APPPATH.'core/MY_Controller.php';

class Articles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('articles_model');
        $this->load->model('comment_model');
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
}