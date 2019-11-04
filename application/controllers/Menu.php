<?php
/**
 * InicioController.php
 *
 * Author: Emmanuel Santiz
 *
 * Menu
 *
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Model_super');
	}

	/**
	 * Funcion que se encarga de obtener los menus del usuario,
	 * @param
	 * @return objeto Json.
	*/
	public function get_menu() {
		if($this->input->is_ajax_request()) {
			$menus = array();
			$join = array('clause');

			$this->Model_super->setTabla('tbl_cat_menus tcm');
        	$sql = 'tcm.menus_id, tcm.char_nombre, tcm.text_descripcion, tcm.int_orden, tcm.char_icon, tcm.char_url';

        	$params[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
			$params[] = array('campo' => 'tcm.id_padre', 'value' => NULL, 'type' => 'where');
			$params[] = array('campo' => 'tcm.int_nivel', 'value' => NULL, 'type' => 'where');
			
			if(!is_admin()) {
				//Colocar mas filtros para usuarios no adminitradores
				$params[] = array('campo' => 'tp.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');

				$menus = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	                	'order' => array('tcm.int_orden', 'ASC'),
	                	'fields' => $sql,
	                	'join' => array('clause' => array(
	                		'tbl_permisos tp' => 'tp.menus_id = tcm.menus_id'), 'tbl_permisos tp' => 'INNER')
	            	)
	        	);

			} else {
				$menus = $this->Model_super->find('all',
	            	array(
	            		'conditions' => $params,
	                	'order' => array('tcm.int_orden', 'ASC'),
	                	'fields' => $sql
	            	)
	        	);
			}

	        if ($menus) {
	        	foreach($menus as $padres => $obj) {
	        		$paramsN1 = array();
	        		$paramsN1[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
	        		$paramsN1[] = array('campo' => 'tcm.id_padre', 'value' => $obj->menus_id, 'type' => 'where');
	        		$paramsN1[] = array('campo' => 'tcm.int_nivel', 'value' => 1, 'type' => 'where');

	        		if(!is_admin()) {
						$paramsN1[] = array('campo' => 'tp.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');

						$menus[$padres]->nivel = $this->Model_super->find('all',
		        			array(
		        				'conditions' => $paramsN1,
		        				'order' => array('int_orden', 'ASC'),
		        				'fields' => $sql,
		        				'join' => array('clause' => array(
		                			'tbl_permisos tp' => 'tp.menus_id = tcm.menus_id'), 'tbl_permisos tp' => 'INNER')
		        			)
		        		);
					} else {
						$menus[$padres]->nivel = $this->Model_super->find('all',
		        			array(
		        				'conditions' => $paramsN1,
		        				'order' => array('int_orden', 'ASC'),
		        				'fields' => $sql
		        			)
		        		);
					}	        		

	        		if ($menus[$padres]->nivel) {
		        		foreach($menus[$padres]->nivel as $nivel1 => $obj1) {
		        			$paramsN2 = array();
	        				$paramsN2[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
	        				$paramsN2[] = array('campo' => 'tcm.id_padre', 'value' => $obj1->menus_id, 'type' => 'where');
	        				$paramsN2[] = array('campo' => 'tcm.int_nivel', 'value' => 2, 'type' => 'where');

	        				if(!is_admin()) {
								$paramsN2[] = array('campo' => 'tp.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');
								
								$menus[$padres]->nivel[$nivel1]->nivel = $this->Model_super->find('all',
			        				array(
			        					'conditions' => $paramsN2,
			       						'order' => array('int_orden', 'ASC'),
			       						'fields' => $sql,
			       						'join' => array('clause' => array(
		                					'tbl_permisos tp' => 'tp.menus_id = tcm.menus_id'), 'tbl_permisos tp' => 'INNER')
			       					)
			       				);
							} else {
			        			$menus[$padres]->nivel[$nivel1]->nivel = $this->Model_super->find('all',
			        				array(
			        					'conditions' => $paramsN2,
			       						'order' => array('int_orden', 'ASC'),
			       						'fields' => $sql
			       					)
			       				);
			        		}

		       				if ($menus[$padres]->nivel[$nivel1]->nivel) {
		        				foreach($menus[$padres]->nivel[$nivel1]->nivel as $nivel2 => $obj2) {
		        					$paramsN3 = array();
			        				$paramsN3[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
			        				$paramsN3[] = array('campo' => 'tcm.id_padre', 'value' => $obj2->menus_id, 'type' => 'where');
			        				$paramsN3[] = array('campo' => 'tcm.int_nivel', 'value' => 3, 'type' => 'where');

			        				if(!is_admin()) {
			        					$paramsN3[] = array('campo' => 'tp.usuarios_id', 'value' => user_info()->usuarios_id, 'type' => 'where');

										$menus[$padres]->nivel[$nivel1]->nivel[$nivel2]->nivel = $this->Model_super->find('all',
			        						array(
			        							'conditions' => $paramsN3,
			       								'order' => array('int_orden', 'ASC'),
			       								'fields' => $sql,
			       								'join' => array('clause' => array(
		                							'tbl_permisos tp' => 'tp.menus_id = tcm.menus_id'), 'tbl_permisos tp' => 'INNER')
			       							)
			       						);
									} else {
			        					$menus[$padres]->nivel[$nivel1]->nivel[$nivel2]->nivel = $this->Model_super->find('all',
			        						array(
			        							'conditions' => $paramsN3,
			       								'order' => array('int_orden', 'ASC'),
			       								'fields' => $sql
			       							)
			       						);
			        				}
		       					}
		       				}
		       			}
		       		}
	        	}
	        }

	        $respuesta['data'] = $menus;
			return retornoJson($respuesta);
		}
		redirect('/');
	}

	public function get_menus_tablas() {
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

			$menus = array();

			$this->Model_super->setTabla('tbl_cat_menus tcm');
        	$sql = 'tcm.menus_id, tcm.char_nombre, tcm.text_descripcion, tcm.int_orden, tcm.char_icon, tcm.char_url, tct.tablas_id, tcm.formularios_id';

        	$params[] = array('campo' => 'tcm.char_url != ', 'value' => ' ', 'type' => 'where');
			
			if(!is_admin()) {
				//Colocar mas filtros para usuarios no adminitradores
			}

	        $total = $this->Model_super->find('count',
            	array(
            		'conditions' => $params,
            		'fields' => $sql,
            		'join' => array('clause' => array('tbl_cat_tablas tct' => 'tct.menus_id = tcm.menus_id', 'tbl_cat_formularios tcf' => 'tcf.formularios_id = tcm.formularios_id'), 'tbl_cat_tablas tct' => 'LEFT')
            	)
            );

            //dd($respuesta);

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
                	'join' => array('clause' => array('tbl_cat_tablas tct' => 'tct.menus_id = tcm.menus_id'), 'tbl_cat_tablas tct' => 'LEFT')
            	)
            );

	        $total_paginas = ($total < $cantidad) ? 1 : ceil($total / $cantidad);
	        $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

			return retornoJson($respuesta);
		}
	}

	public function get_menu_usuarios($usuarios_id) {
		if($this->input->is_ajax_request()) {
			$menus = array();
			$join = array('clause');

			$this->Model_super->setTabla('tbl_cat_menus tcm');
        	$sql = 'tcm.menus_id, tcm.char_nombre, tcm.char_icon';

        	$params[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
			$params[] = array('campo' => 'tcm.id_padre', 'value' => NULL, 'type' => 'where');
			$params[] = array('campo' => 'tcm.int_nivel', 'value' => NULL, 'type' => 'where');
			
			$menus = $this->Model_super->find('all',
            	array(
            		'conditions' => $params,
                	'order' => array('tcm.int_orden', 'ASC'),
                	'fields' => $sql
            	)
        	);

	        if ($menus) {
	        	foreach($menus as $padres => $obj) {
	        		$existe = $this->db->get_where('tbl_permisos', array('usuarios_id' => $usuarios_id, 'menus_id' => $obj->menus_id))->row();

	        		$menus[$padres]->encontrado = $existe ? TRUE : FALSE;

	        		$paramsN1 = array();
	        		$paramsN1[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
	        		$paramsN1[] = array('campo' => 'tcm.id_padre', 'value' => $obj->menus_id, 'type' => 'where');
	        		$paramsN1[] = array('campo' => 'tcm.int_nivel', 'value' => 1, 'type' => 'where');

					$menus[$padres]->nivel = $this->Model_super->find('all',
	        			array(
	        				'conditions' => $paramsN1,
	        				'order' => array('int_orden', 'ASC'),
	        				'fields' => $sql,
	        			)
	        		);

	        		//var_dump($menus[$padres]->nivel);

	        		if ($menus[$padres]->nivel) {
		        		foreach($menus[$padres]->nivel as $nivel1 => $obj1) {
		        			$existe = $this->db->get_where('tbl_permisos', array('usuarios_id' => $usuarios_id, 'menus_id' => $obj1->menus_id))->row();

	        				$menus[$padres]->nivel[$nivel1]->encontrado = $existe ? TRUE : FALSE;

		        			$paramsN2 = array();
	        				$paramsN2[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
	        				$paramsN2[] = array('campo' => 'tcm.id_padre', 'value' => $obj1->menus_id, 'type' => 'where');
	        				$paramsN2[] = array('campo' => 'tcm.int_nivel', 'value' => 2, 'type' => 'where');

		        			$menus[$padres]->nivel[$nivel1]->nivel = $this->Model_super->find('all',
		        				array(
		        					'conditions' => $paramsN2,
		       						'order' => array('int_orden', 'ASC'),
		       						'fields' => $sql
		       					)
		       				);

		       				if ($menus[$padres]->nivel[$nivel1]->nivel) {
		        				foreach($menus[$padres]->nivel[$nivel1]->nivel as $nivel2 => $obj2) {
		        					$existe = $this->db->get_where('tbl_permisos', array('usuarios_id' => $usuarios_id, 'menus_id' => $obj2->menus_id))->row();

	        						$menus[$padres]->nivel[$nivel1]->nivel[$nivel2]->encontrado = $existe ? TRUE : FALSE;

		        					$paramsN3 = array();
			        				$paramsN3[] = array('campo' => 'tcm.estatus_id', 'value' => 1, 'type' => 'where');
			        				$paramsN3[] = array('campo' => 'tcm.id_padre', 'value' => $obj2->menus_id, 'type' => 'where');
			        				$paramsN3[] = array('campo' => 'tcm.int_nivel', 'value' => 3, 'type' => 'where');

		        					$menus[$padres]->nivel[$nivel1]->nivel[$nivel2]->nivel = $this->Model_super->find('all',
		        						array(
		        							'conditions' => $paramsN3,
		       								'order' => array('int_orden', 'ASC'),
		       								'fields' => $sql
		       							)
		       						);
		       					}
		       				}
		       			}
		       		}
	        	}
	        }

	        $respuesta['data'] = $menus;
			return retornoJson($respuesta);
		}
		redirect('/');
	}

	public function get_formularios() {
		if ($this->input->is_ajax_request()) {
			parse_str($this->security->xss_clean($this->input->post('data')), $respuesta['post']);

			$numeropagina = $this->input->post("nropagina");
            $cantidad = $this->input->post("cantidad");
            $respuesta['post']['inicio'] = ($numeropagina - 1) * $cantidad;
            $respuesta['post']['fin'] = $cantidad;

			$menus = array();
			$params = array();

			$this->Model_super->setTabla('tbl_cat_formularios tcf');
        	$sql = 'tcf.*';

        	$total = $this->Model_super->find('count',
            	array(
            		'conditions' => $params,
            		'fields' => $sql
            	)
            );

            //dd($respuesta);

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
                	'fields' => $sql
            	)
            );

	        $total_paginas = ($total < $cantidad) ? 1 : ceil($total / $cantidad);
	        $respuesta['total_paginas'] = $total_paginas;
            $respuesta['total_registros'] = $total;

        	return retornoJson($respuesta);

			//$respuesta['data'] = 
		}
	}

	public function guardarMenu() {
		if ($this->input->is_ajax_request()) {
			$respuesta['post'] = $this->input->post();
			$padre = array();

			$padre['char_url'] = isset($respuesta['post']['char_url']) ? $respuesta['post']['char_url'] : null;
			$padre['int_orden'] = $respuesta['post']['int_orden'];
			$padre['char_nombre'] = $respuesta['post']['char_nombre'];

			//Actualizar padres
			if($respuesta['post']['menus_id'] != '') {
				
				$id = $respuesta['post']['menus_id'];

				if($this->db->update('tbl_cat_menus', $padre, array('menus_id' => $id))) {
					$respuesta['error'] = FALSE;
					$respuesta['mensaje'] = 'Actualizacion del registro Exisomente!!';
				} else {
					$respuesta['error'] = TRUE;
					$respuesta['mensaje'] = 'Error al actualizar el registro!!';
				}
			} else {
				//insertar
				$padre['id_padre'] = null;
				$padre['estatus_id'] = 1;
				$padre['usuarios_id'] = user_info()->usuarios_id;
				$padre['tbl_componente_id'] = 0;
				$padre['date_registro'] = date('Y-m-d H:i:s');
				$this->db->insert('tbl_cat_menus', $padre);
				$id = $this->db->insert_id();
			}

			//Actualizar Primer Nivel
			if (isset($respuesta['post']['nivel1'])) {
				foreach($respuesta['post']['nivel1'] AS $nivel1) {
					$n1 = array();

					$n1['char_nombre'] = $nivel1['char_nombre'];
					$n1['int_orden'] = $nivel1['int_orden'];
					$n1['char_url'] = isset($nivel1['char_url']) ? $nivel1['char_url'] : null;
					$idNivel1 = null;

					if($nivel1['menus_id'] != '' && $nivel1['menus_id'] != 'null') {
						$idNivel1 = $nivel1['menus_id'];
						
						$this->db->update('tbl_cat_menus', $n1, array('menus_id' => $idNivel1));
					} else {
						//Insertar
						$n1['id_padre'] = $id;
						$n1['estatus_id'] = 1;
						$n1['usuarios_id'] = user_info()->usuarios_id;
						$n1['tbl_componente_id'] = 0;
						$n1['int_nivel'] = 1;
						$n1['date_registro'] = date('Y-m-d H:i:s');
						$this->db->insert('tbl_cat_menus', $n1);
					}

					//Nivel 2
					if (isset($nivel1['nivel2'])) {
						foreach($nivel1['nivel2'] AS $nivel2) {
							$n2 = array();

							$n2['char_nombre'] = $nivel2['char_nombre'];
							$n2['int_orden'] = $nivel2['int_orden'];
							$n2['char_url'] = isset($nivel2['char_url']) ? $nivel2['char_url'] : null;
							$idNivel2 = null;

							if ($nivel2['menus_id'] != '' && $nivel2['menus_id'] != 'null') {
								$idNivel2 = $nivel2['menus_id'];

								$this->db->update('tbl_cat_menus', $n2, array('menus_id' => $idNivel2));
							} else {
								//Insertar
								$n2['id_padre'] = $idNivel1;
								$n2['estatus_id'] = 1;
								$n2['usuarios_id'] = user_info()->usuarios_id;
								$n2['tbl_componente_id'] = 0;
								$n2['int_nivel'] = 2;
								$n2['date_registro'] = date('Y-m-d H:i:s');
								$this->db->insert('tbl_cat_menus', $n2);
							}

							if (isset($nivel2['nivel3'])) {
								foreach ($nivel2['nivel3'] AS $nivel3) {
									$n3 = array();

									$n3['char_nombre'] = $nivel3['char_nombre'];
									$n3['int_orden'] = $nivel3['int_orden'];
									$n3['char_url'] = isset($nivel3['char_url']) ? $nivel3['char_url'] : null;
									$idNivel3 = null;

									if ($nivel3['menus_id'] != '' && $nivel3['menus_id'] != 'null') {
										$idNivel3 = $nivel3['menus_id'];

										$this->db->update('tbl_cat_menus', $n3, array('menus_id' => $idNivel3));
									} else {
										//Insertar
										$n3['id_padre'] = $idNivel2;
										$n3['estatus_id'] = 1;
										$n4['usuarios_id'] = user_info()->usuarios_id;
										$n4['tbl_componente_id'] = 0;
										$n3['int_nivel'] = 3;
										$n3['date_registro'] = date('Y-m-d H:i:s');
										$this->db->insert('tbl_cat_menus', $n3);
									}
								}
							}
						}
					}
				}
			}

			return retornoJson($respuesta);
		}
	}

	public function menu() {
		if ($this->input->post()) {
			$data = $this->security->xss_clean($this->input->post());
			//dd($data);

			if ($data['padres']) {
				foreach($data['padres'] as $padre => $valor) {
					$this->db->update('tbl_cat_menus', array('int_orden' => $padre), array('menus_id' => $valor));
				}
			}

			redirect('Utilerias/Menus');
		}
	}

	public function asignar_pantallas() {
		if ($this->input->is_ajax_request()) {
			$respuesta['post'] = $this->input->post();
			if ($respuesta['post']['opt'] === "add") {
				$respuesta['data'] = $this->db->insert('tbl_permisos', array('usuarios_id' => $respuesta['post']['usuarios_id'], 'menus_id' => $respuesta['post']['menus_id']));
			} elseif($respuesta['post']['opt'] === "delete") {
				$respuesta['data'] = $this->db->delete('tbl_permisos', array('usuarios_id' => $respuesta['post']['usuarios_id'], 'menus_id' => $respuesta['post']['menus_id']));
			}
			socket(array('data' => array('nombre' => 'Menu', 'funcion' => onToy(), 'pantalla' => '', 'Activo' => user_info()->usuarios_id)));
			return retornoJson($respuesta);
		}
	}

	public function deleteMenus($menus_id) {
		if ($this->input->is_ajax_request()) {
			
			if ($menus_id == 'null') {
				$respuesta['error'] = TRUE;
				$respuesta['mensaje'] = 'Error al Borrar el registro, sin ID!!';
			} else {

				$respuesta['post'] = $this->input->post();

				if($this->db->delete('tbl_cat_menus', array('menus_id' => $menus_id))) {
					$respuesta['error'] = FALSE;
					$respuesta['mensaje'] = 'Menu Borrado Exisomente!!';
				} else {
					$respuesta['error'] = TRUE;
					$respuesta['mensaje'] = 'Error al Borrar el registro!!';
				}
			}
			return retornoJson($respuesta);
		}
	}

}