<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    
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
    
    public function index($page = null)
    {
        $data['title'] = 'Admin: Produk';
        $data['content'] = $this->product->select(
            [
                'product.id', 'product.title AS product_title', 'product.price', 'product.is_available', 'product.image', 'category.title AS category_title'
            ]
        )->join('category')->paginate($page)->get();
        $data['total_rows'] = $this->product->count();
        $data['pagination'] = $this->product->makePagination(base_url('product'), 2, $data['total_rows']);
        $data['page'] = 'pages/product/index';
        $data['tags'] = '1';

        $this->view($data);
    }

    public function search($page = null) // tambahkan pencarian tidak hanya dari title tapi dari deskripsi juga
    {
        if(isset($_POST['keyword'])){
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');
        $data['title'] = 'Admin: Produk';
        $data['content'] = $this->product->select(
            [
                'product.id', 'product.title AS product_title', 'product.price', 'product.is_available', 'product.image', 'category.title AS category_title'
            ]
        )->join('category')->like('product.title', $keyword)
        ->or_like('description', $keyword)
        ->paginate($page)->get();
        $data['total_rows'] = $this->product->like('product.title', $keyword)->or_like('description', $keyword)->count();
        $data['pagination'] = $this->product->makePagination(base_url('product/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/product/index';
        $data['tags'] = '1';

        $this->view($data);
    }

    public function reset()
    {
        $this->session->unset_userdata('keyword');
        redirect(base_url('product'));
    }

    public function create()
    {
        if(! $_POST){
            $input = (object) $this->product->getDefaultValues();
        }
        else {
            $input = (object) $this->input->post(null, true);
        }

        if(! empty($_FILES) && $_FILES['image']['name'] !== ''){ //cari tau array dari $_FILES['image']['name']
            $imageName = url_title($input->title, '-', true). '-' . date('YmdHis'); /*baris ini berfungsi mengubah nama file image menjadi nama produk (title) dengan fungsi url_title(). fungsi url_title() sama seperti slug agar menjadi friendly nama file dan fungsi date untuk jika ada file dengan name yang sama akan tetapi tanggal uploadnya akan berbeda, jadi kemungkinan 1 nama file yang sama akan berkurang. 
                ex : 
                - file pertama : asus-rog-serix-20190808234455 (angka aneh tersebut merupakan tanggal 2019/08/08 23:44:55)
                - untuk file sudah tau kelanjutannya
            */
            $upload = $this->product->uploadImage('image', $imageName);
            if($upload){ //cek return dari fungsi uploadImage
                $input->image = $upload['file_name'];
            }
            else {
                redirect(base_url('product/create'));
            }
        }

        if(! $this->product->validate()){
            $data['title']          = 'Admin: Tambah Produk';
            $data['input']          = $input;
            $data['form_action']    = base_url('product/create');
            $data['page']           = 'pages/product/form';
            $data['tags']           = '1';

            $this->view($data);
            return;
        }

        if($this->product->create($input)){
            $this->session->set_flashdata('success', 'Produk berhasil disimpan !');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }

        redirect(base_url('product'));
    }

    public function edit($id)
    {
        $data['content'] = $this->product->where('id', $id)->first();

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

        if(! empty($_FILES) && $_FILES['image']['name'] !== ''){ 
            $imageName  = url_title($data['input']->title, '-', true). '-' . date('YmmdHis');
            $upload     = $this->product->uploadImage('image', $imageName);
            if($upload){
                if($data['content']->image !== ''){
                    $this->product->deleteImage($data['content']->image);
                }
                $data['input']->image = $upload['file_name'];
            }
            else {
                redirect(base_url("product/edit/$id"));
            }
        }

        if(! $this->product->validate()){
            $data['title']          = 'Admin: Ubah Produk';
            $data['form_action']    = base_url("product/edit/$id");
            $data['page']           = 'pages/product/form';
            $data['tags']           = '1';

            $this->view($data);
            return;
        }

        if($this->product->where('id', $id)->update($data['input'])){
            $this->session->set_flashdata('success', 'Data berhasil diperbaharui !');
        }
        else {
            $this->session->set_flashdata('Error', 'Terjadi sebuah kesalahan !');
        }
        redirect(base_url('product'));
    }

    public function erase($id)
    {
        if(! $_POST)
        {
            redirect(base_url('product'));
        }

        $product = $this->product->where('id', $id)->first();
        if(! $product)
        {
            $this->session->set_flashdata('warning', 'Maaf, Data tidak ditemukan !');            
        }

        if($this->product->where('id', $id)->delete()){
            $this->product->deleteImage($product->image);
            $this->session->set_flashdata('success', 'Data berhasil dihapus !');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }
        redirect(base_url('product'));        
    }

    public function unique_slug()
    {
        $slug   = $this->input->post('slug');
        $id     = $this->input->post('id');
        $product = $this->product->where('slug', $slug)->first();

        if($product){
            if($id == $product->id){
                return true;
            }
            $this->load->library('form_validation'); //seharusnya bisa di panggil di autoload
            $this->form_validation->set_message('unique_slug', '%s sudah digunakan !');
            return false;
        }
        return true;
    }

    public function cleanImage()
    {
        $images = glob("uploads/product/*.*");
        $jumlah = false;
        for ($i=0; $i<count($images); $i++)
        {
            if(! $this->product->where('image', substr($images[$i], 16))->first())
            {
                unlink($images[$i]);
                $jumlah = true;
            }
        }

        if($jumlah)
        {
            $this->session->set_flashdata('success', 'Data berhasil dihapus !');
        }
        else {
            $this->session->set_flashdata('success', 'Tidak ada data yang perlu di hapus !'); 
        }
        redirect(base_url('product'));
    }

}

/* End of file Product.php */

?>