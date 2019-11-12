<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mproduct');
        $this->load->model('Mprofit');
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
    }
    public function index()
    {
        $config['base_url'] = site_url('profit/index/');
        $config['total_rows'] = $this->db->count_all('barang');
        $config['per_page'] = 4;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data_product'] = $this->Mproduct->getData($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('header');
        $this->load->view('content/profit', $data);
        $this->load->view('footer');
    }

    public function Penjualan()
    {
        $id = $this->input->post('id');
        $current_stock = $this->input->post('current_stock');
        $sold = $this->input->post('sold_stock');
        $current_time = date_now();

        if ($sold > $current_stock) {
            $this->session->set_flashdata('error', 'Stok Tidak Mencukupi');
            redirect('profit/');
        } else {
            $stock = $current_stock - $sold;
            $data_penjualan = array(
                'id_barang' => $id,
                'date_penjualan' => $current_time,
                'stock' => $sold
            );

            $data_barang = array(
                'stok' => $stock
            );

            $where = array(
                'idbarang' => $id
            );

            $this->Mproduct->editData($data_barang, $where);
            $this->Mprofit->addDataPenjualan($data_penjualan);
            $this->session->set_flashdata('pesan', 'Data Berhasil Diubah');
            redirect('profit/');
        }
    }

    public function Pembelian()
    {
        $id = $this->input->post('id');
        $current_stock = $this->input->post('current_stock');
        $add = $this->input->post('add_stock');
        $current_time = date_now();
        $stock = $current_stock + $add;

        $data_pembelian = array(
            'id_barang' => $id,
            'date_pembelian' => $current_time,
            'stock' => $add
        );

        $data_barang = array(
            'stok' => $stock
        );

        $where = array(
            'idbarang' => $id
        );

        $this->Mproduct->editData($data_barang, $where);
        $this->Mprofit->addDataPembelian($data_pembelian);
        $this->session->set_flashdata('pesan', 'Data Berhasil Diubah');
        redirect('profit/');
        }
}