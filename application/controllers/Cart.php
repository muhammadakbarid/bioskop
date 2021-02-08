<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Cart_model');
        $this->load->library('form_validation');
    }


    public function keranjang()
    {
        $data['keranjang'] = $this->Cart_model->get_all();
        $this->load->view('cart/cart_list', $data);
    }



    public function create_action($id_kursi, $id_tiket, $harga)
    {



        $data = array(
            'tgl_transaksi' => date('Y-m-d'),
            'id_tiket' => $id_tiket,
            'id_kursi' => $id_kursi,
            'harga' => $harga,
        );

        $this->Cart_model->insert($data);
        $this->session->set_flashdata('success', 'Create Record Success');
        redirect(site_url('frontend'));
    }
}
