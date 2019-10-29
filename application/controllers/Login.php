<?php
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    function index()
    {
        $this->load->view('header');
        $this->load->view('content/login');
    }

    function auth()
    {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $validate = $this->login_model->validate($username, $password);
            if ($validate->num_rows() > 0) {
                $data  = $validate->row_array();
                $name  = $data['nama'];
                $sesdata = array(
                    'nama'  => $name,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($sesdata);
                if (!empty($this->input->post('remember'))) {
                    setcookie("setUsername", $username, time() + (10 * 365 * 24 * 60 * 60));
                    setcookie("setPassword", $password, time() + (10 * 365 * 24 * 60 * 60));
                } else {
                    setcookie("setUsername", "");
                    setcookie("setPassword", "");
                }
                redirect('linked/graphic');
            }
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('linked');
    }
}
