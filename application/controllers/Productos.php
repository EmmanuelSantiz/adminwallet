<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Model_super');
        $this->load->helper('url');
		$this->load->helper('form');
        $this->load->library('form_validation');
	}

	public function Productos() {
		$configuracion = config();
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);
			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;


	        $this->Model_super->setTabla('tbl_cat_productos tcp');
			$sql = 'tcp.*,tce.char_nombre as nombreEmpresa';

	        $params[] = array('type' => '');

        	$total = $this->Model_super->find('count',
            	array(
            		'conditions' => $params,
            		'fields' => $sql,
            		'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = tcp.empresa_id'), 'tbl_cat_empresas tce' => 'LEFT')
            		
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
                	'fields' => $sql,
            		'join' => array('clause' => array('tbl_cat_empresas tce' => 'tce.empresas_id = tcp.empresa_id'), 'tbl_cat_empresas tce' => 'LEFT')
                	
            	)
            );

		    $total_paginas = ($total < $configuracion['tabla']->int_registros) ? 1 : ceil($total / $configuracion['tabla']->int_registros);

            $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}    

		if ($this->session->userdata('usuarios_id')) {
            $respuesta['config'] = $configuracion;
            $this->load->template('productos/productos',$respuesta);
        } else {
            redirect('/');
        }
	}

	public function FormularioProductos($id = null) {
		$configuracion = config();
		$this->Model_super->setTabla('tbl_cat_empresas tce');

        $params = array();
        $sql = 'tce.*';

        $total = $this->Model_super->find('count',
            array(
                'conditions' => $params,
                'fields' => $sql
            )
        );

        $respuesta['empresas'] = $this->Model_super->find('all',
            array(
                'conditions' => $params,
                'limit' => array(),
                'order' => array(
                                'char_nombre',
                                'ASC'
                            ),
                'fields' => $sql,
            )
        );
        
		$this->Model_super->setTabla('tbl_cat_productos tcp');

        $params = array();
        $sql = 'tcp.*';

        $respuesta['data'] = null;
        $respuesta['id'] = $id;

        if ($this->input->post()) {

            $this->form_validation->set_rules('char_nombre', 'Nombre del prducto', 'required|min_length[2]');

            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length[2]', 'El campo %s debe tener mas de %s caracteres');

            if($this->form_validation->run() != false) {
                $data = $this->security->xss_clean($this->input->post());
                $data['producto_id'] = $id;
                $this->Model_super->save($data);

                redirect('Productos/Productos');
            } else {
                $respuesta["mensaje"] = "Validación incorrecta";
            }
        }

		if ($id) {
            $params[] = array('campo' => 'tcp.producto_id', 'value' => $id, 'type' => 'where');
            $respuesta['data'] = $this->Model_super->find('first', array('conditions' => $params, 'fields' => $sql));
        }

        if ($this->session->userdata('usuarios_id')) {
            //Arreglos Helper

            $respuesta['config'] = $configuracion;
            $this->load->template('Productos/formularios/FormularioProducto', $respuesta);
        } else {
            redirect('/');
        }
	}
}	