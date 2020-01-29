<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        //method ini dibuat untuk mengecek siapa yang mengakses halaman tersebut, apakah admin / member 
        $role = $this->session->userdata('role');
        if($role != 'admin'){
            redirect(base_url('/'));
            return;
        }
    }
    
    public function index($page = null) // pada halaman category tidak memiliki no halaman (pada saat dibuka pertama kali)
    {
        $data['title'] = 'Admin: Kategori';
        $data['content'] = $this->category->paginate($page)->get();
        $data['total_rows'] = $this->category->count();
        $data['pagination'] = $this->category->makePagination(base_url('category'), 2, $data['total_rows']); 
        /*
            parameter kedua yaitu nomor halamannya 
            ex : olshop.test/category/{no halaman} 
            akan tetapi harus di setting terlebih dahulu di application/config/routes , dengan mendekralasi atau membuat route yang sesuai kita inginkan.
            jika kita tidak mendeklarasikan routenya maka parameter kedua tersebut kita ganti nilainya menjadi 3 karena url defaultnya akan menjadi seperti ini :
            ex : olshop.test/category/index/{no halaman}
            category = class controller
            index = method
            {no halaman} = parameter
            akan tetapi url seperti ini kurang friendly maka dari itu kita deklarasikan atau membuat route yang lebih friendly
        */
        $data['page'] = 'pages/category/index';
        $data['tags'] = '1';
        $this->view($data);
    }

    public function search($page = null)
    {
        //pengecekan apakah pada method post yang terdapat pada form search dengan 'name' input 'keyword terdapat nilai yang di isi
        if(isset($_POST['keyword'])){
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }
        // else {
        //     redirect(base_url('category'));
        // }

        $keyword = $this->session->userdata('keyword');
        $data['title'] = 'Admin: Kategori';
        $data['content'] = $this->category->like('title', $keyword)->paginate($page)->get();
        $data['total_rows'] = $this->category->like('title', $keyword)->count();
        $data['pagination'] = $this->category->makePagination(base_url('category/search'), 3, $data['total_rows']); 

        $data['page'] = 'pages/category/index';
        $data['tags'] = '1';
        $this->view($data);
    }

    public function reset()
    {
        $this->session->unset_userdata('keyword');
        redirect(base_url('category'));
    }


    public function create()
    {
        if(! $_POST)
        {
            $input = (object) $this->category->getDefaultValues();
        }
        else {
            $input = (object) $this->input->post(null, true);
        }

        if(! $this->category->validate()){
            $data['title'] = 'Admin: Tambah Kategori';
            $data['input'] = $input;
            $data['form_action'] = base_url('category/create'); //maksud baris ini yaitu menjalankan controller category dengan method create
            $data['page'] = 'pages/category/form';
            $data['tags'] = '1';

            $this->view($data);
            return;
        }

        if($this->category->create($input)){
            $this->session->set_flashdata('success', 'Kategori berhasil disimpan !');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }

        redirect(base_url('category'));
    }

    public function edit($id)
    {
        $data['content'] = $this->category->where('id', $id)->first();

        // kondisi ini hanya untuk tindak pencegahan jika ada user yang jahil mengedit lewat url
        if(! $data['content']){
            $this->session->set_flashdata('warning', 'Maaf, Data tidak ditemukan !');
            redirect(base_url('category'));
        }

        if(! $_POST){
            $data['input'] = $data['content'];
        }
        else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if(! $this->category->validate()){
            $data['title'] = 'Admin: Ubah Kategori';
            $data['form_action'] = base_url("category/edit/$id");
            $data['page'] = 'pages/category/form';
            $data['tags'] = '1';

            $this->view($data);
            return;
        }

        if($this->category->where('id', $id)->update($data['input'])){
            $this->session->set_flashdata('success', 'Data berhasil diperbaharui !');
        }
        else {
            $this->session->set_flashdata('Error', 'Terjadi sebuah kesalahan !');
        }
        redirect(base_url('category'));
    }

    // Karena untuk menghapus kategori harus menggunakan method post maka harus ada tambahan kondisi lagi
    // kenapa sih terlalu banyak kondisi untuk menghapus data saja? karena untuk mengurangi error baik dari user atau sistem
    public function erase($id)
    {
        if(! $_POST)
        {
            redirect(base_url('category'));
        }

        if(! $this->category->where('id', $id)->first())
        {
            $this->session->set_flashdata('warning', 'Maaf, Data tidak ditemukan !');            
        }

        if($this->category->where('id', $id)->delete()){
            $this->session->set_flashdata('success', 'Data berhasil dihapus !');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }
        redirect(base_url('category'));        
    }

    public function unique_slug()
    {
        $slug = $this->input->post('slug');
        $id = $this->input->post('id'); 
        $category = $this->category->where('slug', $slug)->first(); 

        if($category){
            if($id == $category->id){
                return true;
            }
            $this->load->library('form_validation'); //seharusnya bisa di panggil di autoload
            $this->form_validation->set_message('unique_slug', '%s sudah digunakan !');
            return false;
        }
        return true;
    }
}

/* End of file Category.php */

?>