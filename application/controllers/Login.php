<?php
require_once APPPATH.'core/MY_Controller.php';

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $this->session->set_flashdata('already_logged_in', 'Tu jau esi pieslēdzies.');
            redirect('/');
        }
    
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title'] = 'Pieslēgties';
    
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $this->data);
            $this->load->view('account/login');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $login_result = $this->user_model->login_user($email, $password);
    
            if ($login_result) {
                $user_data = array(
                    'user_id' => $login_result['user_id'],
                    'username' => $login_result['username'],
                    'is_admin' => $login_result['is_admin'],
                    'email' => $email,
                    'logged_in' => true
                );
                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('user_loggedin', 'Tu esi veiksmīgi pieslēdzies!');
                redirect('/');
            } else {
                $this->session->set_flashdata('login_failed', 'Neveiksmīga pieslēgšanās!');
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->sess_destroy();
    
        $this->session->set_flashdata('user_loggedout', 'Tu esi veiksmīgi izlogojies.');
        redirect('/');
    }
}