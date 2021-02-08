<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tiket extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('Tiket_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tiket?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tiket?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tiket';
            $config['first_url'] = base_url() . 'tiket';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tiket_model->total_rows($q);
        $tiket = $this->Tiket_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tiket_data' => $tiket,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Tiket';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Tiket' => '',
        ];

        $data['page'] = 'tiket/tiket_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->Tiket_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama_kategori' => $row->nama_kategori,
		'harga' => $row->harga,
		'jumlah' => $row->jumlah,
	    );
        $data['title'] = 'Tiket';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'tiket/tiket_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('tiket'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tiket/create_action'),
	    'id' => set_value('id'),
	    'nama_kategori' => set_value('nama_kategori'),
	    'harga' => set_value('harga'),
	    'jumlah' => set_value('jumlah'),
	);
        $data['title'] = 'Tiket';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'tiket/tiket_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_kategori' => $this->input->post('nama_kategori',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
	    );

            $this->Tiket_model->insert($data);
            $this->session->set_flashdata('success', 'Create Record Success');
            redirect(site_url('tiket'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tiket_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tiket/update_action'),
		'id' => set_value('id', $row->id),
		'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
		'harga' => set_value('harga', $row->harga),
		'jumlah' => set_value('jumlah', $row->jumlah),
	    );
            $data['title'] = 'Tiket';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'tiket/tiket_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('tiket'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama_kategori' => $this->input->post('nama_kategori',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
	    );

            $this->Tiket_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('success', 'Update Record Success');
            redirect(site_url('tiket'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tiket_model->get_by_id($id);

        if ($row) {
            $this->Tiket_model->delete($id);
            $this->session->set_flashdata('success', 'Delete Record Success');
            redirect(site_url('tiket'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('tiket'));
        }
    }

    public function deletebulk(){
        $delete = $this->Tiket_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('success', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('nama_kategori', 'nama kategori', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tiket.php */
/* Location: ./application/controllers/Tiket.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-08 10:20:40 */
/* http://harviacode.com */