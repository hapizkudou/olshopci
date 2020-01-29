<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $is_login = $this->session->userdata('is_login');

        if($is_login){
            redirect(base_url());
            return;
        }
    }
    
    public function index()
    {
        if(! $_POST){
            $input = (object) $this->login->getDefaultValues();
        }
        else {
            $input = (object) $this->input->post(null, true);
        }

        if(! $this->login->validate())
        {
            $data['title'] = 'Login';
            $data['input'] = $input;
            $data['page'] = 'pages/auth/login';
            $data['tags'] = '0'; //tags ini untuk menandai class active pada navbar
            $this->view($data);
            return;
        }

        if($this->login->run($input)){
            $this->session->set_flashdata('success', 'berhasil melakukan Login !');
            redirect(base_url());
        }
        else {
            $this->session->set_flashdata('error', 'E-Mail atau Password yang anda masukkan salah atau akun anda sedang tidak aktif');
            redirect(base_url('login'));
        }
    }

}

/* End of file Login.php */

?>