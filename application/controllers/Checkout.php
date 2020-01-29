<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {

    private $id;

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $is_login   = $this->session->userdata('is_login');
        $this->id   = $this->session->userdata('id');

        if(! $is_login){
            //$this->session->set_flashdata('warning', 'Untuk menggunakan cart harus login terlebih dahulu');
            redirect(base_url('/'));
            return;
        }
    }

    public function index($input = null)
    {
        $this->checkout->table = 'cart'; 
        
        $data['cart']   = $this->checkout->select([
            'cart.id', 'cart.qty', 'cart.subtotal', 'product.title', 'product.price', 'product.image'
        ])->join('product')->where('cart.id_user', $this->id)->get();

        if(! $data['cart']){
            $this->session->set_flashdata('warning', 'Maaf keranjang anda kosong !');
            redirect(base_url('/'));
        }

        $this->checkout->table = 'orders';
        
        // if(! $_POST){
        //     $input = (object) $this->checkout->getDefaultValues();
        // }
        // else {
        //     $input = (object) $this->input->post(null, true);
        // }

        // if(! $this->checkout->validate()){
        //     $data['title']  = 'Checkout';
        //     $data['input']  = (object) $this->checkout->getDefaultValues();
        //     $data['page']  = 'pages/checkout/index';
        //     $data['tags']   = '3';

        //     $this->view($data);
        //     return;
        // }

        $data['title']  = 'Checkout';
        $data['input']  = $input ? $input : (object) $this->checkout->getDefaultValues(); //perlu isset kah ?
        $data['page']  = 'pages/checkout/index';
        $data['tags']   = '3';

        $this->view($data);
    }

    public function create()
    {
        if(! $_POST){
            redirect(base_url('checkout'));
        }
        else {
            $input = (object) $this->input->post(null, true);
        }

        if(! $this->checkout->validate()){
            return $this->index($input); //jika tidak validate kembali ke fungsi index, agak input yang dimasukkan tidak hilang maka perlu ditambahkan sebuah variable untuk "input" bernilai "null"
        }

        $this->checkout->table = 'cart'; //overiding ke table cart
        $cart   = $this->checkout->where('id_user', $this->id)->get();
        $total  = array_sum(array_column($cart, 'subtotal'));

        $this->checkout->table = 'orders';

        // $total2 = $this->db->select_sum('subtotal')
        //         ->where('id_user', $this->id)
        //         ->get('cart')
        //         ->row()
        //         ->subtotal;
        // ada dua cara untuk mencari total dari subtotal, terserah mau pilih yang mana

        $data   = [
            'id_user'   => $this->id,
            'date'      => date('Y-m-d'),
            'invoice'   => $this->id.date('YmdHis'), //untuk contoh hanya memanfaatkan id dari user sama datetime
            'total'     => $total, //tes my syntax
            'name'      => $input->name,
            'address'   => $input->address,
            'phone'     => $input->phone,
            'status'    => 'waiting'
        ];
        
        if($order = $this->checkout->create($data)){
            foreach ($cart as $row) {
                $row->id_orders = $order; //nilai order berasal dari return hasil selesai menambahkan table berupa idnya
                unset($row->id, $row->id_user);
                $this->checkout->table = 'orders_detail'; //mengoveride table menjadi "orders_detail", bertujuan untuk memindahkan data yang terdapat pada table "cart" ke "orders_detail", lalu menghapus table "cart" sesuai dengan id_usernya
                $this->checkout->create($row);
            }

            $this->checkout->table = 'cart';
            $this->checkout->where('id_user', $this->id)->delete();
            $this->session->set_flashdata('success', 'Checkout berhasil !');

            //jika ada kesalahan pada saat memasukkan data atau gagal menghapus table cart(dari baris 101 sampe 110) maka diubah sesuai yang di ajarkan di modul
            $this->checkout->table = 'orders';
            $data['title']      = 'Checkout Success';
            $data['content']    = (object) $data;
            $data['page']       = 'pages/checkout/success';
            $data['tags']       = '3';
            $this->view($data);
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
            return $this->index($input);
        }
    }
}

/* End of file Checkout.php */

?>