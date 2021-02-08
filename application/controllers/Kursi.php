<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kursi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $c_url = $this->router->fetch_class();
        $this->layout->auth(); 
        $this->layout->auth_privilege($c_url);
        $this->load->model('Kursi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kursi?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kursi?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kursi';
            $config['first_url'] = base_url() . 'kursi';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kursi_model->total_rows($q);
        $kursi = $this->Kursi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kursi_data' => $kursi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $data['title'] = 'Kursi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Kursi' => '',
        ];

        $data['page'] = 'kursi/kursi_list';
        $this->load->view('template/backend', $data);
    }

    public function read($id) 
    {
        $row = $this->Kursi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'id_tiket' => $row->id_tiket,
		'kode_kursi' => $row->kode_kursi,
	    );
        $data['title'] = 'Kursi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'kursi/kursi_read';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('kursi'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kursi/create_action'),
	    'id' => set_value('id'),
	    'id_tiket' => set_value('id_tiket'),
	    'kode_kursi' => set_value('kode_kursi'),
	);
        $data['title'] = 'Kursi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'kursi/kursi_form';
        $this->load->view('template/backend', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_tiket' => $this->input->post('id_tiket',TRUE),
		'kode_kursi' => $this->input->post('kode_kursi',TRUE),
	    );

            $this->Kursi_model->insert($data);
            $this->session->set_flashdata('success', 'Create Record Success');
            redirect(site_url('kursi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kursi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kursi/update_action'),
		'id' => set_value('id', $row->id),
		'id_tiket' => set_value('id_tiket', $row->id_tiket),
		'kode_kursi' => set_value('kode_kursi', $row->kode_kursi),
	    );
            $data['title'] = 'Kursi';
        $data['subtitle'] = '';
        $data['crumb'] = [
            'Dashboard' => '',
        ];

        $data['page'] = 'kursi/kursi_form';
        $this->load->view('template/backend', $data);
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('kursi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'id_tiket' => $this->input->post('id_tiket',TRUE),
		'kode_kursi' => $this->input->post('kode_kursi',TRUE),
	    );

            $this->Kursi_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('success', 'Update Record Success');
            redirect(site_url('kursi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kursi_model->get_by_id($id);

        if ($row) {
            $this->Kursi_model->delete($id);
            $this->session->set_flashdata('success', 'Delete Record Success');
            redirect(site_url('kursi'));
        } else {
            $this->session->set_flashdata('error', 'Record Not Found');
            redirect(site_url('kursi'));
        }
    }

    public function deletebulk(){
        $delete = $this->Kursi_model->deletebulk();
        if($delete){
            $this->session->set_flashdata('success', 'Delete Record Success');
        }else{
            $this->session->set_flashdata('error', 'Delete Record failed');
        }
        echo $delete;
    }
   
    public function _rules() 
    {
	$this->form_validation->set_rules('id_tiket', 'id tiket', 'trim|required');
	$this->form_validation->set_rules('kode_kursi', 'kode kursi', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kursi.php */
/* Location: ./application/controllers/Kursi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-02-08 10:20:36 */
/* http://harviacode.com */