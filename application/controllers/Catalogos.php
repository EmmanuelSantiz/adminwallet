<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_super');
        $this->load->library('form_validation');
	}
	
	public function Usuarios() {
        $configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_usuarios tcu');

            $params = array();
            $sql = 'tcu.*';

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

            $total_paginas = ($total < $configuracion['tabla']->int_registros) ? 1 : ceil($total / $configuracion['tabla']->int_registros);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}

		if($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
			$this->load->template('catalogos/usuarios', $respuesta);
		} else {
			redirect('/');
		}
	}

    public function FormularioUsuario($id = null) {
        $configuracion = config();
        $this->Model_super->setTabla('tbl_cat_usuarios tcu');

        $params = array();
        $sql = 'tcu.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($this->input->post()) {
            $data = $this->security->xss_clean($this->input->post());
            if (isset($data['char_password_actual']) == '') {
                unset($data['char_password_actual']);
            }
            if (isset($data['char_password_actual']) == '') {
                unset($data['char_password_nueva']);
            }
            if (isset($data['char_password_actual']) == '') {
                unset($data['char_password_confirmar']);
            }

            $this->form_validation->set_rules('char_user', 'Usuario', 'required|min_length[2]');
            $this->form_validation->set_rules('char_password_recordatorio', 'Recordatorio Password', 'required|min_length[2]');
            $this->form_validation->set_rules('char_nombres', 'Nombres (s)', 'required|min_length[2]');
            $this->form_validation->set_rules('char_app', 'Apellido Paterno', 'required|min_length[2]');
            $this->form_validation->set_rules('char_apm', 'Apellido Materno', 'required|min_length[2]');
            $this->form_validation->set_rules('tipoUsuario_id', 'Tipo de Usuario', 'required');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data['usuarios_id'] = $id;
                $this->Model_super->save($data);
                
                redirect('Catalogos/Usuarios');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

        if ($id) {
            $params[] = array('campo' => 'usuarios_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }

        if ($this->session->userdata('usuarios_id')) {
            //Arreglos Helper
            $this->Model_super->setTabla('tbl_cat_tipousuario tct');
            $respuesta['Catalogos']['TiposUsuarios'] = $this->Model_super->find('all', array('fields' => '*'));

            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/formularios/FormularioUsuario', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function TipoUsuarios() {
        $configuracion = config();
        if ($this->input->is_ajax_request()) {
            parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

            $numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_tipousuario tct');

            $params = array();
            $sql = 'tct.*';

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

            $total_paginas = ($total < 20) ? 1 : ceil($total / 20);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

            return retornoJson($respuesta);
        }

        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/tipousuarios', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function FormularioTipoUsuarios($id = null) {
        $configuracion = config();
        $this->Model_super->setTabla('tbl_cat_tipousuario tct');

        $params = array();
        $sql = 'tct.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($this->input->post()) {

            $this->form_validation->set_rules('char_tipoUsuario', 'Tipo de Usuario', 'required|min_length[2]');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
                $data['tipoUsuario_id'] = $id;
                $this->Model_super->save($data);

                redirect('Catalogos/TipoUsuarios');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

        if ($id) {
            $params[] = array('campo' => 'tipoUsuario_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }

        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/formularios/FormularioTipoUsuarios', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function Estatus() {
        $configuracion = config();
        if ($this->input->is_ajax_request()) {
            parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

            $numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_estatus tce');

            $params = array();
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

            $total_paginas = ($total < 20) ? 1 : ceil($total / 20);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

            return retornoJson($respuesta);
        }

        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/estatus', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function FormularioEstatus($id = null) {
        $configuracion = config();
        $this->Model_super->setTabla('tbl_cat_estatus tce');

        $params = array();
        $sql = 'tce.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;        

        if ($this->input->post()) {

            $this->form_validation->set_rules('char_nombre', 'Nombre del Estatus', 'required|min_length[2]');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
                $data['estatus_id'] = $id;
                $this->Model_super->save($data);

                redirect('Catalogos/Estatus');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

        if ($id) {
            $params[] = array('campo' => 'estatus_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }

        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/formularios/FormularioEstatus', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function Empresas() {
        $configuracion = config();

        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('catalogos/empresas', $respuesta);
        } else {
            redirect('/');
        }
    }
}
