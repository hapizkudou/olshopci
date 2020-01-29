<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

    public function sortBy($sort, $page=null)
    {
        $data['title']      = 'Shop';
        $data['content']    = $this->shop->select(
            [
                'product.id', 'product.title AS product_title', 'product.price', 'product.is_available', 'product.description', 'product.image', 'category.title AS category_title', 'category.slug AS category_slug'
            ]
        )->join('category')
        ->where('product.is_available', 1)
        ->orderBy('product.price', $sort)
        ->paginate($page)->get();
        $data['total_rows'] = $this->shop->where('product.is_available', 1)->count();
        $data['pagination'] = $this->shop->makePagination(base_url("shop/sortBy/$sort"), 4, $data['total_rows']);
        $data['page']       = 'pages/home/index';
        $data['tags']       = '0';

        $this->view($data);
    }

    public function category($category, $page=null)
    {
        $data['title']      = 'Kategori';
        $data['content']    = $this->shop->select(
            [
                'product.id', 'product.title AS product_title', 'product.price', 'product.is_available', 'product.description', 'product.image', 'category.title AS category_title', 'category.slug AS category_slug'
            ]
        )->join('category')
        ->where('product.is_available', 1)
        ->where('category.slug', $category)
        ->paginate($page)->get();

        $data['total_rows'] = $this->shop->where('product.is_available', 1)
        ->where('category.slug', $category)
        ->join('category')
        ->count();
        
        $data['pagination'] = $this->shop->makePagination(base_url("shop/category/$category"), 4, $data['total_rows']);
        $data['category']   = $this->shop->where('category.slug', $category)->join('category')->first();
        $data['page']       = 'pages/home/index';
        $data['tags']       = '0';

        $this->view($data);
    }

    public function search($page = null) // tambahkan pencarian tidak hanya dari title tapi dari deskripsi juga
    {
        if(isset($_POST['keyword'])){
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword            = $this->session->userdata('keyword');
        $data['title']      = 'Shop';
        $data['content']    = $this->shop->select(
            [
                'product.id', 'product.title AS product_title', 'product.price', 'product.is_available', 'product.description', 'product.image', 'category.title AS category_title', 'category.slug AS category_slug'
            ]
        )->join('category')
        ->like('product.title', $keyword)
        ->or_like('product.description', $keyword)
        ->paginate($page)->get();
        $data['total_rows'] = $this->shop->like('product.title', $keyword)->or_like('product.description', $keyword)->count();
        $data['pagination'] = $this->shop->makePagination(base_url('shop/search'), 3, $data['total_rows']);
        $data['page'] = 'pages/home/index';
        $data['tags'] = '0';

        $this->view($data);
    }

    public function reset()
    {
        $this->session->unset_userdata('keyword');
        redirect(base_url('/'));
    }
}

/* End of file Shop.php */

?>