<?php 

    function getDropdownList($table, $colomns)
    {
        $CI =& get_instance(); // get_instance() memanggil core system dari ci, artinya memuat suatu class yang dimiliki ci tersebut misalnya memanggil library "db"
        $query = $CI->db->select($colomns)->from($table)->get();

        if($query->num_rows() >= 1){
            $option1 = ['' => '-Select-'];
            $option2 = array_column($query->result_array(), $colomns[1], $colomns[0]); // colomns[1] = yang di tampilkan atau seperti pada option1 yaitu "-Select-" sedangkan colomns[0] adalah key nya
            $options = $option1 + $option2;
            
            return $options;
        }
        return $options = ['' => '-Select-'];        
    }

    function getCategories() // fungsi ini untuk menampilkan kategori pada halaman home / index.php / html
    {
        
        $CI =& get_instance();
        $query = $CI->db->get('category')->result(); // 'category' adalah nama tabel yang akan dibuat nantinya
        return $query;
    }

    function getCart() // fungsi ini untuk menampilkan jumlah barang suatu user yang dimasukkan ke cart
    {
        $CI =& get_instance();
        $userId = $CI->session->userdata('id');

        if($userId){
            $query = $CI->db->where('id_user', $userId)->count_all_results('cart'); // 'cart' nama tabel yang akan dibuat nantinya
            return $query;
        }
        
        return false;
    }

    function hashEncrypt($input) // fungsi ini untuk mengamankan password user
    {
        $hash = password_hash($input, PASSWORD_DEFAULT);
        return $hash;
    }

    function hashEncryptVerify($input, $hash)
    {
        if(password_verify($input, $hash)){
            return true;
        }
        else {
            return false;
        }
    }
    
?>