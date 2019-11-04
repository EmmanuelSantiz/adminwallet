<?php
class MY_Model extends CI_Model {
    
    function find($type, $params = array()) {
        $result = FALSE;
        $this->db->from($this->table);

        if(isset($params['conditions'])) {
            foreach ($params['conditions'] as $key) {
                switch ($key['type']) {
                    case 'like':
                        $this->db->like($key['campo'], $key['value']);
                        break;
                    case 'where':
                        $this->db->where($key['campo'], $key['value']);
                        break;
                    case 'where_in_not':
                        $this->db->where_not_in($key['campo'], $key['value']);
                        break;
                    case 'or_where':
                        $this->db->or_where_in($key['campo'], $key['value']);
                        break;
                    case 'or_like':
                        $this->db->or_like($key['campo'], $key['value']);
                        break;
                    case 'where_in':
                        $this->db->where_in($key['campo'], $key['value']);
                        break;
                }
            }
        }

        if(isset($params['join'])) {
            foreach($params['join']['clause'] as $join_table => $join_conditions) {
                if(isset($params['join'][$join_table]))
                    $this->db->join($join_table, $join_conditions, $params['join'][$join_table]);
                else
                    $this->db->join($join_table, $join_conditions);
            }
        }

        if(isset($params['fields'])) {
            if (isset($params['dist'])) {
                $this->db->distinct();
            }
            $this->db->select($params['fields']);
        }

        if(isset($params['order'])) {
            $this->db->order_by($params['order'][0], $params['order'][1]);
        }

        if(isset($params['order2'])) {
            $this->db->order_by($params['order2'][0], $params['order2'][1]);
        }

        if(isset($params['orderMult'])) {
            for($iteracion=0;$iteracion<count($params['orderMult']);$iteracion++){
                if(($iteracion % 2) == 0){
                    $tipo=$params['orderMult'][$iteracion];
                } else{
                    $order=$params['orderMult'][$iteracion];
                    $this->db->order_by($tipo, $order);
                }            
            }
        }

        if(isset($params['group'])) {
            $this->db->group_by($params['group']);
        }

        if($type == 'count')
            $result = $this->db->count_all_results();
        else {
            if($type == 'first')
                $this->db->limit(1);
            else if(isset($params['limit']) && !empty($params['limit'])) {
                if(is_array($params['limit'])) {
                    $cnt_params = count($params['limit']);
                    if($cnt_params) {
                        if($cnt_params == 1)
                            $this->db->limit($params['limit'][0]);
                        else
                            $this->db->limit($params['limit'][0], $params['limit'][1]);
                    }
                }
                else
                    $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            switch($type) {
                case 'list':
                    $result = array();
                    $tmp_result = $query->result_array();
                    $keys = array_values($params['fields']);

                    foreach($tmp_result as $tmp) {
                        $result[$tmp[$keys[0]]] = $tmp[$keys[1]];
                    }
                    break;
                case 'first':
                    $result = $query->row();
                    break;
                default:
                    $result = $query->result();
                    break;
            }
        }

        //echo $this->db->last_query();
        return $result;
    }

    function save($params) {
        $already_exists = FALSE;
        $retorno = FALSE;

        $tabla = explode(' ', $this->table);
        $tabla = $tabla[0];

        //$columPry = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$tabla."' AND COLUMN_KEY IN('PRI', 'UNI')")->row();
        $columPry = $this->db->query("SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_schema='generico'  AND t.table_name='".$tabla."';")->row();  

        if(isset($params[$columPry->column_name])) {
            $found_record = $this->find('count', array('conditions' => array(array('campo' => $columPry->column_name, 'value' => $params[$columPry->column_name], 'type' => 'where'))));
            if($found_record)
                $already_exists = TRUE;
        }

        $this->db->set($params);

        if ($already_exists) {
            $this->db->where($columPry->column_name, $params[$columPry->column_name]);
            if($this->db->update($tabla))
                $retorno = $params[$columPry->column_name];
        } else {
            $this->db->insert($tabla, $params); 
            $retorno = $this->db->insert_id();
        }

        if ($retorno)
            $this->session->set_flashdata('message', 'Se Agregaron/Actualizaron los datos Exitosamente');
        else
            $this->session->set_flashdata('message', 'Error al Registrar/Actualizar datos');
    }

    function delete($params) {
        return ($this->db->delete($this->table, $params) ? $this->db->affected_rows() : FALSE);
    }
}
?>