<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

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
        $data['title']      = 'Admin : Order';
        $data['content']    = $this->order->orderBy('date', 'DESC')->paginate($page)->get();
        $data['total_rows'] = $this->order->count();
        $data['pagination'] = $this->order->makePagination(base_url('order'), 2, $data['total_rows']);
        $data['page']       = 'pages/order/index';
        $data['tags']       = '1';

        $this->view($data);
    }

    public function search($page = null)
    {
        if(isset($_POST['keyword'])){
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');
        $data['title'] = 'Admin: Order';
        $data['content']    = $this->order->like('invoice', $keyword)
                        ->or_like('status', $keyword)
                        ->orderBy('date', 'DESC')
                        ->paginate($page)
                        ->get();
        $data['total_rows'] = $this->order->like('invoice', $keyword)->or_like('status', $keyword)->count();
        $data['pagination'] = $this->order->makePagination(base_url('order/search'), 3, $data['total_rows']);
        $data['page']       = 'pages/order/index';
        $data['tags']       = '1';

        $this->view($data);
    }

    public function reset()
    {
        $this->session->unset_userdata('keyword');
        redirect(base_url('order'));
    }

    public function detail($id)
    {
        $data['orders'] = $this->order->where('id', $id)->first();
        if(! $data['orders']){
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('order'));
        }

        $this->order->table     = 'orders_detail';
        $data['orders_detail']  = $this->order->select([
                'orders_detail.id_orders', 'orders_detail.id_product', 'orders_detail.qty', 'orders_detail.subtotal', 'product.title', 'product.price', 'product.image'
            ])
            ->join('product')
            ->where('orders_detail.id_orders', $id)
            ->get();

        if($data['orders']->status !== 'waiting'){
            $this->order->table   = 'orders_confirm';
            $data['orders_confirm'] = $this->order->where('id_orders', $id)->first();
        }

        $this->order->table = 'orders';
        $data['title']      = "Admin : order id #$id";
        $data['page']       = 'pages/order/detail';
        $data['tags']       = '1';

        $this->view($data);
    }

    public function update($id)
    {
        if(! $_POST){
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
            redirect(base_url("order/detail/$id"));
        }

        if($this->order->where('id', $id)->update(['status' => $this->input->post('status')])){
            $this->session->set_flashdata('success', 'Status berhasil diperbarui !');
        }
        else {
            $this->session->set_flashdata('error', 'Terjadi sebuah kesalahan !');
        }

        redirect(base_url("order/detail/$id"));
    }
}

/* End of file Order.php */

?>