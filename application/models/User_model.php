<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model 
{
    //protected $perPage = '2'; // jumlah data yang ingin di tampilkan di halaman    

    public function getDefaultValues()
    {
        return [
            'name'      => '',
            'email'     => '',
            'role'      => 'member',
            'is_active' => 0
            // password sama image enggak di set defaultnya (liat video di folder 9. Membuat modul admin pengguna)
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field'     => 'name',
                'label'     => 'Nama',
                'rules'     => 'trim|required'
            ],
            [
                'field'     => 'email',
                'label'     => 'E-Mail',
                'rules'     => 'trim|required|valid_email|callback_unique_email'
                
            ],
            [
                'field'     => 'role',
                'label'     => 'Role',
                'rules'     => 'required'
            ]
        ];

        return $validationRules;
    }

    public function uploadImage($fieldName, $fileName)
    {
        $config = [
            'upload_path'   => './uploads/user',
            'file_name'     => $fileName,
            'allowed_types' => 'gif|jpg|png|JPEG|PNG',
            'max_size'      => 1024, //1mb
            'max_width'     => 0,
            'max_height'    => 0,
            'overwrite'     => true, //jika ada nama file yang sama akan di timpa
            'file_ext_tolower' => true //untuk mengubah extensi file menjadi huruf kecil
        ];
        $this->load->library('upload', $config);

        if($this->upload->do_upload($fieldName)){
            return $this->upload->data();
        }
        else {
            $this->session->set_flashdata('image_error', $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function deleteImage($fileName)
    {
        if(file_exists("./uploads/user/$fileName")){
            unlink("./uploads/user/$fileName");
        }
    }
}

/* End of file User_model.php */

?>