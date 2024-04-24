<?php
require_once APPPATH.'core/MY_Controller.php';

class Register extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {

        if ($this->session->userdata('logged_in')) {
            $this->session->set_flashdata('already_logged_in', 'Tu jau esi reģistrējies un pieslēdzies.');
            redirect('/');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title'] = 'Reģistrēties';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $this->data);
            $this->load->view('account/register');
            $this->load->view('templates/footer');
        } else {
            $password_hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->user_model->register_user($this->input->post('name'), $this->input->post('email'), $password_hash);
            $this->session->set_flashdata('user_registered', 'Tu esi piereģistrējies un tagad vari pieslēgties');
            redirect('login');
        }
    }
}