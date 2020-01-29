<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

    private $id; // id dari masing2 user yang mengakses halaman profile

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $is_login   = $this->session->userdata('is_login');
        $this->id   = $this->session->userdata('id');

        if(! $is_login){
            $this->session->set_flashdata('warning', 'Untuk menggunakan cart harus login terlebih dahulu');
            redirect(base_url('/'));
            return;
        }
    }

    public function index()
    {
        $data['title']   = 'Cart';
        $data['content'] = $this->cart->select([
            'cart.id', 'cart.qty', 'cart.subtotal', 'product.title', 'product.price', 'product.image'
        ])->join('product')->where('cart.id_user', $this->id)->get();

        $data['page']   = 'pages/cart/index';
        $data['tags']   = '3';

        $this->view($data);
        // if(! $_POST || $this->input->post('qty') == $data['content']->qty)
    }

    public function add()
    {
        if(! $_POST || $this->input->post('qty') < 1){
            $this->session->set_flashdata('error', 'Produk yang dimasukkan tidak boleh kosong !');
            redirect(base_url('/'));
        }
        else {
            $input = (object) $this->input->post(null, true);

            $this->cart->table  = 'product'; //mengoveride variable table yang semulanya "cart" menjadi "product"
            $product            = $this->cart->where('id', $input->id_product)->first(); //id_product berasal dari hidden form("name") pada tombol "Add To Cart"

            $subtotal           = $product->price * $input->qty; //qty berasal dari name=qty pada input jumlah barang yang akan di masukkan ke cart

            $this->cart->table  = 'cart'; //mengoverride bariable table kembali menjadi "cart"
            $cart               = $this->cart->where('id_user', $this->id)->where('id_product',                                 $input->id_product)->first(); //variable ini berfungsi untuk mengecek, apakah user ini menambahkan barang yang sudah pernah di tambah sebelumnya, jika iya maka hanya lakukan update kuantitasnya saja (qty). Jika tidak maka buat data baru

            if($cart){
                $data = [
                    'qty'       => $cart->qty + $input->qty,
                    'subtotal'  => $cart->subtotal + $subtotal 
                ];

                if($this->cart->where('id', $cart->id)->update($data)){
                    $this->session->set_flashdata('success', "Produk $product->title berhasil dimasukkan ke Cart Anda");
                }
                else {
                    $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
                }

                redirect(base_url('/'));
            }

            $data = [
                'id_user'   => $this->id,
                'id_product'=> $input->id_product,
                'qty'       => $input->qty,
                'subtotal'  => $subtotal
            ];

            if($this->cart->create($data)){
                $this->session->set_flashdata('success', "Produk $product->title berhasil dimasukkan ke Cart Anda");
            }
            else {
                $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
            }

            redirect(base_url('/'));
        }
    }

    public function update($id)
    {
        $data['content'] = $this->cart->where('id', $id)->first();

        if(! $_POST || $this->input->post('qty') < 1 || $this->input->post('qty') == $data['content']->qty){
            redirect(base_url('cart'));
        }

        if(! $data['content']){
            $this->session->set_flashdata('warning', 'Maaf, Data tidak ditemukan !');
            redirect(base_url('cart'));
        }
        else {
            $data['input']  = (object) $this->input->post(null, true);

            $this->cart->table  = 'product';
            $product            = $this->cart->where('id', $data['content']->id_product)->first();
            $subtotal           = $product->price * $data['input']->qty;

            $this->cart->table  = 'cart';
            $cart = [
                'qty'       => $data['input']->qty,
                'subtotal'  => $subtotal
            ];

            if($this->cart->where('id', $id)->update($cart)){
                $this->session->set_flashdata('success', "Jumlah produk $product->title berhasil diperbarui");
            }
            else {
                $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
            }

            redirect(base_url('cart'));
        }
    }

    public function erase($id)
    {
        if(! $_POST){
            redirect(base_url('cart'));
        }

        $cart = $this->cart->where('id', $id)->first();
        
        $this->cart->table = 'product';
        
        $product            = $this->cart->where('id', $cart->id_product)->first(); //tujuannya hanya mengambil nilai judul saja mungkin bisa dengan cara lain yaitu join
        
        $this->cart->table = 'cart';

        if(! $cart){
            $this->session->set_flashdata('warning', 'Maaf, Data tidak ditemukan !');
            redirect(base_url('cart'));
        }

        if($this->cart->where('id', $id)->delete()){
            $this->session->set_flashdata('success', "Produk $product->title berhasil dihapus dari cart anda!");
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }

        redirect('cart');
    }
}

/* End of file Cart.php */

?>