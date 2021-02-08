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

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'cart?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'cart?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'cart';
            $config['first_url'] = base_url() . 'cart';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cart_model->total_rows($q);
        $cart = $this->Cart_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cart_data' => $cart,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Cart';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Cart' => '',
        ];

        $data['page'] = 'cart/cart_list';
        $this->load->view('template/backend', $data);
    }

    public function keranjang()
    {
        $data['keranjang'] = $this->Cart_model->get_all();
        $this->load->view('cart/cart_list', $data);
    }

    public function read($id)
    {
        $row = $this->Cart_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'tgl_transaksi' => $row->tgl_transaksi,
                'id_tiket' => $row->id_tiket,
                'id_kursi' => $row->id_kursi,
            );
            $data['title'] = 'Cart';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'cart/cart_read';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('cart'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('cart/create_action'),
            'id' => set_value('id'),
            'tgl_transaksi' => set_value('tgl_transaksi'),
            'id_tiket' => set_value('id_tiket'),
            'id_kursi' => set_value('id_kursi'),
        );
        $data['title'] = 'Cart';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'cart/cart_form';
        $this->load->view('template/backend', $data);
    }

    public function create_action($id_kursi, $id_tiket, $harga)
    {
        $this->_rules();


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

    public function update($id)
    {
        $row = $this->Cart_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('cart/update_action'),
                'id' => set_value('id', $row->id),
                'tgl_transaksi' => set_value('tgl_transaksi', $row->tgl_transaksi),
                'id_tiket' => set_value('id_tiket', $row->id_tiket),
                'id_kursi' => set_value('id_kursi', $row->id_kursi),
            );
            $data['title'] = 'Cart';
            $data['subtitle'] = '';
            $data['crumb'] = [
                'Dashboard' => '',
            ];

            $data['page'] = 'cart/cart_form';
            $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('cart'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'tgl_transaksi' => $this->input->post('tgl_transaksi', TRUE),
                'id_tiket' => $this->input->post('id_tiket', TRUE),
                'id_kursi' => $this->input->post('id_kursi', TRUE),
            );

            $this->Cart_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('success', 'Update Record Success');
            redirect(site_url('cart'));
        }
    }

    public function delete($id)
    {
        $row = $this->Cart_model->get_by_id($id);

        if ($row) {
            $this->Cart_model->delete($id);
            $this->session->set_flashdata('success', 'Delete Record Success');
            redirect(site_url('cart'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('cart'));
        }
    }

    public function deletebulk()
    {
        $delete = $this->Cart_model->deletebulk();
        if ($delete) {
            $this->session->set_flashdata('success', 'Delete Record Success');
        } else {
            $this->session->set_flashdata('error', 'Delete Record failed');
        }
        echo $delete;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('tgl_transaksi', 'tgl transaksi', 'trim|required');
        $this->form_validation->set_rules('id_tiket', 'id tiket', 'trim|required');
        $this->form_validation->set_rules('id_kursi', 'id kursi', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-08 10:20:30 */
/* http://harviacode.com */