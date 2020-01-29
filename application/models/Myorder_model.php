<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myorder_model extends MY_Model 
{
    public $table = 'orders';

    public function getDefaultValues()
    {
        return [
            'id_orders'     => '',
            'account_name'  => '',
            'account_number'=> '',
            'nominal'       => '',
            'note'          => '',
            'image'         => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'account_name',
                'label' => 'Pemilik Rekening',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'account_number',
                'label' => 'No. Rekening',
                'rules' => 'trim|required|max_length[50]'
            ],
            [
                'field' => 'nominal',
                'label' => 'Sebesar',
                'rules' => 'trim|required|numeric'
            ],
            [
                'field' => 'image',
                'label' => 'Bukti',
                'rules' => 'callback_image_required'
            ]
        ];

        return $validationRules;
    }

    public function uploadImage($fieldName, $fileName)
    {
        $config = [
            'upload_path'   => './uploads/confirm',
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
}

/* End of file Myorders_model.php */

?>