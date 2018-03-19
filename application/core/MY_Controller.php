<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

if(file_exists("assets/backend/html2pdf/html2pdf.class.php"))
{
	include_once "assets/backend/html2pdf/html2pdf.class.php";
}

if(file_exists("assets/backend/PHPExcel/Classes/PHPExcel.php"))
{
	include_once "assets/backend/PHPExcel/Classes/PHPExcel.php";
	include_once "assets/backend/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php";
	include_once "assets/backend/PHPExcel/Classes/PHPExcel/IOFactory.php";
}

if(file_exists("assets/backend/fckeditor/fckeditor.php"))
{
	include_once "assets/backend/fckeditor/fckeditor.php";
}

class MY_Controller extends CI_Controller {

	public $chat = TRUE; // Validar el Chat de Comunicación.
	public $usuarios = array();
	public $locked = FALSE; // Para ver si la sesión está bloqueada.
	public $title = NULL; // Titulo del Controlador.
	public $table = NULL; // Tabla definida de Consulta.
	public $retorno = TRUE; // Retorno de Valores en el Formulario y en las Tablas.
	public $items = array(); // Items de los Formularios y de las Tablas.
	public $buttons = array(); // Botones de los Formularios y de las Tablas.
	public $import = FALSE; // Para importar registros..
	public $export = FALSE; // Para exportar registros..
	public $publish = FALSE; // Si los registros son publicables.
	public $status = TRUE;
	public $order = FALSE;
	public $type = 'table';
	public $route = "uploads/";
	public $where = array();
	public $tamanio_disco = 0;
	public $elementos_adicionales = array();
	public $readonly = FALSE;
	public $campo_referencia = 'id';
	public $help = NULL;
	public $sidebar = TRUE;
	public $url_retorno = NULL;
	public $per_page = 30;
	public $nuevo_token = FALSE;
	public $error = NULL;
	public $breadcrumb = TRUE;
	public $controller = NULL; // Controlador donde estamos trabajando.
	public $parent_key = 'id';
	public $item_order = array('key' => 'id', 'value' => 'desc');
	public $show_order = array('key' => 'activado', 'value' => 1);
	public $permisos = array();
	public $menu = array();
	public $session_name = "admin-codeigniter";
	public $configuracion = array();
	public $alias = FALSE;
	public $actions = array();
	public $items_unlocked = array();
	public $paginate = FALSE;
	public $contador = 0;

	// Funciones Básicas..

	function __construct()
	{
		parent::__construct();

		// Idiomas..
		$language = (isset($_SESSION['language'])) ? $_SESSION['language'] : 'espanol';

		$directorio = dir('system/language/' . $language);
		
		while ($archivo = $directorio->read())
		{
			if($archivo != 'index.html' && $archivo != '' && $archivo != '.' && $archivo != '..')
			{
				$this->lang->load(str_replace('_lang.php', '', $archivo), $language);
			}
		}

		$directorio = dir('application/language/' . $language);
		
		while ($archivo = $directorio->read())
		{
			if($archivo != 'index.html' && $archivo != '' && $archivo != '.' && $archivo != '..')
			{
				$this->lang->load(str_replace('_lang.php', '', $archivo), $language);
			}
		}

		$this->config->set_item('language', $language);
		// Fin de los Idiomas..

		// Buscar los tipos de cambio..

		$this->load->model('module_model');

		// Generando un Token de Acceso..
		$token = $this->mostrar_session('token'); // Si es que ya existe un Token que no se ha usado..

		if(empty($token))
		{
			$token = $this->encrypt->sha1(uniqid(rand()));
			$this->cargar_session('token', $token);
		}

		$this->configuracion = $this->module_model->seleccionar('configuracion', array(), 1, 1);

		if($this->input->is_ajax_request() !== TRUE AND strpos(current_url(), '/backend') !== FALSE)
		{
			$config['item_order'] = array('key' => 'orden', 'value' => 'ASC');
			$this->initialize($config);
			$this->menu = $this->module_model->seleccionar('backend_menu', array('estado' => 1)); $grupo = array();

			$this->clear_data(); // Limpiamos la Información..
		}

		$_ignore = ['eliminar', 'publicar', 'action_update', 'import', 'export', 'regresar', 'actualizar_tree'];

		if(strpos(current_url(), '/backend/') !== FALSE)
		{
			if($this->input->is_ajax_request() === TRUE)
			{
				$agregado = TRUE; $historial = (array) $this->mostrar_session('historial');
				$current_url = str_replace(backend_url(), '', current_url()); $ignorado = FALSE;

				foreach($_ignore as $key => $value)
				{
					if(strpos($current_url, $value) !== FALSE AND $agregado == TRUE)
					{
						$agregado = FALSE; $ignorado = TRUE;
					}
				}

				if($ignorado == FALSE)
				{
					$_historial = [];

					foreach($historial as $key => $value)
					{
						if($current_url == $value)
						{
							$_historial[] = $value; $agregado = FALSE;
						}

						elseif($current_url != $value AND $agregado == TRUE)
						{
							$_historial[] = $value;
						}
					}

					$historial = $_historial; $this->cargar_session('historial', $historial);
				}

				if($agregado == TRUE)
				{
					$historial[] = $current_url;
					$this->cargar_session('historial', $historial);
				}

				if(count($historial) > 0)
				{
					if($ignorado == TRUE)
					{
						$this->url_retorno = $historial[(count($historial) - 1)];
					}
					else
					{
						$this->url_retorno = $historial[(count($historial) - 2)];
					}
				}
			}
			else
			{
				$_ignore = ['agregar', 'ordenar_masivo', 'despublicar_masivo', 'publicar_masivo', 'eliminar_masivo'];

				if(isset($_POST) AND count($_POST) > 0 AND strpos(current_url(), '/backend/') !== FALSE)
				{
					$agregado = TRUE; $historial = (array) $this->mostrar_session('historial');
					$current_url = str_replace(backend_url(), '', current_url()); $ignorado = FALSE;

					foreach($_ignore as $key => $value)
					{
						if(strpos($current_url, $value) !== FALSE AND $agregado == TRUE)
						{
							$agregado = FALSE; $ignorado = TRUE;
						}
					}

					if($ignorado == FALSE)
					{
						$_historial = [];

						foreach($historial as $key => $value)
						{
							if($current_url == $value)
							{
								$_historial[] = $value; $agregado = FALSE;
							}

							elseif($current_url != $value AND $agregado == TRUE)
							{
								$_historial[] = $value;
							}
						}

						$historial = $_historial; $this->cargar_session('historial', $historial);
					}

					if($agregado == TRUE)
					{
						$historial[] = $current_url;
						$this->cargar_session('historial', $historial);
					}

					if(count($historial) > 0)
					{
						if($ignorado == TRUE)
						{
							if(strpos($current_url, '/agregar') !== FALSE)
							{
								$this->url_retorno = $historial[(count($historial) - 2)];
							}
							else
							{
								$this->url_retorno = $historial[(count($historial) - 1)];
							}
						}
						else
						{
							$this->url_retorno = $historial[(count($historial) - 1)];
						}
					}
				}
			}

			if($this->url_retorno == '' OR $this->url_retorno == NULL)
			{
				$historial = (array) $this->mostrar_session('historial');

				$this->url_retorno = $historial[(count($historial) - 1)];
			}

			$this->cargar_session('url_retorno', $this->url_retorno);
		}

		// Guardando un archivo de Logs por Administrador..
		if(self::mostrar_session('nivel') != 0 && self::mostrar_session('nivel') != NULL)
		{
			$this->module_model->guardar('log_administrador', array('id' => '', 'ip' => $this->input->ip_address(), 'accion' => $_SERVER['REQUEST_METHOD'], 'ruta' => current_url(), 'usuario' => self::mostrar_session('id'), 'fecha' => $this->fecha()));
		}
	}

	function regresar()
	{
		$historial = (array) $this->mostrar_session('historial');

		if(count($historial) > 1)
		{
			$resultado['url'] = $historial[(count($historial) - 2)];
		}
		else
		{
			$resultado['url'] = NULL;
		}

		$this->load->view("backend/templates/json_view", array('resultado' => $resultado));
	}

	function validar_recaptcha()
	{
		if(isset($_POST['g-recaptcha-response']))
		{
			$params = array();  // Array donde almacenar los parámetros de la petición
			$params['secret'] = '6LdtuUcUAAAAAB419K5uboENTwSFUH0Fggba80gq'; // Clave privada
			$params['response'] = urlencode($request->get('g-recaptcha-response'));
			$params['remoteip'] = $_SERVER['REMOTE_ADDR'];

			// Generar una cadena de consulta codificada estilo URL
			$params_string = http_build_query($params);
			// Creamos la URL para la petición
			$requestURL = 'https://www.google.com/recaptcha/api/siteverify?' . $params_string;

			// Inicia sesión cURL
			$curl = curl_init(); 
			// Establece las opciones para la transferencia cURL
			curl_setopt_array($curl,
				array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => $requestURL,
				)
			);

			// Enviamos la solicitud y obtenemos la respuesta en formato json
			$response = curl_exec($curl);
			// Cerramos la solicitud para liberar recursos
			curl_close($curl);
			// Devuelve la respuesta en formato JSON
			$response = json_decode($response);

			if($response->success == TRUE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}

	function cargar_datos($post = array(), $return = FALSE)
	{
		if(isset($_POST) && count($_POST) > 0)
		{
			$tabla = $this->input->post('id_padre');
		}
		else
		{
			$tabla = $post['id_padre'];
		}
		
		$where['estado'] = 1;

		if($tabla == 'institucional')
		{
			$tabla = 'institucional'; $where['tipo_padre'] = 1; $where['id_padre'] = 0;
		}
		if($tabla == 'servicios')
		{
			$tabla = 'institucional'; $where['tipo_padre'] = 2; $where['id_padre'] = 0;
		}
		if($tabla == 'sistema_nacional_archivos')
		{
			$tabla = 'institucional'; $where['tipo_padre'] = 3; $where['id_padre'] = 0;
		}
		if($tabla == 'nuestros_aliados')
		{
			$tabla = 'institucional'; $where['tipo_padre'] = 4; $where['id_padre'] = 0;
		}

		if($tabla == 'directorio_regional')
		{
			$tabla = 'directorio'; $where['tipo'] = 1;
		}

		if($tabla == 'directorio')
		{
			$tabla = 'directorio'; $where['tipo'] = 0;
		}

		$data['values'] = $this->module_model->seleccionar($tabla, $where);
		$data['id'] = 'id'; $data['valor'] = 'titulo';

		if($return == FALSE)
		{
			$this->load->view("backend/templates/select_view", $data);
		}
		else
		{
			return $data['values'];
		}
	}

	/**
	* @since 2014
	* @author Luis Shepherd
	* @method Iconos
	**/

	function mostrar_iconos()
	{
		$array = array();

		$items = array('fa-rub', 'fa-pagelines', 'fa-stack-exchange', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-left', 'fa-caret-square-o-left', 'fa-dot-circle-o', 'fa-wheelchair', 'fa-vimeo-square', 'fa-try', 'fa-plus-square-o', 'fa-adjust', 'fa-anchor', 'fa-archive', 'fa-arrows', 'fa-arrows-h', 'fa-arrows-v', 'fa-asterisk', 'fa-ban', 'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-beer', 'fa-bell', 'fa-bell-o', 'fa-bolt', 'fa-book', 'fa-bookmark', 'fa-bookmark-o', 'fa-briefcase');

		foreach($items as $key => $value)
		{
			$array[trim($value)] = '<span class="fa '.trim($value).' tooltips" title="'.trim($value).'"></span>';
		}		

		return $array;
	}

	/**
	* @since 2014
	* @author Luis Shepherd
	* @method Recursividad | Sidebar..
	**/

	function recursividad($array = array(), $indice = NULL, $anterior = FALSE)
    {
        $nuevo_array = ($anterior === FALSE) ? $array : array();

        if(count($array) > 0)
        {
            foreach($array as $key => $value)
            {
                $config['item_order'] = array('key' => 'orden', 'value' => 'ASC');
                $this->initialize($config);

                $resultado = $this->module_model->seleccionar('institucional', array('id_padre' => $value[$indice], 'estado' => 1, 'activado' => 1, 'menu' => 1));

                $nuevo_array[$value[$indice]] = $resultado;

                if(count($value) > 0 AND $value['tipo'] == 0)
                {
                    $this->recursividad($resultado, $indice, TRUE);
                }
            }
        }
        
        return $nuevo_array;
    }

	function buscar_elemento_sidebar($id = FALSE, $tipo = FALSE, $url = FALSE)
    {
    	$config['order'] = array('key' => 'orden', 'value' => 'asc');
    	$this->initialize($config);

        $data['elementos'] = $this->module_model->seleccionar('institucional', array('id_padre' => $id, 'tipo_padre' => $tipo, 'estado' => 1, 'activado' => 1));

        $html = '';
        if(count($data['elementos']) > 0)
        {
            $html .= '<ul>';
            foreach($data['elementos'] as $key => $value)
            {
            	$type = ($value['tipo_padre'] == 1) ? 'institucional' : (($value['tipo_padre'] == 2) ? 'padres' : 'servicios');

                $html .= '<li class="';
                if(current_url() == base_url().$type.'/'.$value['id'].'-'.$value['alias'])
                {
                	$html .= 'active';
                }
                $html .= ($key == count($data['elementos']) - 1) ? ' last' : NULL;
                $html .= '">';
                $html .= '<a ';
                if($value['tipo'] == 2)
                {
                	if($value['destino'] != '')
                	{
                		$html .= 'target="'.$value['destino'].'" ';
                	}
                }

                $html .= 'href="' . base_url() . $type . '/' . $value['id'] . '-' . $value['alias'] . '">';
                $html .= '<span>'.$value['titulo'].'</span>';
                $html .= '</a>';
                /*
                if($value['tipo'] == '0')
                {
                	$html .= self::buscar_elemento_sidebar($value['id'], $value['tipo_padre']); // recursividad
                }
                */
                $html .= '</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

	function mostrar_menu()
	{
		$array = array(); $grupo = array();

		if(self::mostrar_session('nivel') == 3 || self::mostrar_session('nivel') == 4)
		{
			$permiso_transparencia = $this->module_model->seleccionar('permisos', array('id_padre' => self::mostrar_session('id'), 'controlador' => 'transparencia', 'estado' => 1), 1, 1);
			$permiso_transparencia['url'] = 'transparencia';
			$permiso_transparencia['grupo'] = 'transparencia';
			$permiso_transparencia['icono'] = 'th-list';

			$this->menu[] = $permiso_transparencia;
		}
		
		foreach($this->menu as $key => $value)
		{
			$tipo_permisos = array('add' => 'add', 'update' => 'update', 'delete' => 'delete', 'all' => 'all', 'view' => 'view');

			if(self::mostrar_session('nivel') == 0 || self::mostrar_session('nivel') == 1) // Administradores
			{
				$array[$value['url']] = $value;
			}
			else
			{
				$permiso = $this->module_model->seleccionar('permisos', array('id_padre' => self::mostrar_session('id'), 'controlador' => $value['url'], 'estado' => 1), 1, 1);

				if(count($permiso) > 0)
				{
					$explode_permiso = explode('-', $permiso['acciones']);

					if($permiso['items'] != '')
					{
						$items_unlocked = explode("-", $permiso['items']); // Items Unlocked

						foreach($items_unlocked as $k => $v)
						{
							$this->items_unlocked[$value['url']][] = $v;
							#$data['items_unlocked'][$value] = TRUE;
						}
					}

					foreach($explode_permiso as $k => $v)
					{
						if($v == 'view')
						{
							$_SESSION['view'] = array($this->controller => TRUE);
						}

						$array[$value['url']] = $value;
						$this->permisos[$value['url']][$tipo_permisos[$v]] = TRUE;
					}
				}
			}
		}

		// Creación de los Grupos..
		foreach($array as $key => $value)
		{
			$grupo[$value['grupo']][] = $value;
		}
		// Fin de la Creación de los Grupos..

		return $grupo;
	}

	protected function retornar_menu($controlador = FALSE)
	{
		$menu = NULL;
		foreach($this->menu as $key => $value)
		{
			if($value['url'] == $controlador)
			{
				$menu = $value['id'];
			}
		}

		return $menu;
	}

	protected function cargar_miga_pan($titulo = NULL, $metodo = FALSE)
	{
		$continuar = TRUE; $anterior = current_url(); $nueva_session = array();
		
		$session = $this->mostrar_session('miga_pan');

		// Elementos Existentes..
		if(count($session) > 0)
		{
			foreach($session as $key => $value)
			{
				if(isset($value['link']) && $value['link'] != $anterior && $value['link'] != current_url() && $continuar === TRUE)
				{
					$nueva_session[] = $value;
					$anterior = $value['link'];
				}
				else
				{
					$continuar = FALSE;
				}
			}
		}
		// Elementos Existentes..

		if($metodo !== FALSE)
		{
			if($this->controller != $anterior)
			{
				$nueva_session[] = array('link' => $this->controller, 'texto' => $titulo, 'metodo' => 'abrir');
			}
		}
		else
		{
			if(current_url() != $anterior)
			{
				$nueva_session[] = array('link' => current_url(), 'texto' => $titulo);
			}
		}

		$session[$_REQUEST['parent']] = $nueva_session;

		//print_r($session); die;

		$this->cargar_session('miga_pan', $session);
	}

	function limpiar_texto($url)
	{
		$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
		$repl = array('a', 'e', 'i', 'o', 'u', 'n');
		$url = str_replace ($find, $repl, $url);

		$find = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
		$repl = array('a', 'e', 'i', 'o', 'u', 'n');
		$url = str_replace ($find, $repl, $url);

		$url = strtolower($url);
		
		$find = array(' ', '&', '\r\n', '\n', '+');
		$url = str_replace ($find, '-', $url);
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

		$repl = array('', '-', '');
		$url = preg_replace ($find, $repl, $url);

		return $url;
	}

	protected function validar_usuario()
	{
		$response = array();
		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0) // Si la consulta proviene de una petición AJAX
		{
			if(!isset($_SESSION[$this->session_name]['correo_electronico']))
			{
				$response['url'] = backend_url();
				$this->load->view("backend/templates/redirect_view", $response);
				exit;
			}
		}
		else
		{
			if(!isset($_SESSION[$this->session_name]['correo_electronico']))
			{
				redirect("backend", "refresh");
			}
		}
	}

	protected function cerrar_session()
	{
		$this->module_model->actualizar('administrador', array('userlist' => 0), $this->mostrar_session('id'));

		foreach($_SESSION[$this->session_name] as $key => $value)
		{
			$this->session->unset_userdata($key);
		}
		$this->session->sess_destroy();
		
		redirect("backend", "refresh");
	}

	protected function identificarse($correo_electronico = NULL)
	{
		$this->db->where("estado", 1);
		$this->db->where("activado", 1);
		$this->db->where("correo_electronico", $correo_electronico);
		$query = $this->db->get("administrador");
		$busqueda = $query->row_array();

		$data = array("correo_electronico" => $correo_electronico); // response

		if(count($busqueda) > 0) // identity
		{
			if($busqueda["contrasenia"] === $this->encrypt->sha1($this->input->post("contrasenia")))
			{
				// Guardando la variable en una COOKIE para poder bloquear la aplicación.

				$this->module_model->actualizar('administrador', array('userlist' => 1), $busqueda['id']);
				$this->cargar_cookie('correo_electronico', $busqueda['correo_electronico']);
				$this->cargar_cookie('usuario', $busqueda['nombres'].' '.$busqueda['apellidos']);
				$this->cargar_cookie('imagen', $busqueda['imagen']);

				foreach($busqueda as $key => $value)
				{
					if($key <> 'contrasenia')
					{
						$this->cargar_session($key, $value);
					}
				}

				redirect(backend_url(), "refresh");
			}
			else
			{
				$data['message'] = "Contraseña no coincide.";
			}
		}
		else
		{
			// Eliminar las cookies..
			delete_cookie($this->session_name);
			$data['message'] = "El usuario no existe.";
		}

		$this->load->view("backend/index_view", $data);
	}

	protected function cargar_session($key, $value)
	{
		$array = array();
		if(isset($_SESSION[$this->session_name]))
		{
			$array = $_SESSION[$this->session_name];
		}

		$array[$key] = $value;

		$this->session->set_userdata($this->session_name, $array);
	}

	protected function descargar_session($key)
	{
		$array = array();
		foreach($_SESSION[$this->session_name] as $k => $v)
		{
			if($k != $key)
			{
				$array[$k] = $v;
			}
		}

		$this->session->set_userdata($this->session_name, $array);
	}

	function mostrar_session($key)
	{
		$retorno = NULL;
		if(isset($_SESSION[$this->session_name]) && isset($_SESSION[$this->session_name][$key]))
		{
			$retorno = $_SESSION[$this->session_name][$key];
		}

		if($key == 'miga_pan')
		{
			if(isset($retorno[$_REQUEST['parent']]))
			{
				$retorno = $retorno[$_REQUEST['parent']];
			}
		}

		return $retorno;
	}

	protected function cargar_cookie($key, $value)
	{
		/*
		if(isset($_COOKIE[$this->session_name]))
		{
			$array = $_COOKIE[$this->session_name];
		}
		$array[$key] = $value;

		setcookie($this->session, $array);
		*/
	}

	protected function mostrar_cookie($key)
	{
		//return $_COOKIE[$this->session_name][$key];
	}

	protected function validar_formulario($id = NULL)
	{
		// Validaciones por Código..
		$config = array(); $validacion = FALSE; $busqueda = array();

		if($id != NULL)
		{
			$busqueda = $this->module_model->seleccionar($this->table, array('id' => $id), 1, 1);
		}

		foreach($this->items as $key => $value)
		{
			$validate = (isset($value['validate']) AND $value['validate'] != '') ? $value['validate'] : NULL;

			if($validate != NULL)
			{
				$config[] = array('field' => $key, 'label' => $value['text'][$this->config->item('language')], 'rules' => $validate);
			}
		}

		if(count($config) > 0)
		{
			$validacion = TRUE; $this->form_validation->set_rules($config);
		}
		// Fin de las Validaciones por Código..

		return $validacion;
	}

	protected function post_form($busqueda = array())
	{
		$array = array();

		foreach($this->items as $key => $value)
		{
			if($value['type'] != 'label')
			{
				// Valores Anteriores..
				$valor_anterior = isset($busqueda[$key]) ? $busqueda[$key] : NULL; $array[$key] = $valor_anterior;
				// Fin de los Valores Anteriores..

				$archivo = NULL;
				// Seteamos el valor de cualquier archivo.

				if($value['type'] == 'file') // Si fuera un archivo..
				{
					if(count($busqueda) == 0)
					{
						if(isset($value['dropzone']) && $value['dropzone'] == TRUE)
						{
							if($_FILES['file']['name'] != '')
							{
								$archivo = $this->cargar_archivo($valor_anterior, 'file');
							}
						}
						else
						{
							if($_FILES[$key]['name'] != '')
							{
								$archivo = $this->cargar_archivo($valor_anterior, $key);
							}
						}
					}
					else
					{
						if($_FILES[$key]['name'] != '')
						{
							$archivo = $this->cargar_archivo($valor_anterior, $key);
						}
					}
				}

				elseif($value['type'] == 'photo') // Si fuera una imagen..
				{
					if(count($busqueda) == 0)
					{
						if(isset($value['dropzone']) && $value['dropzone'] == TRUE)
						{
							if($_FILES['file']['name'] != '')
							{
								$flag = (isset($value['flag'])) ? $value['flag'] : 'height';
								$archivo = $this->cargar_imagen($valor_anterior, 'file', $value['sizes'], $flag);
							}
						}
						else
						{
							if($_FILES[$key]['name'] != '')
							{
								$flag = (isset($value['flag'])) ? $value['flag'] : 'height';
								$archivo = $this->cargar_imagen($valor_anterior, $key, $value['sizes'], $flag);
							}
						}
					}
					else
					{
						if($_FILES[$key]['name'] != '')
						{
							$flag = (isset($value['flag'])) ? $value['flag'] : 'height';
							$archivo = $this->cargar_imagen($valor_anterior, $key, $value['sizes'], $flag);
						}
					}
				}

				elseif($value['type'] == 'select') // Si fuera un campo seleccionable..
				{
					$array[$key] = $this->input->post($key);
				}

				elseif($value['type'] == 'multiple_select') // Si fuera un campo multiseleccionable..
				{
					if(isset($_POST[$key]) && count($_POST[$key]) > 0) // Si fuera un Campo Seleccionable..
					{
						$x = '';
						foreach($_POST[$key] as $k => $v)
						{
							$x .= $v;
							if($k < (count($_POST[$key]) - 1))
							{
								$x .= '-';
							}
						}
						$array[$key] = $x;
					}
				}

				elseif($value['type'] == 'checkbox') // Si fuera un checkbox..
				{
					$array[$key] = 0;

					if(isset($_POST[$key]) && $_POST[$key] == 'on')
					{
						$array[$key] = 1;
					}
				}

				elseif($value['type'] == 'group_checkbox')
				{
					if(isset($_POST[$key]) && count($_POST[$key]) > 0) // Si fuera un Campo Seleccionable..
					{
						$x = '';
						foreach($_POST[$key] as $k => $v)
						{
							$x .= $v;
							if($k < (count($_POST[$key]) - 1))
							{
								$x .= '-';
							}
						}
						$array[$key] = $x;
					}
				}

				elseif($value['type'] == 'radiobutton') // Si fuera un radiobutton..
				{
					$array[$key] = 0;

					if(isset($_POST[$key]) && $_POST[$key] == 'on')
					{
						$array[$key] = 1;
					}
				}

				elseif($value['type'] == 'date')
				{
					$array[$key] = date("Y-m-d", strtotime($this->input->post($key)));
				}

				elseif($value['type'] == 'password')
				{
					if($this->input->post($key) != '')
					{
						$array[$key] = $this->encrypt->sha1($this->input->post($key));
					}
				}
                
                elseif($value['type'] == 'youtube')
                {
                    $valor = NULL;
                    $item = explode('v=', $this->input->post($key));
                    $array[$key] = $item[1];
                }

                elseif($value['type'] == 'google_maps')
                {
                	$array[$key] = $this->input->post($key);
                	
                	if(isset($_POST[$key.'_latitud']))
                	{
                		$array[$key.'_latitud'] = $this->input->post($key . '_latitud');
                	}
                	if(isset($_POST[$key.'_longitud']))
                	{
                		$array[$key.'_longitud'] = $this->input->post($key . '_longitud');
                	}
                	if(isset($_POST['estado_'.$key]))
                	{
                		$array['estado_'.$key] = $this->input->post('estado_' . $key);
                	}
                }

                elseif($value['type'] == 'hidden')
                {
                	$array[$key] = ($value['value'] != '') ? $value['value'] : $this->input->post($key);
                }

                else
				{
					$array[$key] = $this->input->post($key);
				}

				if($archivo !== NULL)
				{
					$array[$key] = $archivo;
				}

				if(isset($value['session']) && $value['session'] == TRUE && $array[$key] != NULL)
				{
					$this->cargar_session($key, $array[$key]);
				}
			}
		}

		// ID Parentezco.. Para los links de los Padres..
		if(isset($_SESSION[$this->controller]['id_padre']))
		{
			$array['id_padre'] = $_SESSION[$this->controller]['id_padre'];
		}
		// Fin de los ID de Parentezco.. Para los links de los Padres..

		return $array;
	}

	public function clear_data()
	{
		$this->title[$this->config->item('language')] = NULL;
		$this->table = NULL;
		$this->items = array();
		$this->buttons = array();
		$this->controller = NULL;
		$this->publish = FALSE;
		$this->import = FALSE;
		$this->export = FALSE;
		$this->status = TRUE;
		$this->campo_referencia = NULL;
		$this->where = array();
		$this->help = NULL;
		$this->sidebar = TRUE;
		$this->url_retorno = NULL;
		$this->type = 'table';
		$this->order = FALSE;
		$this->breadcrumb = TRUE;
		$this->permisos = array();
		$this->item_order = array('key' => $this->parent_key, 'value' => 'ASC');
		$this->show_order = array('key' => 'activado', 'value' => 1);
		$this->actions = array();

		return $this;
	}

	public function initialize($config = array())
	{
		foreach($config as $key => $value)
		{
			$this->$key = $value;
		}
		
		return $this;
	}

	function remover()
	{
		$this->validar_usuario();

		$data['mensaje'] = $this->module_model->actualizar($this->input->post('table'), array($this->input->post('key') => ''), array($this->parent_key => $this->input->post('id')));
		$data['url'] = null;
		
		$this->load->view("backend/templates/json_view", array('resultado' => $data));
	}

	function cargar_archivo($archivo_anterior = NULL, $archivo = NULL)
	{
		$config['upload_path'] = $this->route;
        $config['allowed_types'] = '*';
        $this->upload->initialize($config);

        if($this->upload->do_upload($archivo))
        {
			$archivo = $this->upload->data();
			$retorno = $archivo['file_name'];

			if(isset($archivo['file_name']) && $archivo['file_name'] != '')
			{
				$this->borrar_archivo($archivo_anterior);
			}
        }
        else
        {
        	$retorno = NULL;
        }
        return $retorno;
	}

	protected function borrar_archivo($ruta)
	{
		@unlink($this->route . $ruta);
	}

	function obtener_informacion_archivo($archivo = FALSE)
	{
		if(file_exists('uploads/'.$archivo))
		{
			$enlace = 'uploads/'.$archivo; $formato_tipo = explode(".", $archivo);
			// Obteniendo la información previa..

			$data['tipo'] = $formato_tipo[(count($formato_tipo) - 1 )];
			$data['tamanio'] = self::formatBytes(filesize($enlace), 0);
		}
		else
		{
			$data['tipo'] = 'Ninguno'; $data['tamanio'] = '0 KB';
		}

		return $data;
	}

	function formatBytes($size, $precision = 2)
	{
		if($size > 0)
		{
			$base = log($size, 1024);
			$suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

			return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
		}
		else
		{
			return '0 KB';
		}
	}

	function descargar($archivo = FALSE, $nombre = FALSE)
	{
		$enlace = 'uploads/'.$archivo; $formato_tipo = explode(".", $archivo); $tipo = $formato_tipo[(count($formato_tipo) - 1 )]; $nombre = $this->limpiar_texto($nombre);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $archivo);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		readfile($enlace);
		exit;
	}

	function cargar_imagen($imagen_anterior = NULL, $imagen = NULL, $sizes = array(), $flag = 'height')
	{
		$retorno = NULL;
		
		$config['upload_path'] = $this->route;
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['file_name'] = time();
        $this->upload->initialize($config);

        if($this->upload->do_upload($imagen))
        {
			$info_imagen = $this->upload->data();

			$this->load->library('simple_image'); // Cargamos la librería de imagen..

			if(isset($info_imagen['file_name']))
			{
				$this->borrar_archivo($imagen_anterior);
			}

			foreach($sizes as $key => $value)
			{
				if(isset($info_imagen['file_name']))
				{
					$this->borrar_archivo($value.'/'.$imagen_anterior); // Borrar archivo..
				}

				$explode = explode("x", $value);

				$this->crear_miniatura($info_imagen['file_name'], $explode[0], $explode[1], $flag);
			}

			$this->crear_miniatura($info_imagen['file_name'], 100, 100, $flag); // Para las consultas de los Archivos..

			$retorno = $info_imagen['file_name'];
        }
        else
        {
        	$retorno = NULL;
        }
		
        return $retorno;
	}

	protected function crear_miniatura($imagen, $width, $height, $flag)
	{
		$this->simple_image->clear();
		$directorio = 'uploads/'.$width.'x'.$height.'/';
		@mkdir($directorio); // Crear el directorio para las imágenes..

		$config['source'] = 'uploads/'.$imagen;
		$config['filename'] = $imagen;
		$config['flag'] = $flag;
		$config['folder'] = $directorio;
		$config['size'] = array('width' => $width, 'height' => $height);
		$this->simple_image->initialize($config);

		$this->simple_image->resize();
		//$this->simple_image->save(); // Guardar la imagen
	}

	function fecha()
	{
		return date("Y-m-d H:i:s");
	}

	function fecha_muestra($fecha = 0)
	{
		$date = strtotime($fecha); // Convertir a segundos..

		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$dia = $dias[strftime("%w", $date)];
		$mes = $meses[(int)strftime("%m", $date)-1];
		return /* $dia . ', ' . */ strftime("%d", $date) . ' de ' . $mes . ' del ' . strftime("%Y", $date);
	}

	function fecha_hora_muestra($fecha = 0)
	{
		$date = strtotime($fecha); // Convertir a segundos..

		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$dia = $dias[strftime("%w", $date)];
		$mes = $meses[(int)strftime("%m", $date)-1];
		return strftime("%d", $date) . ' de ' . $mes . ' del ' . strftime("%Y", $date) . ' a las ' . strftime("%r", $date);
	}

	function contrasenia_aleatoria()
	{
		//Se define una cadena de caractares. Te recomiendo que uses esta.
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		//Obtenemos la longitud de la cadena de caracteres
		$longitudCadena=strlen($cadena);
		//Se define la variable que va a contener la contraseña
		$pass = "";
		//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
		$longitudPass=10;
		//Creamos la contraseña
		for($i=1 ; $i<=$longitudPass ; $i++){
			//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos=rand(0,$longitudCadena-1);
			//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;
	}

	// Fin de las Funciones Básicas..

	protected function render_email($titulo = NULL, $ayuda = NULL, $contenido = NULL)
	{
		$data['titulo'] = $titulo;
		$data['ayuda'] = $ayuda;
		$data['contenido'] = $contenido;

		return $this->load->view("backend/templates/email_view", $data, TRUE);
	}

	protected function enviar_email($contacto = NULL, $destinatario = NULL, $asunto = NULL, $contenido = NULL)
	{
		$config['mailtype'] = "html";
		$config['charset'] = "utf-8";
		$this->load->library('email', $config);

		$this->email->from($contacto, $contacto);

		$destinatario = explode(",", $destinatario); // Explode del Destinatario..

		foreach($destinatario as $key => $value)
		{
			$this->email->to($value);
		}

		$this->email->subject($asunto);
		$this->email->message($contenido);

		return $this->email->send();
	}

	protected function renderizar($data = array(), $retorno = FALSE)
	{
		$data['controller'] = $this->controller;
		$data['parent_key'] = $this->parent_key;
		$data['chat'] = $this->chat;
		$data['usuarios'] = $this->usuarios;
		$data['actions'] = $this->actions;
		$data['type'] = $this->type;

		if($retorno === TRUE)
		{
			if($this->type == 'table')
			{
				return $this->render_table($data, $retorno);
			}
			if($this->type == 'faq')
			{
				return $this->render_faq($data, $retorno);
			}
			if($this->type == 'gallery' || $this->type == 'dropzone')
			{
				return $this->render_gallery($data, $retorno);
			}
			if($this->type == 'tree')
			{
				return $this->render_tree($data, $retorno); // Renderización de un tree View..
			}
		}
		else
		{
			if($this->type === 'table')
			{
				$this->render_table($data, $retorno);
			}
			if($this->type === 'faq')
			{
				$this->render_faq($data, $retorno);
			}
			if($this->type === 'gallery' || $this->type == 'dropzone')
			{
				$this->render_gallery($data, $retorno);
			}
			if($this->type === 'tree')
			{
				$this->render_tree($data, $retorno); // Renderización de un tree View..
			}
		}
	}

	function render_table($data = array(), $retorno = FALSE)
	{
		$data['sidebar'] = $this->sidebar;
		$data['import'] = $this->import;
		$data['export'] = $this->export;

		if($this->paginate !== FALSE)
		{
			$page = (isset($_REQUEST['page'])) ? ($_REQUEST['page'] - 1) : 0;

			$data['results'] = $this->module_model->paginacion($this->table, $this->paginate, $page, $this->item_order['key'], $this->where);
			$data['totales'] = $this->module_model->total($this->table, $this->where);
			$data['links'] = ceil($data['totales'] / $this->paginate);
			$data['page'] = $page; $data['paginate'] = $this->paginate;
		}
		else
		{
			$data['results'] = $this->module_model->seleccionar($this->table, $this->where, 2);
		}

		//$data['results'] = $this->module_model->seleccionar($this->table, $this->where, 2);

		foreach($this->items as $key => $item)
		{
			if(isset($item['function']) && count($item['function']) > 0)
            {
            	foreach($data['results'] as $k => $v)
            	{
            		$post['id_padre'] = $v[$key]; $data_return = $this->$item['function']['event']($post, TRUE);
	                $key_item = $item['function']['children']; $this->items[$key_item]['items'] = $data_return;
            	}
            }
		}

		$data['items'] = $this->items; // Enviamos los Datos de los Items..
		$data['title'] = $this->title[$this->config->item('language')];
		$data['buttons'] = $this->buttons;

		// Paginación de CI

		// Fin de la Paginación CI..

		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			$html['resultado'] = $this->load->view("backend/templates/table_view", $data, TRUE);

			if($retorno === TRUE)
			{
				return $this->load->view("backend/templates/json_view", $html, $retorno);
			}
			else
			{
				$this->load->view("backend/templates/json_view", $html);
			}
		}
		else
		{
			$this->load->view("backend/templates/header_view", $data); // Renderización de la Cabecera..
			$this->load->view("backend/templates/table_view", $data);
			$this->load->view("backend/templates/footer_view", $data); // Renderización del Footer
		}
	}

	protected function render_gallery($data = array(), $retorno = FALSE)
	{
		$data['sidebar'] = $this->sidebar;
		$data['items'] = $this->items; // Enviamos los Datos de los Items..
		$data['title'] = $this->title[$this->config->item('language')];
		$data['buttons'] = $this->buttons;

		// Paginación de CI

		// Fin de la Paginación CI..
		$data['results'] = $this->module_model->seleccionar($this->table, $this->where, 2);

		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			$html['resultado'] = $this->load->view("backend/templates/gallery_view", $data, TRUE);

			if($retorno === TRUE)
			{
				return $this->load->view("backend/templates/json_view", $html, $retorno);
			}
			else
			{
				$this->load->view("backend/templates/json_view", $html);
			}
		}
		else
		{
			$this->load->view("backend/templates/header_view", $data); // Renderización de la Cabecera..
			$this->load->view("backend/templates/gallery_view", $data);
			$this->load->view("backend/templates/footer_view", $data); // Renderización del Footer
		}
	}

	protected function render_faq($data = array(), $retorno = FALSE)
	{
		$data['sidebar'] = $this->sidebar;
		$data['items'] = $this->items; // Enviamos los Datos de los Items..
		$data['title'] = $this->title[$this->config->item('language')];

		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			$html['resultado'] = $this->load->view("backend/templates/faq_view", $data, TRUE);

			if($retorno === TRUE)
			{
				return $this->load->view("backend/templates/json_view", $html, $retorno);
			}
			else
			{
				$this->load->view("backend/templates/json_view", $html);
			}
		}
		else
		{
			$this->load->view("backend/templates/header_view", $data); // Renderización de la Cabecera..
			$this->load->view("backend/templates/faq_view", $data);
			$this->load->view("backend/templates/footer_view", $data); // Renderización del Footer
		}
	}

	protected function render_tree($data = array(), $retorno = FALSE)
	{
		$data['sidebar'] = $this->sidebar;
		$data['items'] = $this->items; // Enviamos los Datos de los Items..
		$data['title'] = $this->title[$this->config->item('language')];
		$data['buttons'] = $this->buttons;

		$config['item_order'] = array('key' => 'orden', 'value' => 'asc');
        $this->initialize($config);

		$data['response'] = $this->module_model->seleccionar($this->table, $this->where, 2);

		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			$html['resultado'] = $this->load->view("backend/templates/tree_view", $data, TRUE);

			if($retorno === TRUE)
			{
				return $this->load->view("backend/templates/json_view", $html, $retorno);
			}
			else
			{
				$this->load->view("backend/templates/json_view", $html);
			}
		}
		else
		{
			$this->load->view("backend/templates/header_view", $data); // Renderización de la Cabecera..
			$this->load->view("backend/templates/tree_view", $data);
			$this->load->view("backend/templates/footer_view", $data); // Renderización del Pie..
		}
	}

	function mostrar_item_tree($id_padre = FALSE)
	{
		// Generando los órdenes..
		$config['item_order'] = array('key' => 'orden', 'value' => 'asc');
        self::initialize($config);
		// Generando los órdenes..

		if($id_padre !== FALSE)
		{
			$this->where['id_padre'] = $id_padre;
		}

		$response = $this->module_model->seleccionar($this->table, $this->where, 2);

		return $this->load->view("backend/templates/item_tree_view", array('response' => $response, 'controller' => $this->controller), TRUE);
	}

	function index($retorno = FALSE, $data = array())
	{
		$array = array(); $tipo_permisos = array('add' => 'add', 'update' => 'update', 'delete' => 'delete', 'all' => 'all', 'view' => 'view');

		$data['item_order'] = $this->item_order; // Activando el Orden..

		if($retorno === FALSE)
		{
			if($this->mostrar_session('nivel') == 0 || $this->mostrar_session('nivel') == 1 || $this->mostrar_session('nivel') == 3) // Administradores
			{
				$array = $this->buttons;
			}
			else
			{
				$config['item_order'] = array('key' => $this->parent_key, 'value' => 'ASC'); $this->initialize($config); // Reseteando el Orden..
				$permiso = $this->module_model->seleccionar('permisos', array('id_padre' => $this->mostrar_session('id'), 'controlador' => $this->controller, 'estado' => 1), 1, 1);

				if(count($permiso) > 0)
				{
					$explode_permiso = explode('-', $permiso['acciones']);

					if(!in_array('view', $explode_permiso))
					{
						if(in_array('all', $explode_permiso))
						{
							$array = $this->buttons;
						}
						else
						{
							$buttons = array();
							foreach($this->buttons as $k => $v)
							{
								$buttons[$v['type']] = $v;
							}

							foreach($explode_permiso as $k => $v)
							{
								$array[] = $buttons[$v];
							}
						}
					}
					else
					{
						$_SESSION['view'] = array($this->controller => TRUE);
					}
				}
			}
		}
		else
		{
			if($this->mostrar_session('nivel') == 0 || $this->mostrar_session('nivel') == 1 || !isset($_SESSION['view'][$this->controller]))
			{
				$array = $this->buttons;
			}
		}

		$this->buttons = $array;

		if($this->locked === TRUE)
		{
			$this->load->view("backend/locked_view"); // Si hay bloqueo..
		}
		else
		{
			$this->validar_usuario(); // Verificando la Sesión del Usuario..
			
			$data['publish'] = $this->publish; // Enviando el switch de publicacion..
			$data['tamanio_disco'] = $this->tamanio_disco; // Enviando el Tamaño del Disco..
			$data['controller'] = $this->controller;
			$data['readonly'] = $this->readonly;
			$data['status'] = $this->status;
			$data['help'] = $this->help;
			$data['order'] = $this->order;
			$data['show_order'] = $this->show_order;

			// $url_retorno_parent = $this->mostrar_session('url_retorno_parent'); $_controller = $this->mostrar_session('controller');

			if(!isset($_SESSION[$this->controller]['id_padre']) || isset($_REQUEST['id_padre']) && $_REQUEST['id_padre'] == 0)
			{
				/*
				if($url_retorno_parent != '' AND $this->controller != $_controller)
				{
					$this->cargar_session('url_retorno', $url_retorno_parent);
				}
				else
				{
					$this->cargar_session('url_retorno', $this->controller);
				}
				*/
			}

			if(isset($_REQUEST['id_padre']) && $_REQUEST['id_padre'] == '0')
			{
				$this->descargar_session('miga_pan');
				unset($_SESSION[$this->controller]['id_padre']);
			}

			/*
			if(isset($_SESSION[$this->controller]['id_padre']))
			{
				$this->where['id_padre'] = $_SESSION[$this->controller]['id_padre'];
			}
			*/

			if($this->breadcrumb === TRUE)
			{
				// Carga de la Miga de Pan..
				$this->cargar_miga_pan($this->title[$this->config->item('language')], 'abrir');
				// Fin de la Carga de la Miga de Pan..
			}
			
			if($retorno === TRUE)
			{
				return $this->renderizar($data, TRUE);
			}
			else
			{
				$this->renderizar($data);
			}
		}
	}

	function cargar_opciones()
	{
		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			$data['values'] = $this->module_model->seleccionar($this->table, $this->where);
			$data['id'] = $_REQUEST['id'];
			$data['valor'] = $_REQUEST['valor'];

			$this->load->view("backend/templates/select_view", $data);
		}
		else
		{
			$this->error_404();
		}
	}

	function agregar()
	{
		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0 || ((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0)))
		{
			$dataset['help'] = $this->help;
			$dataset['title'] = $this->title[$this->config->item('language')];
			$dataset['items'] = $this->items;
			$dataset['buttons'] = $this->buttons;
			$dataset['readonly'] = $this->readonly;
			$dataset['controller'] = $this->controller;
			$dataset['valor_retorno'] = isset($_REQUEST['valor_retorno']) ? $_REQUEST['valor_retorno'] : 1;
			$dataset['parent_key'] = $this->parent_key;
			$dataset['chat'] = $this->chat;
			$dataset['breadcrumb'] = $this->breadcrumb;
			$dataset['table'] = $this->table;

			if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
			{
				$this->validar_usuario(); // Verificando la Sesión del Usuario..

				if($this->retorno === TRUE)
				{
					$html['resultado'] = $this->load->view("backend/templates/form_view", $dataset, TRUE);
					$this->load->view("backend/templates/json_view", $html);
				}
				else
				{
					$this->load->view("backend/templates/header_view");
					$this->load->view("backend/templates/form_view", $dataset);
					$this->load->view("backend/templates/footer_view");
				}
			}
			
			if((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0))
			{
				$validacion = $this->validar_formulario();

				# print_r($validacion); die;

				if($validacion == TRUE && $this->form_validation->run() == FALSE)
				{
					$data['mensaje'] = validation_errors();
					$data['url'] = null;
					
					$this->load->view("backend/templates/print_json_view", array('data' => $data));
				}
				else
				{
					$array = $this->post_form();

					# print_r($array); die;

					$array['estado'] = 1;
					$array['usuario_creacion'] = $this->mostrar_session('id');
					$array['usuario_modificacion'] = $this->mostrar_session('id');
					$array['fecha_creacion'] = $this->fecha();
					$array['fecha_modificacion'] = $this->fecha();

					$data['mensaje'] = $this->module_model->guardar($this->table, $array); // Guardar datos..
					
					$mayor = $this->module_model->buscar_mayor($this->table); // Actualizando los Detalles..					

					if(isset($_REQUEST['valor_retorno']) && $_REQUEST['valor_retorno'] == 1)
					{
						if(isset($_POST['retorno']) && $_POST['retorno'] == 0)
						{
							$data['url'] = $this->controller.'/actualizar/'.$mayor['id'];
						}
						else
						{
							$data['url'] = $this->mostrar_session('url_retorno');
						}
					}
					else
					{
						$data['url'] = NULL;
					}

					$this->load->view("backend/templates/print_json_view", array('data' => $data));
				}
			}
		}
		else
		{
			$this->error_404();
		}
	}

	function actualizar($id = 0, $locked = FALSE) // Metodo para actualizar un registro..
	{
		$this->validar_usuario(); $readonly_anterior = $this->readonly;

		if($locked === TRUE || (isset($_REQUEST['editing']) && $_REQUEST['editing'] == 1))
		{
			$config['readonly'] = TRUE;

			$items = array(); $array = array();
			foreach($this->items as $key => $value)
			{
				$items = $value;
				$items['readonly'] = TRUE;
				$array[$key] = $items; // Montar el nuevo array;
			}

			$config['items'] = $array;
			$this->initialize($config);
		}

		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0 || ((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0)))
		{
			$dataset['values'] = $this->module_model->buscar($this->table, $id); // Resultado de la búsqueda..
			$dataset['title'] = $this->title[$this->config->item('language')];

			if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
			{
				foreach($this->items as $key => $item)
				{
					if(isset($item['function']) && count($item['function']) > 0)
		            {
		                $busqueda = $this->module_model->buscar($this->table, $id); $post['id_padre'] = $busqueda[$key];
		                $retorno = $this->$item['function']['event']($post, TRUE);
		                $key_item = $item['function']['children']; $this->items[$key_item]['items'] = $retorno;
		            }
				}
			}

			$dataset['items'] = $this->items;
			$dataset['buttons'] = $this->buttons;
			$dataset['readonly'] = $this->readonly;
			$dataset['controller'] = $this->controller;
			$dataset['valor_retorno'] = (isset($_REQUEST['valor_retorno'])) ? $_REQUEST['valor_retorno'] : 1;
			$dataset['help'] = $this->help;
			$dataset['parent_key'] = $this->parent_key;
			$dataset['chat'] = $this->chat;
			$dataset['breadcrumb'] = (isset($_REQUEST['editing']) && $_REQUEST['editing'] == 1) ? FALSE : $this->breadcrumb;
			$dataset['table'] = $this->table;

			if($this->breadcrumb === TRUE)
			{
				$this->cargar_miga_pan($dataset['values'][$this->campo_referencia]);
			}

			if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
			{
				/*
				if(count($this->elementos_adicionales) > 0)
				{
					$this->cargar_session('url_retorno_parent', $this->controller.'/actualizar/'.$id);
				}
				else
				{
					$this->descargar_session('url_retorno_parent');
				}
				*/

				$html['resultado'] = $this->load->view("backend/templates/form_view", $dataset, TRUE);
				
				if(count($this->elementos_adicionales) > 0)
				{
					foreach($this->elementos_adicionales as $key => $value)
					{
						if(!isset($value['show']) || (isset($value['show']) && is_array($value['show']) && $value['show']['valor'] == $dataset['values'][$value['show']['campo']]))
						{
							$value['breadcrumb'] = FALSE;
							$value['readonly'] = $readonly_anterior;

							foreach($value as $k => $v)
							{
								if($k == 'where')
								{
									$value[$k]['id_padre'] = $id; // Agregando el ID PADRE..
								}
							}

							$this->session->set_userdata($value['controller'], array('id_padre' => $id));

							# print_r($_SESSION[$value['controller']]); die;

							$this->clear_data(); $this->initialize($value); // Cargando los nuevos valores..
							$html['resultado'] .= json_decode($this->index(TRUE));
						}
					}
				}

				$this->load->view("backend/templates/json_view", $html);
			}
			
			if((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0))
			{
				$validacion = $this->validar_formulario($id);

				if ($validacion === TRUE && $this->form_validation->run() === FALSE)
				{
					$data['url'] = NULL;
					$data['mensaje'] = validation_errors();
					$this->load->view("backend/templates/print_json_view", array('data' => $data));
				}
				else
				{
					$array = $this->post_form($dataset['values']);

					$array['usuario_modificacion'] = $this->mostrar_session('id');
					$array['fecha_modificacion'] = $this->fecha();
					$data['mensaje'] = $this->module_model->actualizar($this->table, $array, $id); // Guardar datos

					if($_REQUEST['valor_retorno'] == 1)
					{
						if(isset($_POST['retorno']) && $_POST['retorno'] == 0)
						{
							$data['url'] = NULL;
						}
						else
						{
							$miga_pan = $this->mostrar_session('miga_pan');

							if(count($miga_pan) > 0)
							{
								// Si hay sesión de miga de pan..
								$data['url'] = str_replace(array(backend_url()), array(''), $miga_pan[count($miga_pan) - 2]['link']);
								$data['metodo'] = $miga_pan[count($miga_pan) - 2]['metodo'];
							}
							else
							{
								// si no hay sesión de miga de pan..
								$data['url'] = $this->mostrar_session('url_retorno');
							}
						}
					}
					else
					{
						$data['url'] = NULL;
					}

					$this->load->view("backend/templates/print_json_view", array('data' => $data));
				}
			}
		}
		else
		{
			$data['values'] = $this->module_model->buscar($this->table, $id); // Resultado de la búsqueda..
			$data['title'] = $this->title[$this->config->item('language')];
			$data['items'] = $this->items;
			$data['readonly'] = $this->readonly;
			$data['controller'] = $this->controller;

			$this->load->view("backend/templates/header_view", $data);
			$this->load->view("backend/templates/form_view", $data);
			$this->load->view("backend/templates/footer_view", $data);
		}
	}


	function actualizar_tree()
	{
		if(isset($_POST) && count($_POST) > 0)
		{
			$this->validar_usuario(); // Verificando la sesión del usuario..

			$data['url'] = NULL; $items = json_decode($_POST['items'], true);

			if(count($items) > 0)
			{				
				foreach($items as $key => $value)
				{
					$array = array();

					if(isset($value['idPadre']) && $value['idPadre'] != '')
					{
						$array['id_padre'] = 0;
					}
					
					if(isset($_SESSION[$this->controller]['id_padre']) && $_SESSION[$this->controller]['id_padre'] > 0)
					{
						$array['id_padre'] = $_SESSION[$this->controller]['id_padre'];
					}

					if(isset($value['orden']) && $value['orden'] != ($key + 1))
					{
						$array['orden'] = (int)($key + 1);

						$this->module_model->actualizar($this->table, $array, $value['id']);
					}

					if(isset($value['children']) && count($value['children']) > 0)
					{
						foreach($value['children'] as $k => $v)
						{
							$children = array(); $children['id_padre'] = $value['id'];

							if(isset($v['orden']) && $v['orden'] != ($k + 1))
							{
								$children['orden'] = (int)($k + 1);

								$this->module_model->actualizar($this->table, $children, $v['id']);
							}
						}
					}
				}

				$data['mensaje'] = "Elementos ordenados correctamente.";
			}
			else
			{
				$data['mensaje'] = "Seleccione uno o más registros para ordenar.";
			}

			$this->load->view("backend/templates/json_view", array('resultado' => $data));
		}
	}

	function actualizar_sortable()
	{
		if(isset($_POST) && count($_POST) > 0)
		{
			$this->validar_usuario(); // Verificando la sesión del usuario..

			$data['url'] = NULL; // Ruta de Respuesta..

			$items = $_POST['items'];

			foreach($items as $key => $value)
			{
				$array['orden'] = (int)($key + 1);

				$this->module_model->actualizar($this->table, $array, $value);
			}

			$data['mensaje'] = "Galería ordenada correctamente.";

			$this->load->view("backend/templates/json_view", array('resultado' => $data));
		}
	}

	function visualizar($id = FALSE)
	{
		$config['readonly'] = TRUE;
		$this->initialize($config); // Lo colocamos como archivos de lectura..

		$this->actualizar($id, TRUE);
	}

	function eliminar($id = 0) // Metodo para eliminar un registro..
	{
		if($this->input->is_ajax_request() === TRUE && isset($_GET) && count($_GET) > 0)
		{
			if(is_array($this->elementos_adicionales) AND count($this->elementos_adicionales) > 0)
			{
				foreach($this->elementos_adicionales as $key => $value)
				{
					$busqueda = $this->module_model->seleccionar($value['table'], array('id_padre' => $id, 'estado' => 1));

					foreach($busqueda as $k => $v)
					{
						$this->module_model->eliminar($value['table'], $v['id']);
						// Actualizando los valores..
					}
				}
			}

			$data['mensaje'] = $this->module_model->eliminar($this->table, $id);
			// Actualizando los valores..
			
			$data['url'] = $this->mostrar_session('url_retorno'); // Verificando que se quiere cerrar el formulario.
			$this->load->view("backend/templates/print_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}
	}

	function publicar($id = 0) // Metodo para publicar registros..
	{
		if(isset($_POST))
		{
			$array = array();
			foreach($_POST as $key => $value)
			{
				if($key != 'token')
				{
					$array[$key] = $value;
				}
			}

			$data['mensaje'] = $this->module_model->actualizar($this->table, $array, $id); // Actualizando los valores..
			$data['url'] = $this->mostrar_session('url_retorno'); // Verificando que se quiere cerrar el formulario.
			$this->load->view("backend/templates/print_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}		
	}

	function action_update($id = 0) // Metodo para publicar registros..
	{
		if(isset($_POST))
		{
			$array[$this->input->post('campo')] = $this->input->post('valor');

			$data['mensaje'] = $this->module_model->actualizar($this->table, $array, $id); // Actualizando los valores..
			$data['url'] = $this->mostrar_session('url_retorno'); // Verificando que se quiere cerrar el formulario.
			$this->load->view("backend/templates/print_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}		
	}

	function ordenar_masivo() // Metodo para Ordenar registros..
	{
		$data['mensaje'] = NULL;
		if(isset($_POST))
		{
			$data['mensaje'] = "No se seleccionó ningún registro."; $data['url'] = NULL;
			
			if(isset($_POST['orden']) && count($_POST['orden']) > 0)
			{
				$data['mensaje'] = NULL;
				foreach($_POST['orden'] as $key => $value)
				{
					$data['mensaje'] = $this->module_model->actualizar($this->table, array('orden' => $value), $key);
				}
				$data['url'] = $this->mostrar_session('url_retorno');
			}

			$this->load->view("backend/templates/print_json_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}
	}

	function despublicar_masivo()
	{
		$data['mensaje'] = NULL;
		if(isset($_POST))
		{
			$data['mensaje'] = "No se seleccionó ningún registro."; $data['url'] = NULL;
			
			if(count($_POST['item']) > 0)
			{
				$data['mensaje'] = NULL;
				foreach($_POST['item'] as $key => $value)
				{
					$data['mensaje'] = $this->module_model->actualizar($this->table, array('activado' => 0), $value);
				}
				$data['url'] = $this->mostrar_session('url_retorno');
			}
			
			$this->load->view("backend/templates/print_json_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}
	}

	function publicar_masivo()
	{
		$data['mensaje'] = NULL;
		
		if(isset($_POST))
		{
			$data['mensaje'] = "No se seleccionó ningún registro."; $data['url'] = NULL;
		
			if(count($_POST['item']) > 0)
			{
				$data['mensaje'] = NULL;

				foreach($_POST['item'] as $key => $value)
				{
					$data['mensaje'] = $this->module_model->actualizar($this->table, array('activado' => 1), $value);
				}

				$data['url'] = $this->mostrar_session('url_retorno');
			}
		
			$this->load->view("backend/templates/print_json_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}
	}

	function eliminar_masivo()
	{
		$data['mensaje'] = NULL;

		if(isset($_POST) AND count($_POST) > 0)
		{
			$data['mensaje'] = "No se seleccionó ningún registro."; $data['url'] = NULL;
			
			if(count($_POST['item']) > 0)
			{
				$data['mensaje'] = NULL;

				foreach($_POST['item'] as $key => $value)
				{
					if(is_array($this->elementos_adicionales) AND count($this->elementos_adicionales) > 0)
					{
						foreach($this->elementos_adicionales as $k => $v)
						{
							$busqueda = $this->module_model->seleccionar($v['table'], array('id_padre' => $value, 'estado' => 1));

							foreach($busqueda as $i => $j)
							{
								$this->module_model->eliminar($v['table'], $j['id']);
								// Actualizando los valores..
							}
						}
					}

					$data['mensaje'] = $this->module_model->eliminar($this->table, $value);
				}

				$data['url'] = $this->mostrar_session('url_retorno');
			}
			
			$this->load->view("backend/templates/print_json_view", array('data' => $data));
		}
		else
		{
			$this->error_404();
		}
	}

	function import()
	{
		$archivo = $this->cargar_archivo('', 'file_import_' . $this->input->post('controller'), '*');
		$cabeceras = $this->import['cabeceras'];

		$data['mensaje'] = "No se pudo cargar el archivo. Por favor, intente nuevamente."; $data['url'] = $this->input->post('controller');

		if($archivo !== NULL)
		{
			$objPHPExcel = PHPExcel_IOFactory::load($this->route.$archivo);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
			{
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				
				for ($row = $this->import['fila']; $row <= $highestRow; ++ $row)
				{
					$array = array(); $array[$this->parent_key] = '';

					for ($col = $this->import['columna']; $col < $highestColumnIndex; ++ $col)
					{
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						if(isset($cabeceras[$col]) && $cabeceras[$col] != NULL)
						{
							$array[$cabeceras[$col]] = str_replace(array('\'', '"', ','), ' ', trim($cell->getValue()));
						}
					}

					foreach($this->import['campos_adicionales'] as $key => $value)
					{
						$array[$key] = trim($value);
					}

					$array['fecha_creacion'] = $this->fecha();
					$array['fecha_modificacion'] = $this->fecha();
					$array['usuario_creacion'] = 1;
					$array['usuario_modificacion'] = 1;

					$this->module_model->guardar($this->import['tabla'], $array);
				}
			}
			
			$data['mensaje'] = "La importación se ejecutó con éxito.";
		}

		$this->load->view("backend/templates/print_json_view", array('data' => $data));
	}

	function export()
	{
		$registros = $this->module_model->seleccionar($this->table, $this->where);

		$objPHPExcel = new PHPExcel(); $row = 1; $col = 0;

		foreach($this->items as $key => $value)
		{
			if($value['type'] != 'label')
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $value['text']['espanol']); $col++;
			}
		}

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, 'Estado'); $col++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, 'Fecha Creación'); $col++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, 'Fecha Modificación');

		$row++;

		foreach($registros as $key => $value)
		{
			$col = 0; $item = "";

			foreach($this->items as $k => $v)
			{
				if($v['type'] != 'label')
				{
					$item = $value[$k];

					if($v['type'] === 'select')
					{
						$key_item = (int) $value[$k]; $item = $v['items'][$key_item];
					}

					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $item); $col++;
				}
			}

			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $value['estado']); $col++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $value['fecha_creacion']); $col++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $row, $value['fecha_modificacion']);

			$row++;
		}

		$objPHPExcel->getActiveSheet()->setTitle($this->title['espanol']);
		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte.xls"');
		header('Cache-Control: max-age=0');

		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}

/* End of file self.php */
/* Location: ./application/core/self.php */