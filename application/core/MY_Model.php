<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table = '';
    protected $perPage = '5'; // limit perpage untuk pagination (defaultnya)

    public function __construct()
    {
        parent::__construct();
        
        if(!$this->table){
            $this->table = strtolower(
                str_replace('_model', '', get_class($this))
            );
        }
    }

    /**
    * Fungsi validasi input 
    * Rules : Dideklarasikan dalam masing - masing model
    */
    public function validate()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters(
            '<small class="text-form text-danger">', '</small>'
        );
        $validationRules = $this->getValidationRules(); // fungsi ini terdapat pada models nantinya

        $this->form_validation->set_rules($validationRules);

        return $this->form_validation->run();
    }

    // ==============================================================

    /** FUNGSI QUERY */
    
    /** Fungsi select = menampilkan field atau kolom pada sebuah data */
    public function select($colomns)
    {
        $this->db->select($colomns);
        return $this;
    }

    /** Fungsi where = digunakan untuk menampilkan data dengan kriteria yang lebih spesifik*/
    public function where($colomn, $condition)
    {
        $this->db->where($colomn, $condition);
        return $this;
    }

    /** Fungsi like = sama seperti where tapi tidak harus sama yang dicari*/
    public function like($colomn, $condition)
    {
        $this->db->like($colomn, $condition);
        return $this;
    }

    /** Fungsi or_like = sama seperti where tapi tidak harus sama yang dicari tapi dengan colomn yang berbeda*/
    public function or_like($colomn, $condition)
    {
        $this->db->or_like($colomn, $condition);
        return $this;
    }

    /** Fungsi join = untuk menggabungkan table (kebanyakan menggunakan join left) atau relasi antar table*/
    public function join($table, $type = 'left')
    {
        $this->db->join($table, "$this->table.id_$table = $table.id", $type); /**mencari kesamaan antar tabel dengan memanfaatkan foregn key */
        return $this;
    }

    /** Fungsi order_by = untuk mengurutkan data pada colomn yg sebagai jadi media peurutannya, defaultnya urutannya ialah ascending*/
    public function orderBy($colomn, $order = 'asc')
    {
        $this->db->order_by($colomn, $order);
        return $this;
    }

    /** Fungsi first = untuk menampilkan suatu hasil query hanya 1 nilai saja dan bertipekan objek */
    public function first()
    {
        return $this->db->get($this->table)->row();
    }

    /** Fungsi get = untuk menampilkan banyak data atau keseluruhan isi table dan bertipekan objek (bisa di ubah jadi array) */
    public function get()
    {
        return $this->db->get($this->table)->result();
    }

    /**  Fungsi count = untuk menampilkan isi jumlah data (biasa di pake untuk menghitung seluruh data pada saat membuat pagination)*/
    public function count()
    {
        return $this->db->count_all_results($this->table);
    }

    /** Fungsi create (insert) = untuk membuat 1 row data atau record (maybe)*/
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); //me return id yang kita dapatkan dari proses insert tersebut
    }

    /** Fungsi update = untuk merubah sebuah 1 record data, biasanya dibutuhkan suatu acuannya yaitu id(cek di MyWeb_model.php di fungsi updateArticle())*/
    public function update($data)
    {
        return $this->db->update($this->table, $data);
    }

    /** Fungsi delete = untuk menghapus data, bisa banyak data atau 1 saja tergantung acuannya */
    public function delete()
    {
        $this->db->delete($this->table);
        return $this->db->affected_rows(); // untuk mencari data mana yang di hapus
    }

    // ==============================================================

    /** Fungsi Pagination */

    public function paginate($page)
    {
        $this->db->limit(
            $this->perPage,
            $this->calculateRealOffset($page)
        );
        return $this;
    }

    public function calculateRealOffset($page)
    {
        if(is_null($page) || empty($page)){
            $offset = 0;
        }
        else {
            $offset = ($page * $this->perPage) - $this->perPage;
        }
        return $offset;
    }

    // uriSegment = merupakan segmen ke berapa yang memiliki nilai halaman, contoh home/produk/1 maka segmen segmen nilai "1" pada segmen ke 3
    // totalRows = ini akan di isikan dengan sebanyak jumlah data(total) yang di query yang akan di tampilkan, fungsi sudah dibuat yaitu count 
    public function makePagination($baseUrl, $uriSegment, $totalRows = null)
    {
        $this->load->library('pagination');

        $config = [
            'base_url'          => $baseUrl,
            'uri_segment'       => $uriSegment,
            'per_page'          => $this->perPage,
            'total_rows'        => $totalRows,
            'use_page_numbers'   => true,
            
            'full_tag_open'     => '<ul class="pagination">',
            'full_tag_close'    => '</ul>',
            'attributes'        => ['class' => 'page-link'],
            'first_link'        => false,
            'last_link'         => false,
            'first_tag_open'    => '<li class="page-item">',
            'first_tag_close'   => '</li>',
            'prev_link'         => '&laquo',
            'prev_tag_open'     => '<li class="page-item">',
            'prev_tag_close'    => '</li>',
            'next_link'         => '&raquo',
            'next_tag_open'     => '<li class="page-item">',
            'next_tag_close'    => '</li>',
            'last_tag_open'     => '<li class="page-item">',
            'last_tag_close'    => '</li>',
            'cur_tag_open'      => '<li class="page-item active"><a href="#" class="page-link">',
            'cur_tag_close'     => '<span class="sr-only">(current)</span></a></li>',
            'num_tag_open'      => '<li class="page-item">',
            'num_tag_close'     => '</li>'
        ];

        $this->pagination->initialize($config);
        return $this->pagination->create_links();        
    }
}

/* End of file MY_Model.php */


?>