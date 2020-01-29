<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model 
{
    // definisi nama table tapi karna nama modelnya sama dengan nama table jadi tidak perlu di defenisikan (fungsi tersebut ada di core MY_Model)
    // protected $table = 'category';
    // untuk halaman pagination yang terdapat pada core MY_Model bisa diubah dengan cara Overiding property / method (untuk sekarang tidak perlu diubah)
    // protected $perPage = 2;

    public function getDefaultValues()
    {
        return[
            'id' => '',
            'slug' => '',
            'title' => '' 
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'slug',
                'label' => 'Slug',
                'rules' => 'trim|required|callback_unique_slug' // callback_unique_slug rules ini akan dibuat di controllernya
            ],
            [
                'field' => 'title',
                'label' => 'Kategori',
                'rules' => 'trim|required'
            ]
        ];
        return $validationRules;
    }
}

/* End of file Category_model.php */

?>