<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model 
{
    // karena nama modelnya tidak sama dengan data yang mau digunakan maka kita harus meng-overiding nama tablenya
    protected $table = 'user';

    public function getDefaultValues()
    {
        return[
            'name'  => '',
            'email' => '',
            'image' => ''
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

/* End of file Profile_model.php */

?>