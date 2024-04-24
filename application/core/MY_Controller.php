<?php
class MY_Controller extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('category_model');
        $this->data['categories'] = $this->category_model->get_categories();
    }
}