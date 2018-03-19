<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function idioma($titulo = FALSE)
	{
		$this->validar_usuario();

		if($titulo <> FALSE)
		{
			$this->session->set_userdata('language', $titulo);
		}
	}

	function index()
	{
		if(!isset($_SESSION[$this->session_name]['correo_electronico']))
		{
			/*
			if(isset($_COOKIE[$this->session_name]))
			{
				if($this->input->post() === FALSE)
				{
					$data['usuario'] = $this->mostrar_cookie('usuario');
					$data['imagen'] = $this->mostrar_cookie('imagen');
					$this->load->view("backend/locked_view", $data);
				}
				else
				{
					$this->identificarse($this->mostrar_cookie('correo_electronico'));
				}
			}
			else
			{
			*/
				if($this->input->post() === FALSE)
				{
					$this->load->view("backend/index_view");
				}
				else
				{
					$this->identificarse($this->input->post("correo_electronico"));
				}
			/*
			}
			*/
		}
		else
		{
			if($this->input->post("logout") == "true")
			{
				$this->cerrar_session();
			}
			else
			{
				$where = []; $cantidad_por_pagina = 20; $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 0;

				if(@$_GET['fecha_inicio'] != '')
				{
					$where['DATE_FORMAT(fecha, "%Y-%m-%d") >='] = date("Y-m-d", strtotime($_GET['fecha_inicio']));
				}

				if(@$_GET['fecha_fin'] != '')
				{
					$where['DATE_FORMAT(fecha, "%Y-%m-%d") <='] = date("Y-m-d", strtotime($_GET['fecha_fin']));
				}

				if(@$_GET['usuario'] != '')
				{
					$where['usuario'] = $_GET['usuario'];
				}

				$config['item_order'] = array('key' => 'id', 'value' => 'desc');
				$this->initialize($config);
				$data['logs'] = $this->module_model->paginacion('log_administrador', $cantidad_por_pagina, $pagina, array('fecha', 'desc'), $where);

				$totales = $this->module_model->total('log_administrador', $where);
        		$data['links'] = ceil($totales / $cantidad_por_pagina);

				$usuarios = $this->module_model->seleccionar('administrador', array('estado' => 1, 'activado' => 1, 'nivel >' => 0));

				foreach($usuarios as $key => $value)
				{
					$data['usuarios'][$value['id']] = $value;
				}

				$this->load->view("backend/home_view", $data);
				
				//$this->verificar_tipo(); // Verificamos el tipo de proceso que se hará.
			}
		}
	}

	function token()
	{
		$data['token'] = $this->mostrar_session('token');
		$this->load->view("backend/templates/json_view", array('resultado' => $data));
	}

	function perfil()
	{
		$this->validar_usuario(); // Verificando la sesión del usuario..

		// Items para el Perfil..
		$items['correo_electronico'] = array('type' => 'text', 'text' => array('espanol' => 'Correo Electrónico', 'english' => 'Email'), 'placeholder' => 'Ingrese su correo electrónico', 'validate' => 'required|valid_email', 'session' => TRUE);
		$items['nombres'] = array('type' => 'text', 'text' => array('espanol' => 'Nombres', 'english' => 'Name'), 'placeholder' => 'Ingrese sus nombres', 'validate' => 'required', 'session' => TRUE);
		$items['apellidos'] = array('type' => 'text', 'text' => array('espanol' => 'Apellidos', 'english' => 'Last Name'), 'placeholder' => 'Ingrese sus apellidos', 'validate' => 'required', 'session' => TRUE);
		$items['imagen'] = array('type' => 'photo', 'text' => array('espanol' => 'Imagen', 'english' => 'Photo'), 'sizes' => array('33x33'), 'session' => TRUE);
		$items['acerca_de'] = array('type' => 'textarea', 'text' => array('espanol' => 'Información Adicional', 'english' => 'Information Aditional'), 'placeholder' => 'Ingrese una información adicional', 'session' => TRUE);
		// Fin de los Items para el Perfil..

		$config['title'] = array('espanol' => 'Perfil', 'english' => 'Profile');
		$config['items'] = $items;
		$config['table'] = 'administrador';
		$config['controller'] = 'perfil';
		$config['breadcrumb'] = FALSE;

		$buttons = array();
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar el Perfil', 'english' => 'Update Profile'));

		$config['buttons'] = $buttons;

		$this->initialize($config); // Inicializando valores..
		$this->actualizar($this->mostrar_session('id'));
	}

	function contrasenia()
	{
		$this->validar_usuario(); // Verificando la sesión del usuario..

		// Items para el Perfil..
		$items['contrasenia_anterior'] = array('type' => 'password', 'text' => array('espanol' => 'Contraseña Anterior', 'english' => 'Old Password'), 'placeholder' => 'Ingrese su contraseña anterior', 'validate' => 'required');
		$items['nueva_contrasenia'] = array('type' => 'password', 'text' => array('espanol' => 'Nueva Contraseña', 'english' => 'New Password'), 'placeholder' => 'Ingrese su nueva contraseña' , 'validate' => 'required');
		$items['repetir_contrasenia'] = array('type' => 'password', 'text' => array('espanol' => 'Repetir Contraseña', 'english' => 'Repeat Password'), 'placeholder' => 'Repita su nueva contraseña', 'validate' => 'required');
		// Fin de los Items para el Perfil..

		$config['table'] = 'administrador';
		$config['controller'] = 'contrasenia';
		$config['title'] = array('espanol' => 'Contraseña', 'english' => 'Password');
		$config['items'] = $items;
		$config['breadcrumb'] = FALSE;

		$buttons = array();
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar la Contraseña', 'english' => 'Update Password'));

		$config['buttons'] = $buttons;

		$this->initialize($config);

		if($this->input->post() === FALSE)
		{
			$this->actualizar($this->mostrar_session('id'));
		}
		else
		{
			$busqueda = $this->module_model->buscar($this->table, $this->mostrar_session('id'));
			
			if($this->encrypt->sha1($this->input->post('contrasenia_anterior')) == $busqueda['contrasenia'])
			{
				if($this->input->post('nueva_contrasenia') === $this->input->post('repetir_contrasenia'))
				{
					$array['contrasenia'] = $this->encrypt->sha1($this->input->post('nueva_contrasenia'));
					$data['mensaje'] = $this->module_model->actualizar($this->table, $array, $this->mostrar_session('id')); // Guardar datos
				}
				else
				{
					$data['mensaje'] = $this->lang->line('contrasenias_no_coinciden');;
				}
			}
			else
			{
				$data['mensaje'] = $this->lang->line('contrasenia_incorrecta');
			}

			$data['url'] = NULL;

			if($this->input->post('retorno') == 1)
			{
				$data['url'] = $this->controller; // Verificando que se quiere cerrar el formulario.
			}

			$this->load->view("backend/templates/print_json_view", array('data' => $data));
		}
	}

	function configuracion()
	{
		$this->validar_usuario(); // Verificando la sesión del usuario..

		$items['titulo'] = array('type' => 'text', 'text' => array('espanol' => 'Título', 'english' => 'Title'), 'placeholder' => 'Ingrese el título de la empresa', 'validate' => 'required');
		$items['logo'] = array('type' => 'photo', 'text' => array('espanol' => 'Logo (200x80 píxeles)'), 'sizes' => array(), 'original' => TRUE);
		$items['keywords'] = array('type' => 'textarea', 'text' => array('espanol' => 'Palabras Claves', 'english' => 'Keywords'), 'placeholder' => 'Ingrese las palabras claves de su empresa');
		$items['description'] = array('type' => 'textarea', 'text' => array('espanol' => 'Descripción', 'english' => 'Description'), 'placeholder' => 'Ingrese la descripción de su empresa');
		$items['email_contacto'] = array('type' => 'text', 'text' => array('espanol' => 'Correo Electrónico', 'english' => 'Email'), 'placeholder' => 'Ingrese el correo corporativo de su empresa');
		$items['posicionamiento_seguimiento'] = array('type' => 'label', 'text' => array('espanol' => 'Posicionamiento y Seguimiento'));
		$items['google_analytics'] = array('type' => 'textarea', 'text' => array('espanol' => 'Código de Seguimiento - Google Analytics'));

		$items['redes_sociales'] = array('type' => 'label', 'text' => array('espanol' => 'Redes Sociales'));
		$items['facebook'] = array('type' => 'text', 'text' => array('espanol' => 'Facebook'));
		$items['twitter'] = array('type' => 'text', 'text' => array('espanol' => 'Twitter'));
		$items['instagram'] = array('type' => 'text', 'text' => array('espanol' => 'Instagram'));
		$items['youtube'] = array('type' => 'text', 'text' => array('espanol' => 'YouTube'));

		$config['title'] = array('espanol' => 'Configuración', 'english' => 'Configuration');
		$config['items'] = $items;
		$config['table'] = 'configuracion';
		$config['controller'] = 'configuracion';
		$config['breadcrumb'] = FALSE;

		$buttons = array();
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar Configuración', 'english' => 'Update Configuration'));

		$config['buttons'] = $buttons;

		$this->initialize($config);
		$this->actualizar(1);
	}
}

?>