<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_super');
        $this->load->helper('url', 'form');
		$this->load->library('form_validation');
	}

	public function Empresas() {
		$configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_empresas tce');
            $params = array();

            if (is_admin()) {
            	$sql = 'tce.*';
            	$total = $this->Model_super->find('count',
	            	array(
	            		'conditions' => $params,
	            		'fields' => $sql
	            	)
	            );

	            $respuesta['data'] = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	            		'limit' => array(
	            						$respuesta['post']['fin'],
	            						$respuesta['post']['inicio']
	            					),
	                	'order' => array(
	                					$respuesta['post']['orden']['tipo'],
	                					$respuesta['post']['orden']['order']
	                				),
	                	'fields' => $sql,
	            	)
	            );
            } else {
            	$sql = 'tce.*, tue.*';
            	$params[] = array('campo' => 'tcu.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');

            	$total = $this->Model_super->find('count',
	            	array(
	            		'conditions' => $params,
	            		'fields' => $sql,
	            		'join' => array('clause' => array('tbl_usuarios_empresas tue' => 'tue.empresas_id = tce.empresas_id', 'tbl_cat_usuarios tcu' => 'tcu.usuarios_id = tue.usuarios_id'), 'tbl_usuarios_empresas tue' => 'LEFT', 'tbl_cat_usuarios tcu' => 'LEFT')
	            	)
	            );

	            $respuesta['data'] = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	            		'limit' => array(
	            						$respuesta['post']['fin'],
	            						$respuesta['post']['inicio']
	            					),
	                	'order' => array(
	                					$respuesta['post']['orden']['tipo'],
	                					$respuesta['post']['orden']['order']
	                				),
	                	'fields' => $sql,
	                	'join' => array('clause' => array('tbl_usuarios_empresas tue' => 'tue.empresas_id = tce.empresas_id', 'tbl_cat_usuarios tcu' => 'tcu.usuarios_id = tue.usuarios_id'), 'tbl_usuarios_empresas tue' => 'LEFT', 'tbl_cat_usuarios tcu' => 'LEFT')
	            	)
	            );
            }
            

            $total_paginas = ($total < $configuracion['tabla']->int_registros) ? 1 : ceil($total / $configuracion['tabla']->int_registros);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}

		if ($this->session->userdata('usuarios_id')) {
			$respuesta['config'] = $configuracion;
            $this->load->template('general/empresas', $respuesta);
        } else {
            redirect('/');
        }
	}

	public function FormularioEmpresa($id = null) {
		$configuracion = config();
		$this->Model_super->setTabla('tbl_cat_empresas tce');

        $params = array();
        $sql = 'tce.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($this->input->post()) {

        	$this->form_validation->set_rules('char_nombre', 'Nombre', 'required|min_length[2]');

        	$this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
	            $data['empresas_id'] = $id;
	            $this->Model_super->save($data);

	            redirect('General/Empresas');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

		if ($id) {
            $params[] = array('campo' => 'tce.empresas_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));

            if (!$respuesta['data']) {
            	$this->session->set_flashdata('message', 'NO EXISTEN DATOS CON ESTE IDENTIFIADOR: '.$id);
            	redirect($this->router->fetch_class().'/Clientes');
            }
        }

        if ($this->session->userdata('usuarios_id')) {
            //Arreglos Helper

            $respuesta['config'] = $configuracion;
            $this->load->template('general/formularios/FormularioEmpresa', $respuesta);
        } else {
            redirect('/');
        }
	}

	public function Sucursales() {
		$configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_sucursales ts');
            $params = array();

            if (is_admin()) {
            	$sql = 'ts.*, tce.char_nombre AS empresa';
            	$total = $this->Model_super->find('count',
	            	array(
	            		'conditions' => $params,
	            		'fields' => $sql,
	                	'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = ts.empresas_id'), 'tbl_cat_empresas tce' => 'INNER')
	            	)
	            );

	            $respuesta['data'] = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	            		'limit' => array(
	            						$respuesta['post']['fin'],
	            						$respuesta['post']['inicio']
	            					),
	                	'order' => array(
	                					$respuesta['post']['orden']['tipo'],
	                					$respuesta['post']['orden']['order']
	                				),
	                	'fields' => $sql,
	                	'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = ts.empresas_id'), 'tbl_cat_empresas tce' => 'INNER')
	            	)
	            );
            } else {
            	$sql = 'ts.*, tce.char_nombre AS empresa';
            	$params[] = array('campo' => 'tcu.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');

            	$total = $this->Model_super->find('count',
	            	array(
	            		'conditions' => $params,
	            		'fields' => $sql,
	            		'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = ts.empresas_id', 'tbl_usuarios_empresas tue' => 'tue.empresas_id = tce.empresas_id', 'tbl_cat_usuarios tcu' => 'tcu.usuarios_id = tue.usuarios_id'), 'tbl_cat_empresas tce' => 'INNER', 'tbl_usuarios_empresas tue' => 'LEFT', 'tbl_cat_usuarios tcu' => 'LEFT')
	            	)
	            );

	            $respuesta['data'] = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	            		'limit' => array(
	            						$respuesta['post']['fin'],
	            						$respuesta['post']['inicio']
	            					),
	                	'order' => array(
	                					$respuesta['post']['orden']['tipo'],
	                					$respuesta['post']['orden']['order']
	                				),
	                	'fields' => $sql,
	                	'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = ts.empresas_id', 'tbl_usuarios_empresas tue' => 'tue.empresas_id = tce.empresas_id', 'tbl_cat_usuarios tcu' => 'tcu.usuarios_id = tue.usuarios_id'), 'tbl_cat_empresas tce' => 'INNER', 'tbl_usuarios_empresas tue' => 'LEFT', 'tbl_cat_usuarios tcu' => 'LEFT')
	            	)
	            );
            }
            

            $total_paginas = ($total < $configuracion['tabla']->int_registros) ? 1 : ceil($total / $configuracion['tabla']->int_registros);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}

		if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('general/sucursales', $respuesta);
        } else {
            redirect('/');
        }
	}

	public function FormularioSucursal($id = null) {
		$configuracion = config();
		$this->Model_super->setTabla('tbl_sucursales ts');

        $params = array();
        $sql = 'ts.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($this->input->post()) {

        	$this->form_validation->set_rules('empresas_id', 'Empresa', 'required');
            $this->form_validation->set_rules('char_nombre', 'Nombre', 'required|min_length[2]|trim');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
            	$data['sucursales_id'] = $id;
            	$this->Model_super->save($data);

            	redirect('General/Sucursales');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

		if ($id) {
            $params[] = array('campo' => 'ts.sucursales_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }
		
		if ($this->session->userdata('usuarios_id')) {
			$respuesta['empresas'] = $this->db->get_where('tbl_cat_empresas')->result();
			$respuesta['config'] = $configuracion;
			$this->load->template('general/formularios/FormularioSucursal', $respuesta);
		} else {
			redirect('/');
		}
	}

	public function Empleados() {
		$configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_empleados tce');
            $params = array();


            $sql = 'tce.*, tcempresa.char_nombre AS empresa';
        	$total = $this->Model_super->find('count',
            	array(
            		'conditions' => $params,
            		'fields' => $sql,
                	'join' => array('clause' => array('tbl_cat_empresas tcempresa' => 'tcempresa.empresas_id = tce.empresas_id'), 'tbl_cat_empresas tcempresa' => 'INNER')
            	)
            );

            $respuesta['data'] = $this->Model_super->find('all',
            	array(
            		'conditions' => $params,
            		'limit' => array(
            						$respuesta['post']['fin'],
            						$respuesta['post']['inicio']
            					),
                	'order' => array(
                					$respuesta['post']['orden']['tipo'],
                					$respuesta['post']['orden']['order']
                				),
                	'fields' => $sql,
                	'join' => array('clause' => array('tbl_cat_empresas tcempresa' => 'tcempresa.empresas_id = tce.empresas_id'), 'tbl_cat_empresas tcempresa' => 'INNER')
            	)
            );            

            $total_paginas = ($total < $configuracion['tabla']->int_registros) ? 1 : ceil($total / $configuracion['tabla']->int_registros);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}

		if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('general/empleados', $respuesta);
        } else {
            redirect('/');
        }
	}

	public function FormularioEmpleado($id = null) {
		$configuracion = config();
		$this->Model_super->setTabla('tbl_cat_empleados tce');

		$params = array();
		$sql = 'tce.*';

		$respuesta['data'] = null;
		$respuesta['id'] = $id;

		if ($this->input->post()) {

            $this->form_validation->set_rules('empresas_id', 'Empresa', 'required');
            $this->form_validation->set_rules('char_nombres', 'Nombre', 'required|min_length[2]|trim');
            $this->form_validation->set_rules('char_ape_pat', 'Apellido Paterno', 'required|min_length[3]|trim');
            $this->form_validation->set_rules('char_ape_mat', 'Apellido Materno', 'required|min_length[3]|trim');
             
            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[3]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
				$data['empleados_id'] = $id;
				$this->Model_super->save($data);

				redirect('General/Empleados');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
		}

		if ($id) {
			$params[] = array('campo' => 'tce.empleados_id', 'value' => $id, 'type' => 'where');
			$respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
		}

		if ($this->session->userdata('usuarios_id')) {
			$respuesta['empresas'] = $this->db->get_where('tbl_cat_empresas')->result();
			$respuesta['config'] = $configuracion;
			$this->load->template('general/formularios/FormularioEmpleado', $respuesta);
		} else {
			redirect('/');
		}
	}
}