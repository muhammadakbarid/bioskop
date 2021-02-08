<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('Penjualan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'penjualan?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'penjualan?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'penjualan';
            $config['first_url'] = base_url() . 'penjualan';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Penjualan_model->total_rows($q);
        $penjualan = $this->Penjualan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'penjualan_data' => $penjualan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Penjualan' => '',
        ];

        $data['page'] = 'penjualan/penjualan_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->Penjualan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama_pelanggan' => $row->nama_pelanggan,
		'tgl_transaksi' => $row->tgl_transaksi,
		'bukti_pembayaran' => $row->bukti_pembayaran,
		'total_pembayaran' => $row->total_pembayaran,
		'status' => $row->status,
	    );
        $data['title'] = 'Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'penjualan/penjualan_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('penjualan/create_action'),
	    'id' => set_value('id'),
	    'nama_pelanggan' => set_value('nama_pelanggan'),
	    'tgl_transaksi' => set_value('tgl_transaksi'),
	    'bukti_pembayaran' => set_value('bukti_pembayaran'),
	    'total_pembayaran' => set_value('total_pembayaran'),
	    'status' => set_value('status'),
	);
        $data['title'] = 'Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'penjualan/penjualan_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'tgl_transaksi' => $this->input->post('tgl_transaksi',TRUE),
		'bukti_pembayaran' => $this->input->post('bukti_pembayaran',TRUE),
		'total_pembayaran' => $this->input->post('total_pembayaran',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Penjualan_model->insert($data);
            $this->session->set_flashdata('success', 'Create Record Success');
            redirect(site_url('penjualan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penjualan/update_action'),
		'id' => set_value('id', $row->id),
		'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
		'tgl_transaksi' => set_value('tgl_transaksi', $row->tgl_transaksi),
		'bukti_pembayaran' => set_value('bukti_pembayaran', $row->bukti_pembayaran),
		'total_pembayaran' => set_value('total_pembayaran', $row->total_pembayaran),
		'status' => set_value('status', $row->status),
	    );
            $data['title'] = 'Penjualan';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'penjualan/penjualan_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'tgl_transaksi' => $this->input->post('tgl_transaksi',TRUE),
		'bukti_pembayaran' => $this->input->post('bukti_pembayaran',TRUE),
		'total_pembayaran' => $this->input->post('total_pembayaran',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Penjualan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('success', 'Update Record Success');
            redirect(site_url('penjualan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $this->Penjualan_model->delete($id);
            $this->session->set_flashdata('success', 'Delete Record Success');
            redirect(site_url('penjualan'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function deletebulk(){
        $delete = $this->Penjualan_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('success', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'trim|required');
	$this->form_validation->set_rules('tgl_transaksi', 'tgl transaksi', 'trim|required');
	$this->form_validation->set_rules('bukti_pembayaran', 'bukti pembayaran', 'trim|required');
	$this->form_validation->set_rules('total_pembayaran', 'total pembayaran', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Penjualan.php */
/* Location: ./application/controllers/Penjualan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-08 12:03:26 */
/* http://harviacode.com */