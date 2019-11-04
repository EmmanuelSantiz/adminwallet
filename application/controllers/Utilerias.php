<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilerias extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_super');
        $this->load->library('form_validation');
	}
	
	public function Sistemas() {
        $configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

            $this->Model_super->setTabla('tbl_cat_sistemas tcs');

            $params = array();
            $sql = 'tcs.*';

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
            $this->load->template('utilerias/sistemas', $respuesta);
        } else {
            redirect('/');
        }
	}

    public function FormularioSistema($id = null) {
        $this->Model_super->setTabla('tbl_cat_sistemas tcs');

        $params = array();
        $sql = 'tcs.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($id) {
            $params[] = array('campo' => 'sistemas_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }

        if ($this->input->post()) {
            $data = $this->security->xss_clean($this->input->post());
            $data['sistemas_id'] = $id;
            $this->Model_super->save($data);

            redirect('Utilerias/Sistemas');
        }

        if ($this->session->userdata('usuarios_id')) {
            $this->load->template('utilerias/formularios/FormularioSistema', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function Menus() {
        $configuracion = config();
        if($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('utilerias/menus', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function Tablas() {
        $configuracion = config();
        if($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('utilerias/tablas', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function FormularioTabla($id = null) {
        $configuracion = config();

        if ($this->input->is_ajax_request()) {
            $respuesta['post'] = $this->input->post();
            $tt = $this->db->get_where('tbl_cat_menus', array('menus_id' => $respuesta['post']['menus_id']))->row();
            $url = $tt ? $tt->char_url : null;
            $respuesta['data'] = $this->db->insert('tbl_cat_tablas', array('tablas_id' => null, 'char_nombre' => '', 'menus_id' => $respuesta['post']['menus_id'], 'char_ubicacion' => $url, 'int_registros' => 10, 'int_paginas' => 5, 'usuarios_id' => user_info()->usuarios_id));
            return retornoJson($respuesta);
        }

        if ($this->session->userdata('usuarios_id')) {
            $this->Model_super->setTabla('tbl_cat_tablas tct');
            $sql = 'tct.*';
            $params[] = array('campo' => 'tct.tablas_id', 'value' => $id, 'type' => 'where');

            $respuesta['config'] = $configuracion;
            $respuesta['data'] = $this->Model_super->find('first',
                    array(
                        'conditions' => $params,
                        'fields' => $sql
                    )
            );

            $this->load->template('utilerias/formularios/FormularioTabla', $respuesta);
        } else {
            redirect('/');
        }

        if ($this->input->post()) {

            $this->form_validation->set_rules('char_nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('char_nombre', 'int_registros', 'required');
            $this->form_validation->set_rules('char_nombre', 'int_paginas', 'required');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
                $tabla = $this->db->get_where('tbl_cat_tablas', array('tablas_id' => $id))->row();
                $data['tablas_id'] = $id;
                $this->Model_super->save($data);

                redirect('Utilerias/Tablas');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }
    }

    public function Formularios() {
        $configuracion = config();
        if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('utilerias/formularios', $respuesta);
        } else {
            redirect('/');
        }
    }

    public function crear_formulario() {
        if ($this->input->is_ajax_request()) {
            $respuesta['post'] = $this->input->post();
            $respuesta['post']['char_url'] = substr($respuesta['post']['char_url'], -1) == 's' || substr($respuesta['post']['char_url'], -1) == 'S' ? substr($respuesta['post']['char_url'], 0, -1) : $respuesta['post']['char_url'];
            $name = explode('/', $respuesta['post']['char_url']);
            $this->db->insert('tbl_cat_formularios', array('char_nombre' => 'Formulario'.$name[1], 'char_ubicacion' => $name[0].'/Formulario'.$name[1], 'usuarios_id' => user_info()->usuarios_id, 'char_class' => 'form-horizontal', 'char_method' => 1));
            $formularios_id = $this->db->insert_id();
            $this->db->update('tbl_cat_menus', array('formularios_id' => $formularios_id), array('menus_id' => $respuesta['post']['menus_id']));
            return retornoJson($respuesta);
        }
    }
}
