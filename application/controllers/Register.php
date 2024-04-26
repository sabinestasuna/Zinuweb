<?php
require_once APPPATH.'core/MY_Controller.php';
require_once APPPATH.'libraries/google-api-php-client/vendor/autoload.php';

class Register extends MY_Controller {

    protected $google_client;

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->initGoogleClient();
    }

    private function initGoogleClient() {
        $this->google_client = new Google_Client();
        $this->google_client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $this->google_client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $this->google_client->setRedirectUri(base_url('login/google_callback'));
        $this->google_client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $this->google_client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
        $this->google_client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
        $this->google_client->setHttpClient(new GuzzleHttp\Client(['verify' => false])); //testa nolūkos
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $this->session->set_flashdata('already_logged_in', 'Tu jau esi reģistrējies un pieslēdzies.');
            redirect('/');
        }

        $this->data['google_register_url'] = $this->google_client->createAuthUrl();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title'] = 'Reģistrēties';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $this->data);
            $this->load->view('account/register', $this->data);
            $this->load->view('templates/footer');
        } else {
            $password_hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $this->user_model->register_user($this->input->post('name'), $this->input->post('email'), $password_hash);
            $this->session->set_flashdata('user_registered', 'Tu esi piereģistrējies un tagad vari pieslēgties');
            redirect('login');
        }
    }
}
