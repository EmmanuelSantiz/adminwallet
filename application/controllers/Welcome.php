<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}
	
	public function index() {
		//echo $this->is_logged_in();
		if($this->session->userdata('id')) {
			$this->load->model('Model_super');
			$this->Model_super->setTabla('users');
			$respuesta['Usuarios'] = array();
			$this->load->template('welcome_message', $respuesta);
		} else {
			$this->load->view('layout/template_start');
			$this->load->view('login/login');
		}
	}

	public function getExistente() {
		if ($this->input->is_ajax_request()) {
			$respuesta['post'] = $this->security->xss_clean($this->input->post());
			$respuesta['data'] = $this->db->select('*')->get_where($respuesta['post']['tabla'], array('lower('.$respuesta['post']['campo'].')' => $respuesta['post']['valor']))->row();
			return retornoJson($respuesta);
		}
	}

	public function login() {
		if($this->input->is_ajax_request()) {
			$respuesta['post'] = $this->security->xss_clean($this->input->post());

			$user = $this->db->query("SELECT * FROM users WHERE char_email = '".strtolower($respuesta['post']['char_user'])."' AND char_password = MD5('".$respuesta['post']['char_password']."')")->row();

            if ($user) {
				$sessiondata = array('id' => $user->id);
				$this->session->set_userdata($sessiondata);
				$respuesta['data'] = TRUE;
            } else {
            	$respuesta['data'] = FALSE;
            }

			return retornoJson($respuesta);
		}
	}

	public function logout() {
		if($this->session->userdata('id')) {
			$array_items = array('is');
			$this->session->unset_userdata($array_items);
			$this->session->sess_destroy();
			//removeCache();
		}

		redirect('/');
	}

	public function configuracionScript() {
		if ($this->input->is_ajax_request()) {
			$respuesta['post'] = $this->input->post();
			$respuesta['get'] = $this->input->get();
			$respuesta['data'] = 'esto es el postGeneral';
			return retornoJson($respuesta);
		}
	}
}
