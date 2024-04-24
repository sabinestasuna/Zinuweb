<?php
require_once APPPATH.'core/MY_Controller.php';

class Articles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('articles_model');
    }

    public function index() {
        $this->data['title'] = 'Visi raksti';
        $this->data['articles'] = $this->articles_model->get_articles();
        $this->load->view('templates/header', $this->data);
        $this->load->view('articles/index', $this->data);
        $this->load->view('templates/footer');
    }

    public function view_by_author($author_id) {
        $this->data['articles'] = $this->articles_model->get_articles_by_author($author_id);
        $this->data['title'] = "Raksti no autora: " . $this->data['articles'][0]['author_name'];
    
        $this->load->view('templates/header', $this->data);
        $this->load->view('articles/index', $this->data);
        $this->load->view('templates/footer');
    }

    public function view($id) {
        $article = $this->articles_model->get_article_by_id($id);
        if (empty($article)) {
            show_404();
        }

        $comments = $this->articles_model->get_article_comments($id);

        $this->data['title'] = $article['title'];
        $this->data['article'] = $article;
        $this->data['comments'] = $comments;

        $this->load->view('templates/header', $this->data);
        $this->load->view('articles/view', $this->data);
        $this->load->view('templates/footer');
    }
}