<?php
require_once APPPATH.'core/MY_Controller.php';
require_once APPPATH.'libraries/google-api-php-client/vendor/autoload.php';

class Login extends MY_Controller {

    protected $google_client;

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->initGoogleClient();
    }

    private function initGoogleClient($redirectUri = null) {
        $this->google_client = new Google_Client();
        $this->google_client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $this->google_client->setClientId(getenv('GOOGLE_CLIENT_SECRET'));
        $this->google_client->setRedirectUri($redirectUri ? $redirectUri : base_url('login/google_callback'));
        $this->google_client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $this->google_client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
        $this->google_client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
        $this->google_client->setHttpClient(new GuzzleHttp\Client(['verify' => false])); //testa nolūkos
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
            $this->data['google_login_url'] = $this->google_client->createAuthUrl();
            $this->load->view('templates/header', $this->data);
            $this->load->view('account/login', $this->data);
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
                    'has_google' => $login_result['has_google'],
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

    public function google_callback() {
        $token = $this->google_client->fetchAccessTokenWithAuthCode($this->input->get('code'));
    
        if (!isset($token['error'])) {
            $this->google_client->setAccessToken($token['access_token']);
            $google_service = new Google_Service_Oauth2($this->google_client);
            $user_info = $google_service->userinfo->get();
    
            $existing_user = $this->user_model->find_by_google_id($user_info->id);
    
            if ($existing_user) {
                $session_data = [
                    'logged_in' => true,
                    'user_id' => $existing_user->id,
                    'username' => $existing_user->name,
                    'is_admin' => $existing_user->is_admin,
                    'has_google' => true
                ];
                $this->session->set_userdata($session_data);
                $this->session->set_flashdata('user_loggedin', 'Tu esi veiksmīgi pieslēdzies ar Google!');
                redirect('/');
            } else {
                $new_user_id = $this->user_model->create_user_from_google($user_info);
                if ($new_user_id) {
                    $session_data = [
                        'logged_in' => true,
                        'user_id' => $new_user_id,
                        'username' => $user_info->name,
                        'has_google' => true
                    ];
                    $this->session->set_userdata($session_data);
                    $this->session->set_flashdata('user_loggedin', 'Tu esi veiksmīgi reģistrējies ar Google!');
                    redirect('/');
                } else {
                    $this->session->set_flashdata('login_failed', 'Nevarēja izveidot lietotāja profilu ar Google!');
                    redirect('login');
                }
            }
        } else {
            $this->session->set_flashdata('login_failed', 'Google autorizācija neizdevās!');
            redirect('login');
        }
    }

    public function link_google() {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('login_required', 'Lūdzu, pieslēdzieties, lai pievienotu Google kontu.');
            redirect('login');
        }
        $this->initGoogleClient(base_url('login/google_link_callback'));
        $auth_url = $this->google_client->createAuthUrl();
        redirect($auth_url);
    }


    public function google_link_callback() {
        $this->initGoogleClient(base_url('login/google_link_callback'));
        $token = $this->google_client->fetchAccessTokenWithAuthCode($this->input->get('code'));
        
        if (!isset($token['error'])) {
            $this->google_client->setAccessToken($token['access_token']);
            $google_service = new Google_Service_Oauth2($this->google_client);
            $user_info = $google_service->userinfo->get();
        
            $user_id = $this->session->userdata('user_id');
            $this->user_model->link_google_account($user_id, $user_info->id);
        
            $this->session->set_userdata('has_google', true);
            $this->session->set_flashdata('google_linked', 'Google konts veiksmīgi pievienots!');
            redirect('/');
        } else {
            $this->session->set_flashdata('google_link_failed', 'Neizdevās piesaistīt Google kontu!');
            redirect('/');
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
