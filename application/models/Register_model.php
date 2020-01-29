<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Register_Model extends MY_Model 
{

    protected $table = 'user';

    public function getDefaultValues() // berfungsi untuk pada saat membuka form registrasi maka akan terisikan value defaultnya
    {
        return[
            'name'      => '',
            'email'     => '',
            'password'  => '',
            'role'      => '',
            'is_active' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'trim|required'
                // 'error' => [
                //     'trim' => 'Nama harus dimasukkan !'
                // ]
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'trim|required|valid_email|is_unique[user.email]'
                // ,
                // 'error' => [
                //     'is_unique' => 'This %s already exists.'
                // ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]',
                'error' => [
                    'min_length' => 'Password yang anda masukkan kurang'
                ]
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]'
            ]
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'name'      => $input->name,
            'email'     => strtolower($input->email), //bisa aja email dari user terdapat huruf besar
            'password'  => hashEncrypt($input->password),
            'role'      => 'member' 
        ];

        $user = $this->create($data);

        $sess_data = [
            'id'        => $user,
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'is_login'  => true
        ];

        $this->session->set_userdata($sess_data);
        return true;
    }
}

/* End of file Register_Model.php */
?>