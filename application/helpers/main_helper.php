<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Funcion para obtener la ubicacion de donde nos encontramos
* @param 
* @return clase y metodo Ej. Inicio/index.
*/
if(!function_exists('onToy')) {
	function onToy() {
		$ci =& get_instance();
    	return $ci->router->fetch_class().'/'.$ci->router->fetch_method();
	}
}

if (!function_exists('get_cuentas_correos')) {
	function get_cuentas_correos($todos = true, $opcion = null, $id_usuario = null) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		if ($id_usuario) {
			$ci->db->where('id_usuario != ', $id_usuario);
		}
		
		$noCorreos = $ci->db->select('id_correo')->where('id_correo IS NOT NULL')->get('tbl_cat_usuarios')->result();

		if ($noCorreos) {
			foreach($noCorreos as $correo) {
				$filtros[] = $correo->id_correo;
			}
		}

		if (count($filtros) > 0) {
			$ci->db->where_not_in('id_correo', $filtros);
		}
		
		$query = $ci->db->select("id_correo, char_correo")->get('tbl_cat_correos')->result_array();

		if ($opcion) {
			$cadena = $query;
		} else {
			if ($query) {
				$cadena .= '<option value=""></option>';
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_correo'].'">'.$key['char_correo'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Correos</option>';
			}
		}

		return $cadena;
	}
}

/**
 * Funcion para obtener datos del usuario logeado
* @param integer id_usuario.
* @return objeto usuario
*/
if(!function_exists('user_info')) {
	function user_info() {
		$ci =& get_instance();
		$resultado = $ci->db->get_where('tbl_cat_usuarios', array('id_usuario' => $ci->session->userdata('id_usuario')))->row();
		/*$ci->db->where('id_usuario', $ci->session->userdata('id_usuario'));
		$query = $ci->db->get('tbl_cat_usuarios');
     	$resultado = $query->row();*/
     	if($resultado->id_usuario) {
     		return $resultado;
     	} else {
     		return null;
     	}
	}
}

/** 
 * Funcion para obtener los formularios con permisos de boton
* @param integer id_usuario.
* @return objeto usuario
*/
if (!function_exists('formularios')) {
	function formularios($id_usuario) {
		$arreglo = array();
		$ci =& get_instance();
		$ci->load->model('model_user');
		$resultado = $ci->model_user->get_formularios($id_usuario);

		foreach ($resultado as $key) {
			$arreglo[] = $key->char_nombre;
		}

		return $arreglo;
	}
}

/**
 * Funcion para ingresar datos en la bitacora de sesion
* @param arreglo de datos (modelo).
* @return id insertado
*/
if(!function_exists('inset_bit_sesion')) {
	function inset_bit_sesion($array = array()) {
		$ci =& get_instance();
		$ci->load->model('model_bitacora');
		$resultado = $ci->model_bitacora->add_bit_sesion($array);
		return $resultado;
	}
}

/**
 * Funcion para ingresar datos en la bitacora general
* @param arreglo de datos (modelo).
* @return id insertado
*/
if(!function_exists('inset_bit_general')) {
	function inset_bit_general($array = array()) {
		$ci =& get_instance();
		$ci->load->model('model_bitacora');
		$resultado = $ci->model_bitacora->add_bit_general($array);
		return $resultado;
	}
}

/**
 * Funcion para convertir un arreglo a Json
* @param arreglo de datos
* @return JsonArray
*/
if(!function_exists('retornoJson')) {
	function retornoJson($array = array()) {
		$ci =& get_instance();
		return $ci->output->set_content_type('application/json')->set_output(json_encode($array));
	}
}

/**
 * funcion para remover acentos o espacios en blanco en cadenas
 * @param  string $str cadena a configurar
 * @return string      cadena configurada
 */
if(!function_exists('remove_accents')) {
	function remove_accents($str) {
   		$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y',' '=>'-', ' '=> '');
    	return strtr($str, $unwanted_array);
	}
}

/**
 * Funcion para saber si es admin
 * @param
 * @return true si es admin
*/
if(!function_exists('is_admin')) {
	function is_admin(){
		return (user_info()->id_perfil==1);
	}
}

/**
 * Funcion para generar passwords aleatoriamente
 * @param
 * @return cadena de 10 caracteres
*/
if (!function_exists('temp_pass')) {
	function temp_pass() {
		$caracteres = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789";
		$cadena = "";
		for($i=0; $i<6; $i++) {
    		$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1);
		}
		return $cadena;
	}
}

/**
 * Funcion para Enviar Correos
 * @param $array de datos
 * @return estatus del envio
*/
if (!function_exists('enviar_mail')) {
	function enviar_mail($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'emmanuelsantizfelipe@gmail.com',
			'smtp_pass' => 'emmanuel@07011',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($configGmail);
 
		$ci->email->from('emmanuelsantizfelipe@gmail.com');
		$ci->email->to($array['char_email']);
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		return $ci->email->send();
	}
}

/**
 * Funcion para Enviar Correos Nueva
 * @param $array de datos
 * @return estatus del envio
*/
if (!function_exists('enviar_mail_in')) {
	function enviar_mail_in($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.vlt.mx',
			'smtp_port' => 465,
			'smtp_user' => 'operacion3@vlt.mx',
			'smtp_pass' => 'Swp8629+',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($config);
 
		$ci->email->from('operacion3@vlt.mx');
		$ci->email->to($array['char_email']);
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		return $ci->email->send();
	}
}

if (!function_exists('enviar_mail_Dinamico')) {
	function enviar_mail_Dinamico($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.vlt.mx',
			'smtp_port' => 465,
			'smtp_user' => $array['char_email_to'],
			'smtp_pass' => $array['passEmailTo'],
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"

		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($config);
 
		$ci->email->from($array['char_email_to']);
		$ci->email->to($array['char_email']);
		//$ci->email->reply_to($array['char_email'], $array['titulo']); 
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		//$ci->email->attach('./correosPdf/'.$array['archivo'].".pdf");

		return $ci->email->send();
	}
}
if (!function_exists('enviar_mail_Dinamico_archivos')) {
	function enviar_mail_Dinamico_archivos($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		
		$ci->load->library("email");

		//configuracion para gmail
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.vlt.mx',
			'smtp_port' => 465,
			'smtp_user' => $array['char_email_to'],
			'smtp_pass' => $array['passEmailTo'],
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($config);
		$ci->email->clear();
		if($array['archivos'] !=''){
			$porciones = explode(",", $array['archivos']);
			for($i=0;$i<count($porciones);$i++){
				if($porciones[$i]!=''){
					//echo $porciones[$i];
					$ci->email->attach($porciones[$i]);
				}
			}
		}
		
		$ci->email->from($array['char_email_to']);
		$ci->email->to($array['char_email']);
		//$copiaCorreos=explode(substr($array['copias'],0,-1));
		if($array['copias']!=''){
			$copiaCorreos=explode(",",$array['copias']);
			$ci->email->cc($copiaCorreos);
		//$ci->email->reply_to($array['char_email'], $array['titulo']);
		} 
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
	//	echo "-->".$array['archivos'];
		
		//$ci->email->set_header('From:',$array['char_email']);
   		//$ci->email->set_header('Content-type:','text/html; charset=iso-8859-1\r\n');
  
		return $ci->email->send();
	}
}
if (!function_exists('enviar_mail_Din')) {
	function enviar_mail_Din($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'emmanuelsantizfelipe@gmail.com',
			'smtp_pass' => 'emmanuel@07011',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'wordwrap' => TRUE,
			'newline' => "\r\n"
		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($configGmail);
 
		$ci->email->from('emmanuelsantizfelipe@gmail.com');
		$ci->email->to($array['char_email']);
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		//$ci->email->attach('./correosPdf/'.$array['archivo'].".pdf"); 
		return $ci->email->send();
	}
}
/*if (!function_exists('enviar_mail_Dinamic')) {
	function enviar_mail_Dinamic($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		 $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            //'smtp_port' => 587,
            'smtp_port' => 25,
            'smtp_crypto' => 'tls',
            'smtp_user' => 'AKIAJR7GQGEETNN32HLQ',
            'smtp_pass' => 'ApT0z+H6htcFQwcucWfrTvsP0Yt+W1miyMfAzwzQgBov',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($configGmail);
 
		$ci->email->from('noreply@manjar.mx');
		$ci->email->to($array['char_email']);
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		$ci->email->attach('./correosPdf/'.$array['archivo'].".pdf"); 
		return $ci->email->send();
	}
}*/

if (!function_exists('enviar_mailR')) {
	function enviar_mailR($array = array(), $html = '') {
		date_default_timezone_set('America/Monterrey');
		$ci =& get_instance();
		$ci->load->library("email");

		//configuracion para gmail
		$config = array(
			//us-west-2.amazonses.com
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 587,
			'smtp_crypto' => 'tls',
			'smtp_user' => 'AKIAJR7GQGEETNN32HLQ',
			'smtp_pass' => 'ApT0z+H6htcFQwcucWfrTvsP0Yt+W1miyMfAzwzQgBov',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'wordwrap' => TRUE,
			'newline' => "\r\n"
		);
 
		//cargamos la configuración para enviar con gmail
		$ci->email->initialize($config);

		$ci->email->from('soporte@manjar.mx');
		$ci->email->to($array['char_email']);
		$ci->email->subject($array['titulo']);
		$ci->email->message($html);
		$ci->email->attach('./correosPdf/'.$array['archivo'].".pdf"); 
		//return $ci->email->send();
		$ci->email->send();
		var_dump($ci->email->print_debugger());
	}
}

/**
 * Funcion para Exportar Word o Excel
 * @param $consulta, nombre final del archivo, tipo de exportacion (Word, Excel)
 * @return Archivo en el formato correspondiente
*/
if (!function_exists('export')) {
	function export($sql, $filename = 'exceloutput', $opc = 'excel') {
    	$headers = '<table border=1><tr>';
     	$data = '';
 
     	$obj =& get_instance();
     	$query = $sql["query"];
	    $fields = $sql["fields"];

	    if (isset($sql['fechas'])) {
	    	$tamaño = count($sql["fields"]) / 2;
	    	$headers .= '<td colspan="'.$tamaño.'">Rango Fechas</td><td colspan="'.($tamaño).'">'.$sql['fechas'].'</td></tr><tr>';
	    }
 
     	if ($query->num_rows() == 0) {
     		$headers .= '</tr>';
        	$data = '<p>Sin Datos</p>';
     	} else {
          	foreach ($fields as $field => $value2) {
             	$headers .= '<td>'.$value2.'</td>';
          	}
          	$headers .= '</tr>';
          	foreach ($query->result() as $row) {
               	$line = '<tr>';
               	foreach($row as $value) {
                    $value = '<td>'.$value.'</td>';
                    $line .= $value;
               	}
               	$data .= trim($line)."</tr>";
          	}
     	}

     	if ($opc == 'excel') {
      		header("Content-type: application/vnd.ms-excel");
      		header("Content-Disposition: attachment; filename=$filename.xls");
      	} else {
      		header("Content-Type: application/vnd.ms-word");
      		header("Content-Disposition: attachment; filename=$filename.doc");
      	}
      	header("Content-type: application/x-msdownload");
      	
      	echo $headers.$data;
      	exit;
	}
}

/**
 * Funcion isr 2017 
 * @param tipo semana, quincenal, etc
 * @return tabla con datos correspondientes
*/
if (!function_exists('ISR')) {
	function ISR($tipo = 'uno') {
		switch ($tipo) {
			case 'uno':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>16.32,'cuota'=>0.00),
					2 => array('inf'=>16.33,'sup'=>138.50,'cuota'=>0.31),
					3 => array('inf'=>138.51,'sup'=>243.40,'cuota'=>8.13),
					4 => array('inf'=>243.41,'sup'=>282.94,'cuota'=>19.55),
					5 => array('inf'=>282.95,'sup'=>338.76,'cuota'=>25.87),
					6 => array('inf'=>338.77,'sup'=>683.23,'cuota'=>35.88),
					7 => array('inf'=>683.24,'sup'=>1076.87,'cuota'=>109.45),
					8 => array('inf'=>1076.88,'sup'=>2055.92,'cuota'=>202.04),
					9 => array('inf'=>2055.93,'sup'=>2741.23,'cuota'=>495.75),
					10 => array('inf'=>2741.24,'sup'=>8223.68,'cuota'=>715.05),
					11 => array('inf'=>8223.69,'sup'=>8223.69,'cuota'=>2579.09));
				break;
			case 'siete':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>114.24,'cuota'=>0.00),
					2 => array('inf'=>114.25,'sup'=>969.50,'cuota'=>2.17),
					3 => array('inf'=>969.51,'sup'=>1703.80,'cuota'=>56.91),
					4 => array('inf'=>1703.81,'sup'=>1980.58,'cuota'=>136.85),
					5 => array('inf'=>1980.59,'sup'=>2371.32,'cuota'=>181.09),
					6 => array('inf'=>2371.33,'sup'=>4782.61,'cuota'=>251.16),
					7 => array('inf'=>4782.62,'sup'=>7538.09,'cuota'=>766.15),
					8 => array('inf'=>7538.10,'sup'=>14391.44,'cuota'=>1414.28),
					9 => array('inf'=>14391.45,'sup'=>19188.61,'cuota'=>3470.25),
					10 => array('inf'=>19188.62,'sup'=>57565.76,'cuota'=>5005.35),
					11 => array('inf'=>57565.77,'sup'=>57565.77,'cuota'=>18053.63));
				break;
			case 'diez':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>163.20,'cuota'=>0.00),
					2 => array('inf'=>163.21,'sup'=>1385.00,'cuota'=>3.10),
					3 => array('inf'=>1385.01,'sup'=>2434.00,'cuota'=>81.30),
					4 => array('inf'=>2434.01,'sup'=>2829.40,'cuota'=>195.50),
					5 => array('inf'=>2829.41,'sup'=>3387.60,'cuota'=>258.70),
					6 => array('inf'=>3387.61,'sup'=>6832.30,'cuota'=>358.80),
					7 => array('inf'=>6832.31,'sup'=>10768.70,'cuota'=>1094.50),
					8 => array('inf'=>10768.71,'sup'=>20559.20,'cuota'=>2020.40),
					9 => array('inf'=>20559.21,'sup'=>27412.30,'cuota'=>4957.50),
					10 => array('inf'=>27412.31,'sup'=>82236.80,'cuota'=>7150.50),
					11 => array('inf'=>82236.81,'sup'=>82236.81,'cuota'=>25790.90));
				break;
			case 'quince':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>244.80,'cuota'=>0.00),
					2 => array('inf'=>244.81,'sup'=>2077.50,'cuota'=>4.65),
					3 => array('inf'=>2077.51,'sup'=>3651.00,'cuota'=>121.95),
					4 => array('inf'=>3651.01,'sup'=>4244.10,'cuota'=>293.25),
					5 => array('inf'=>4244.11,'sup'=>5081.40,'cuota'=>388.05),
					6 => array('inf'=>5081.41,'sup'=>10248.45,'cuota'=>538.20),
					7 => array('inf'=>10248.46,'sup'=>16153.05,'cuota'=>1641.75),
					8 => array('inf'=>16153.06,'sup'=>30838.80,'cuota'=>3030.60),
					9 => array('inf'=>30838.81,'sup'=>41118.45,'cuota'=>7436.25),
					10 => array('inf'=>41118.46,'sup'=>123355.20,'cuota'=>10725.75),
					11 => array('inf'=>123355.21,'sup'=>123355.21,'cuota'=>38686.35));
				break;
			case 'treinta':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>496.07,'cuota'=>0.00),
					2 => array('inf'=>496.08,'sup'=>4210.41,'cuota'=>9.52),
					3 => array('inf'=>4210.42,'sup'=>7399.42,'cuota'=>247.24),
					4 => array('inf'=>7399.43,'sup'=>8601.50,'cuota'=>594.21),
					5 => array('inf'=>8601.51,'sup'=>10298.35,'cuota'=>786.54),
					6 => array('inf'=>10298.36,'sup'=>20770.29,'cuota'=>1090.61),
					7 => array('inf'=>20770.30,'sup'=>32736.83,'cuota'=>3327.42),
					8 => array('inf'=>32736.84,'sup'=>62500.00,'cuota'=>6141.95),
					9 => array('inf'=>62500.01,'sup'=>83333.33,'cuota'=>15070.90),
					10 => array('inf'=>83333.34,'sup'=>250000.00,'cuota'=>21737.57),
					11 => array('inf'=>250000.01,'sup'=>250000.01,'cuota'=>78404.23));
				break;
			case 'sesenta':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>992.14,'cuota'=>0.00),
					2 => array('inf'=>992.15,'sup'=>8420.82,'cuota'=>19.04),
					3 => array('inf'=>8420.83,'sup'=>14780.84,'cuota'=>494.48),
					4 => array('inf'=>14780.85,'sup'=>17203.00,'cuota'=>1188.42),
					5 => array('inf'=>17230.01,'sup'=>20596.70,'cuota'=>1573.08),
					6 => array('inf'=>20596.71,'sup'=>41540.58,'cuota'=>2181.22),
					7 => array('inf'=>41540.59,'sup'=>65473.66,'cuota'=>6654.84),
					8 => array('inf'=>65473.67,'sup'=>125000.00,'cuota'=>12283.90),
					9 => array('inf'=>125000.01,'sup'=>166666.66,'cuota'=>30141.80),
					10 => array('inf'=>166666.67,'sup'=>500000.00,'cuota'=>43475.14),
					11 => array('inf'=>5000000.01,'sup'=>250000.01,'cuota'=>156808.46));
				break;
			case 'anual':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>5952.84,'cuota'=>0.00),
					2 => array('inf'=>5952.85,'sup'=>50524.92,'cuota'=>114.29),
					3 => array('inf'=>50524.93,'sup'=>88793.04,'cuota'=>2966.91),
					4 => array('inf'=>88793.05,'sup'=>103218.00,'cuota'=>7130.48),
					5 => array('inf'=>103218.01,'sup'=>123580.20,'cuota'=>9438.47),
					6 => array('inf'=>123580.21,'sup'=>249243.48,'cuota'=>13087.37),
					7 => array('inf'=>249243.49,'sup'=>392841.96,'cuota'=>29929.05),
					8 => array('inf'=>392841.97,'sup'=>750000.00,'cuota'=>73703.41),
					9 => array('inf'=>750000.01,'sup'=>1000000.00,'cuota'=>180850.82),
					10 => array('inf'=>1000000.01,'sup'=>3000000.00,'cuota'=>260850.81),
					11 => array('inf'=>3000000.01,'sup'=>3000000.01,'cuota'=>940850.81));
				break;
		}

		$arreglo[1]['porc']= .0192;
		$arreglo[2]['porc']= .064;
		$arreglo[3]['porc']= .1088;
		$arreglo[4]['porc']= .16;
		$arreglo[5]['porc']= .1792;
		$arreglo[6]['porc']= .2136;
		$arreglo[7]['porc']= .2352;
		$arreglo[8]['porc']= .3;
		$arreglo[9]['porc']= .32;
		$arreglo[10]['porc']= .34;
		$arreglo[11]['porc']= .35;

		return $arreglo;
	}
}

if (!function_exists('ISR2018DIA')) {
	function ISR2018DIA() {

		$arreglo = array(1 => array('inf' => 0.01,'sup' => 19.03,'cuota' => 0.00),
			2 => array('inf' => 19.04,'sup' => 161.52,'cuota' => 0.3654),
			3 => array('inf' => 161.53,'sup' => 283.86,'cuota' => 9.4845),
			4 => array('inf' => 283.87,'sup' => 329.97,'cuota' => 22.7947),
			5 => array('inf' => 329.98,'sup' => 395.06,'cuota' => 30.1730),
			6 => array('inf' => 395.07,'sup' => 796.79,'cuota' => 41.8378),
			7 => array('inf' => 796.80,'sup' => 1255.85,'cuota' => 127.6460),
			8 => array('inf' => 1255.86,'sup' => 2397.62,'cuota' => 235.6164),
			9 => array('inf' => 2397.63,'sup' => 3196.82,'cuota' => 578.1477),
			10 => array('inf' => 3196.83,'sup' => 9590.46,'cuota' => 833.8930),
			11 => array('inf' => 9590.47,'sup' => 999999999,'cuota' => 3007.7309));	

		$arreglo[1]['porc']= 0.0192;
		$arreglo[2]['porc']= 0.064;
		$arreglo[3]['porc']= 0.1088;
		$arreglo[4]['porc']= 0.16;
		$arreglo[5]['porc']= 0.1792;
		$arreglo[6]['porc']= 0.2136;
		$arreglo[7]['porc']= 0.2352;
		$arreglo[8]['porc']= 0.30;
		$arreglo[9]['porc']= 0.32;
		$arreglo[10]['porc']= 0.34;
		$arreglo[11]['porc']= 0.35;

		return $arreglo;
	}
}

/*if (!function_exists('SUPCIDIO2018')) {
	function SUPCIDIO2018() {

		$arreglo = array(
			1 => array('min'=>0.01, 'max'=>58.19,'sub'=>13.39),
			2 => array('min'=>58.20, 'max'=>87.28,'sub'=>13.38),
			3 => array('min'=>87.28, 'max'=>114.24,'sub'=>13.38),
			4 => array('min'=>114.24, 'max'=>116.38,'sub'=>12.92),
			5 => array('min'=>116.39, 'max'=>146.25,'sub'=>12.58),
			6 => array('min'=>146.26, 'max'=>155.17,'sub'=>11.65),
			7 => array('min'=>155.18, 'max'=>175.51,'sub'=>10.69),
			8 => array('min'=>175.52, 'max'=>204.76,'sub'=>9.69),
		    9 => array('min'=>204.77, 'max'=>234.01,'sub'=>8.34),
		   10 => array('min'=>234.02, 'max'=>242.84,'sub'=>7.16),
		   11 => array('min'=>242.85, 'max'=>29155000,'sub'=>0));

		return $arreglo;
	}
}*/

if (!function_exists('SUPCIDIO2018')) {
	function SUPCIDIO2018() {

		$arreglo = array(
			1 => array('min'=>0.01, 'max'=>58.19,'sub'=>13.39),
			2 => array('min'=>58.20, 'max'=>87.28,'sub'=>13.38),
			3 => array('min'=>87.28, 'max'=>114.24,'sub'=>13.42),
			4 => array('min'=>114.24, 'max'=>116.38,'sub'=>12.92),
			5 => array('min'=>116.39, 'max'=>146.25,'sub'=>12.58),
			6 => array('min'=>146.26, 'max'=>155.17,'sub'=>11.65),
			7 => array('min'=>155.18, 'max'=>175.51,'sub'=>10.69),
			8 => array('min'=>175.52, 'max'=>204.76,'sub'=>9.69),
		    9 => array('min'=>204.77, 'max'=>234.01,'sub'=>8.34),
		   10 => array('min'=>234.02, 'max'=>242.84,'sub'=>7.16),
		   11 => array('min'=>242.85, 'max'=>29155000,'sub'=>0));

		return $arreglo;
	}
}

/**
 * Funcion isr 2018 
 * @param tipo semana, quincenal, etc
 * @return tabla con datos correspondientes
*/
/*if (!function_exists('ISR2018')) {
	function ISR2018($tipo = 'uno') {
		switch ($tipo) {
			case 'uno':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>19.03,'cuota'=>0.00),
					2 => array('inf'=>19.04,'sup'=>161.52,'cuota'=>0.37),
					3 => array('inf'=>161.53,'sup'=>283.86,'cuota'=>9.48),
					4 => array('inf'=>283.87,'sup'=>329.97,'cuota'=>22.79),
					5 => array('inf'=>329.98,'sup'=>395.06,'cuota'=>30.17),
					6 => array('inf'=>395.07,'sup'=>796.79,'cuota'=>41.84),
					7 => array('inf'=>796.80,'sup'=>1255.85,'cuota'=>127.65),
					8 => array('inf'=>1255.86,'sup'=>2397.62,'cuota'=>235.62),
					9 => array('inf'=>2397.63,'sup'=>3196.82,'cuota'=>578.15),
					10 => array('inf'=>3196.83,'sup'=>9590.46,'cuota'=>833.89),
					11 => array('inf'=>9590.47,'sup'=>9590.47,'cuota'=>3007.73)); 
				break;
			case 'siete':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>159.53,'cuota'=>0.00),
					2 => array('inf'=>133.22,'sup'=>1130.64,'cuota'=>2.59),
					3 => array('inf'=>1130.65,'sup'=>1987.02,'cuota'=>66.36),
					4 => array('inf'=>1987.03,'sup'=>2309.79,'cuota'=>159.53),
					5 => array('inf'=>2309.80,'sup'=>2765.42,'cuota'=>211.19),
					6 => array('inf'=>2765.43,'sup'=>5577.53,'cuota'=>292.88),
					7 => array('inf'=>5577.54,'sup'=>8790.95,'cuota'=>893.55),
					8 => array('inf'=>8790.96,'sup'=>16783.34,'cuota'=>1649.34),
					9 => array('inf'=>16783.35,'sup'=>22377.74,'cuota'=>4047.05),
					10 => array('inf'=>22377.75,'sup'=>67133.22,'cuota'=>5837.23),
					11 => array('inf'=>67133.23,'sup'=>67133.23,'cuota'=>21054.11));
				break;
			case 'diez':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>190.30,'cuota'=>0.00),
					2 => array('inf'=>190.31,'sup'=>1615.20,'cuota'=>3.70),
					3 => array('inf'=>1615.21,'sup'=>2838.60,'cuota'=>94.80),
					4 => array('inf'=>2838.611,'sup'=>3299.70,'cuota'=>227.90),
					5 => array('inf'=>3299.71,'sup'=>3950.60,'cuota'=>301.70),
					6 => array('inf'=>3950.61,'sup'=>7967.90,'cuota'=>418.40),
					7 => array('inf'=>7967.91,'sup'=>12558.50,'cuota'=>1276.50),
					8 => array('inf'=>12558.51,'sup'=>23976.20,'cuota'=>2356.20),
					9 => array('inf'=>23976.21,'sup'=>31968.20,'cuota'=>5781.50),
					10 => array('inf'=>31968.21,'sup'=>95904.60,'cuota'=>8338.90),
					11 => array('inf'=>95904.61,'sup'=>95904.61,'cuota'=>30077.30));
				break;
			case 'quince':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>285.45,'cuota'=>0.00),
					2 => array('inf'=>285.46,'sup'=>2422.80,'cuota'=>5.55),
					3 => array('inf'=>2422.81,'sup'=>4257.90,'cuota'=>142.20),
					4 => array('inf'=>4257.91,'sup'=>4949.55,'cuota'=>341.85),
					5 => array('inf'=>4949.56,'sup'=>5925.90,'cuota'=>452.55),
					6 => array('inf'=>5925.91,'sup'=>11951.85,'cuota'=>627.60),
					7 => array('inf'=>11951.86,'sup'=>18837.75,'cuota'=>1914.75),
					8 => array('inf'=>18837.76,'sup'=>35964.30,'cuota'=>3534.30),
					9 => array('inf'=>35964.31,'sup'=>47952.30,'cuota'=>8672.25),
					10 => array('inf'=>47952.31,'sup'=>143856.90,'cuota'=>12508.35),
					11 => array('inf'=>143856.91,'sup'=>143856.91,'cuota'=>45115.95));
				break;  
			case 'treinta':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>578.52,'cuota'=>0.00),
					2 => array('inf'=>578.53,'sup'=>4910.18,'cuota'=>11.11),
					3 => array('inf'=>4910.19,'sup'=>8629.20,'cuota'=>288.33),
					4 => array('inf'=>8629.21,'sup'=>10031.07,'cuota'=>692.96),
					5 => array('inf'=>10031.08,'sup'=>12009.94,'cuota'=>917.26),
					6 => array('inf'=>12009.95,'sup'=>24222.31,'cuota'=>1271.87),
					7 => array('inf'=>24222.32,'sup'=>38177.69,'cuota'=>3880.44),
					8 => array('inf'=>38177.70,'sup'=>72887.50,'cuota'=>7162.74),
					9 => array('inf'=>72887.51,'sup'=>97183.33,'cuota'=>17575.69),
					10 => array('inf'=>97183.34,'sup'=>291550.00,'cuota'=>25350.35),
					11 => array('inf'=>291550.01,'sup'=>291550.01,'cuota'=>91435.02));
				break;  
			case 'sesenta':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>992.14,'cuota'=>0.00),
					2 => array('inf'=>992.15,'sup'=>8420.82,'cuota'=>19.04),
					3 => array('inf'=>8420.83,'sup'=>14780.84,'cuota'=>494.48),
					4 => array('inf'=>14780.85,'sup'=>17203.00,'cuota'=>1188.42),
					5 => array('inf'=>17230.01,'sup'=>20596.70,'cuota'=>1573.08),
					6 => array('inf'=>20596.71,'sup'=>41540.58,'cuota'=>2181.22),
					7 => array('inf'=>41540.59,'sup'=>65473.66,'cuota'=>6654.84),
					8 => array('inf'=>65473.67,'sup'=>125000.00,'cuota'=>12283.90),
					9 => array('inf'=>125000.01,'sup'=>166666.66,'cuota'=>30141.80),
					10 => array('inf'=>166666.67,'sup'=>500000.00,'cuota'=>43475.14),
					11 => array('inf'=>5000000.01,'sup'=>250000.01,'cuota'=>156808.46));
				break;
			case 'anual':
				$arreglo = array(1 => array('inf'=>0.01,'sup'=>6942.20,'cuota'=>0.00),
					2 => array('inf'=>6942.21,'sup'=>58922.16,'cuota'=>133.28),
					3 => array('inf'=>58922.17,'sup'=>103550.44,'cuota'=>3460.01),
					4 => array('inf'=>103550.45,'sup'=>120372.83,'cuota'=>8315.57),
					5 => array('inf'=>120372.84,'sup'=>144119.23,'cuota'=>11007.14),
					6 => array('inf'=>144119.24,'sup'=>290667.75,'cuota'=>15262.49),
					7 => array('inf'=>290667.76,'sup'=>458132.29,'cuota'=>46565.26),
					8 => array('inf'=>458132.30,'sup'=>874650.00,'cuota'=>85952.92),
					9 => array('inf'=>874650.01,'sup'=>1166200.00,'cuota'=>210908.23),
					10 => array('inf'=>1166200.01,'sup'=>3498600.00,'cuota'=>304204.21),
					11 => array('inf'=>3498600.01,'sup'=>3498600.01,'cuota'=>1097220.21));
				break;  
		}

		$arreglo[1]['porc']= .0192;
		$arreglo[2]['porc']= .064;
		$arreglo[3]['porc']= .1088;
		$arreglo[4]['porc']= .16;
		$arreglo[5]['porc']= .1792;
		$arreglo[6]['porc']= .2136;
		$arreglo[7]['porc']= .2352;
		$arreglo[8]['porc']= .3;
		$arreglo[9]['porc']= .32;
		$arreglo[10]['porc']= .34;
		$arreglo[11]['porc']= .35;

		return $arreglo;
	}
}*/

/**
 * Funcion isr 2018 
 * @param tipo semana, quincenal, etc
 * @return tabla con datos correspondientes
*/
if (!function_exists('ISR2018')) {
	function ISR2018() {

		$arreglo = array(1 => array('inf' => 0.01,'sup' => 578.52,'cuota' => 0.00),
			2 => array('inf' => 578.53,'sup' => 4910.18,'cuota' => 11.11),
			3 => array('inf' => 4910.19,'sup' => 8629.20,'cuota' => 288.33),
			4 => array('inf' => 8629.21,'sup' => 10031.07,'cuota' => 692.96),
			5 => array('inf' => 10031.08,'sup' => 12009.94,'cuota' => 917.26),
			6 => array('inf' => 12009.95,'sup' => 24222.31,'cuota' => 1271.87),
			7 => array('inf' => 24222.32,'sup' => 38177.69,'cuota' => 3880.44),
			8 => array('inf' => 38177.70,'sup' => 72887.50,'cuota' => 7162.74),
			9 => array('inf' => 72887.51,'sup' => 97183.33,'cuota' => 17575.69),
			10 => array('inf' => 97183.34,'sup' => 291550.00,'cuota' => 25350.35),
			11 => array('inf' => 291550.01,'sup' => 291550.01,'cuota' => 91435.02));		

		$arreglo[1]['porc']= 1.92;
		$arreglo[2]['porc']= 6.4;
		$arreglo[3]['porc']= 10.88;
		$arreglo[4]['porc']= 16;
		$arreglo[5]['porc']= 17.92;
		$arreglo[6]['porc']= 21.36;
		$arreglo[7]['porc']= 23.52;
		$arreglo[8]['porc']= 30;
		$arreglo[9]['porc']= 32;
		$arreglo[10]['porc']= 34;
		$arreglo[11]['porc']= 35;

		return $arreglo;
	}
}

/**
 * Funcion debug 
 * @param $impresion datos a imprimir
 * @return termina la ejecucion
*/
if (!function_exists('dd')) {
	function dd($impresion = ''){
		echo '<pre>';
		var_dump($impresion);
		exit();
	}
}

/**
 * Funcion get_obj 
 * @param arreglo de parametros, 
 * @return termina la ejecucion
*/
if (!function_exists('get_obj')) {
	function get_obj($array = array()) {
		$bandera = FALSE;
		if (count($array) > 0) {
			if (isset($array['table']) && isset($array['param'])) {
				$ci =& get_instance();
				$query = $ci->db->get_where($array['table'], $array['param'])->row();
				if($query)
                    $bandera = TRUE;
			}
		}

		return $bandera;
	}
}

/**
 * Funcion get_obj 
 * @param arreglo de parametros, 
 * @return termina la ejecucion
*/
if (!function_exists('get_clientesVirid')) {
	function get_clientesVirid($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		$query = $ci->db->select("id_cliente, char_nombre")->get('virid_clientes')->result_array();

		
			if ($query) {
				
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_cliente'].'">'.$key['char_nombre'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Clientes</option>';
			}
		

		return $cadena;
	
	}
}

/**
 * [removeCache description] Funcion para borrar cache
 * @return [type] [description]
 */
if (!function_exists('removeCache')) {
	function removeCache() {
		header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		/*$ci =& get_instance();
		$ci->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$ci->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
		$ci->output->set_header('Pragma: no-cache');*/
	}
}
if (!function_exists('get_grupoEmpresarial')) {
	function get_grupoEmpresarial($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		$query = $ci->db->select("id_grupo_empresarial, char_nombre")->get('valeant_grupos_empresariales')->result_array();

		
			if ($query) {
				$cadena .= '<option value="">Todos</option>';
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_grupo_empresarial'].'">'.$key['char_nombre'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Clientes</option>';
			}
		

		return $cadena;
	
	}
}

if (!function_exists('get_pagadora')) {
	function get_pagadora($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		$query = $ci->db->select("id_pagadora, char_nombre")->get('valeant_pagadoras')->result_array();

		
			if ($query) {
				$cadena .= '<option value="">Todos</option>';
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_pagadora'].'">'.$key['char_nombre'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Pagadoras</option>';
			}
		

		return $cadena;
	
	}
}
if (!function_exists('get_usuarios')) {
	function get_usuarios($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		$query = $ci->db->select("id_usuario, char_nombre")->order_by("char_nombre","ASC")->get('tbl_cat_usuarios')->result_array();

		
			if ($query) {
				$cadena .= '<option value="">Todos</option>';
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_usuario'].'">'.$key['char_nombre'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Usuarios</option>';
			}
		

		return $cadena;
	
	}
}
if (!function_exists('get_beneficiarios')) {
	function get_beneficiarios($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		//$query = $ci->db->select("id_beneficiario, char_nombre")->get('valeant_beneficiarios')->result_array();
		$query = $ci->db->select("t2.id_beneficiario, t2.char_nombre")->from('tbl_beneficiarios_recibo t1')->join('valeant_beneficiarios t2','t1.id_beneficiario = t2.id_beneficiario','INNER')->where('t2.bol_validado = 1 and t2.bol_estado = 1')->group_by('t2.id_beneficiario')->get()->result_array();
		
			if ($query) {
				$cadena .= '<option value="">Todos</option>';
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_beneficiario'].'">'.$key['char_nombre'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Beneficiarios</option>';
			}
		

		return $cadena;
	
	}
}
if (!function_exists('get_cuentas_tipoUsuariocorreos')) {
	function get_cuentas_tipoUsuariocorreos($array = array()) {
		$cadena = '';
		$ci =& get_instance();
		$filtros = array();

		
		//$query = $ci->db->select("id_beneficiario, char_nombre")->get('valeant_beneficiarios')->result_array();
		$query = $ci->db->select("id_tipoUserCorreo, char_tipoUserCorreo,text_descripcion")->order_by("char_tipoUserCorreo","ASC")->get('tbl_tipoUserCorreo')->result_array();
		
			if ($query) {
				foreach ($query as $key) {
					$cadena .= '<option value="'.$key['id_tipoUserCorreo'].'">'.$key['char_tipoUserCorreo'].'-'.$key['text_descripcion'].'</option>';
				}
			} else {
				$cadena = '<option>Sin Opciones</option>';
			}
		

		return $cadena;
	
	}
}

/*if(!function_exists('get_bitacora')) {
	function get_bitacora() {
		$ci =& get_instance();
		$ci->load->model('model_bitacora');
		$resultado = $ci->model_bitacora->get_bit_general();
		return $resultado;
	}
}*/