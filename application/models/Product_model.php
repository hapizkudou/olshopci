<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends MY_Model 
{

    // protected $perPage = 2;

    public function getDefaultValues()
    {
        return[
            'id'            => '',
            'id_category'   => '',
            'title'         => '',
            'slug'          => '',
            'description'   => '',
            'price'         => '',
            'is_available'  => 1,
            'image'         => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'id_category',
                'Label' => 'Kategori',
                'rules' => 'required'
            ],
            [
                'field' => 'title',
                'Label' => 'Nama Produk',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'slug',
                'Label' => 'Slug',
                'rules' => 'trim|required|callback_unique_slug'
            ],
            [
                'field' => 'description',
                'Label' => 'Deksripsi Produk',
                'rules' => 'required'
            ],
            [
                'field' => 'price',
                'Label' => 'Harga',
                'rules' => 'trim|required|numeric'
            ],
            [
                'field' => 'is_available',
                'Label' => 'Ketersediaan',
                'rules' => 'required'
            ]
        ];
        return $validationRules;
    }

    public function uploadImage($fieldName, $fileName)
    {
        $config = [
            'upload_path'   => './uploads/product',
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
        if(file_exists("./uploads/product/$fileName")){
            unlink("./uploads/product/$fileName");
        }
    }
}

/* End of file Product_model.php */

?>