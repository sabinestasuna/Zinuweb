<?php
require_once APPPATH.'core/MY_Controller.php';

class Category extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('articles_model');
    }

    public function view($category_id) {
        $sort = $this->input->get('sort') ?: 'newest';

        $category_name = $this->articles_model->get_category_name($category_id);
        if (!$category_name) {
            show_404();
        }
        
        $this->data['title'] = $category_name;
        $this->data['articles'] = $this->articles_model->get_articles_by_category($category_id, $sort);
        $this->data['sort'] = $sort;
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('articles/index', $this->data);
        $this->load->view('templates/footer');
    }
}