<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Myorder extends MY_Controller {

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

    public function index($page = null)
    {
        $data['title']      = 'My Orders';
        $data['content']    = $this->myorder->where('id_user', $this->id)
                                ->orderBy('date', 'DESC')
                                ->paginate($page)
                                ->get();
        $data['total_rows'] = $this->myorder->where('id_user', $this->id)
                                ->count();
        $data['pagination'] = $this->myorder->makePagination(base_url('myorder'), '2', $data['total_rows']);
        $data['page']       = 'pages/myorder/index';
        $data['tags']       = '2';
        $this->view($data); 
    }

    public function detail($invoice)
    {   
        $data['orders'] = $this->myorder->where('invoice', $invoice)->first();
        if(! $data['orders']){
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('myorder'));
        }

        $this->myorder->table   = 'orders_detail';
        $data['orders_detail']  = $this->myorder->select([
                'orders_detail.id_orders', 'orders_detail.id_product', 'orders_detail.qty', 'orders_detail.subtotal', 'product.title', 'product.price', 'product.image'
            ])
            ->join('product')
            ->where('orders_detail.id_orders', $data['orders']->id)
            ->get();

        if($data['orders']->status !== 'waiting'){
            $this->myorder->table   = 'orders_confirm';
            $data['orders_confirm'] = $this->myorder->where('id_orders', $data['orders']->id)->first();
        }
        
        $this->myorder->table   = 'orders';
        $data['title']          = "detail order : $invoice";
        $data['page']           = 'pages/myorder/detail';
        $data['tags']           = '2';

        $this->view($data);
    }

    public function confirm($invoice)
    {
        $data['orders'] = $this->myorder->where('invoice', $invoice)->first();
        if(! $data['orders']){
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('myorder'));
        }

        if($data['orders']->status !== 'waiting'){
            $this->session->set_flashdata('warning', 'Bukti transfer sudah dikirim');
            redirect(base_url('myorder'));
        }

        if(! $_POST){
            $data['input'] = (object) $this->myorder->getDefaultValues();
        }
        else {
            $data['input'] = (object) $this->input->post(null, true);
        }

        if(! empty($_FILES) && $_FILES['image']['name'] !== ''){
            $imageName  = url_title($invoice, '-', true). '-' . date('YmdHis');
            $upload     = $this->myorder->uploadImage('image', $imageName);
            if($upload){ 
                $data['input']->image = $upload['file_name'];
            }
            else {
                redirect(base_url("myorder/confirm/$invoice"));
            }
        }

        if(! $this->myorder->validate()){
            $data['title']          = 'Konfirmasi Pembayaran';
            $data['form_action']    = base_url("myorder/confirm/$invoice");
            $data['page']           = 'pages/myorder/confirm';
            $data['tags']           = '3';

            $this->view($data);
            return;
        }

        if($data['input']->nominal != $data['orders']->total){
            $this->session->set_flashdata('warning', 'nominal yang anda masukkan kurang atau berlebih !');
            redirect(base_url("myorder/confirm/$invoice"));
        }

        $this->myorder->table = 'orders_confirm';

        if($this->myorder->create($data['input'])){
            $this->myorder->table = 'orders';
            $this->myorder->where('id', $data['input']->id_orders)->update(['status' => 'paid']); // $data['input']->id_orders berasal dari input hidden yang terdapat pada 'pages/myorder/confirm'
            $this->session->set_flashdata('success', 'Konfirmasi pembayaran telah berhasil!');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }
        
        redirect(base_url("myorder/detail/$invoice"));
    }

    public function cancel($invoice)
    {
        $data['orders'] = $this->myorder->where('invoice', $invoice)->first();
        if(! $data['orders']){
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('myorder'));
        }

        if($this->myorder->where('id', $data['orders']->id)->update(['status' => 'cancel'])){
            $this->session->set_flashdata('success', 'Order anda berhasil dibatalkan!');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }
        redirect(base_url("myorder/detail/$invoice"));
    }

    public function image_required(){
        if(empty($_FILES) || $_FILES['image']['name'] === ''){
            $this->session->set_flashdata('image_error', 'Bukti Transfer tidak boleh kosong !');
            return false;
        }
        return true;
    }
}

/* End of file Myorders.php */

?>