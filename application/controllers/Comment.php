<?php

class Comment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('comment_model');
        $this->load->helper('url');
    }

    public function create() {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('not_logged_in', 'Jums ir jāpieslēdzas, lai pievienotu komentāru.');
            redirect('login');
        }

        $article_id = $this->input->post('article_id');
        $content = $this->input->post('content');
        $user_id = $this->session->userdata('user_id');

        $this->comment_model->add_comment($article_id, $user_id, $content);
        redirect('articles/view/' . $article_id);
    }
}