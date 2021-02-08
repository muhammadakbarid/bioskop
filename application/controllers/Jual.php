<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jual extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth();
        $this->layout->auth_privilege($c_url);
        $this->load->model('Jual_model');
        $this->load->model('Penjualan_model');
        $this->load->model('Cart_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'jual?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'jual?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'jual';
            $config['first_url'] = base_url() . 'jual';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Jual_model->total_rows($q);
        $jual = $this->Jual_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jual_data' => $jual,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Jual';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Jual' => '',
        ];

        $data['page'] = 'jual/jual_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id)
    {
        $row = $this->Jual_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'id_penjualan' => $row->id_penjualan,
                'tgl_transaksi' => $row->tgl_transaksi,
                'id_tiket' => $row->id_tiket,
                'id_kursi' => $row->id_kursi,
                'harga' => $row->harga,
            );
            $data['title'] = 'Jual';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'jual/jual_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('jual'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jual/create_action'),
            'id' => set_value('id'),
            'id_penjualan' => set_value('id_penjualan'),
            'tgl_transaksi' => set_value('tgl_transaksi'),
            'id_tiket' => set_value('id_tiket'),
            'id_kursi' => set_value('id_kursi'),
            'harga' => set_value('harga'),
        );
        $data['title'] = 'Jual';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'jual/jual_form';
        $this->load->view('template/backend', $data);
    }

    public function checkout()
    {
        $data['keranjang'] = $this->Cart_model->get_all();
        $this->load->view('frontend/checkout', $data);
    }

    public function checkout_action()
    {

        $bukti_pembayaran = $_FILES['bukti_pembayaran'];
        if ($bukti_pembayaran == '') {
        } else {
            $config['upload_path'] = './assets/uploads/image/bukti/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']     = '2048';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_pembayaran')) {

                $bukti_pembayaran = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('jual/checkout');
            }
        }
        $total_pembayaran = $this->db->query("SELECT sum(harga) as total from cart")->row();
        $total_pembayaran = $total_pembayaran->total;
        $data_penjualan = array(
            'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
            'tgl_transaksi' => date('Y-m-d'),
            'bukti_pembayaran' => $bukti_pembayaran,
            'total_pembayaran' => $total_pembayaran,
            'status' => "Belum bayar",
        );

        $insert_id = $this->Penjualan_model->insert($data_penjualan);

        $keranjang = $this->Cart_model->get_all();

        foreach ($keranjang as $k) {
            $data_keranjang = array(
                'id_penjualan' => $insert_id,
                'tgl_transaksi' => $k->tgl_transaksi,
                'id_tiket' => $k->id_tiket,
                'id_kursi' => $k->id_kursi,
                'harga' => $k->harga,
            );

            $this->Jual_model->insert($data_keranjang);
        }

        $this->db->query("DELETE FROM CART");
        $this->session->set_flashdata('success', 'Create Record Success');
        redirect(site_url('penjualan'));
    }
}
