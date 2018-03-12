<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usuarios extends MY_Controller {

	function __construct() {
		parent::__construct();

		$items = array(); $buttons = array();

		$config['campo_referencia'] = 'correo_electronico';

		$config['controller'] = 'usuarios';
		
		if($this->mostrar_session('nivel') == 0)
		{
			$config['where'] = array('estado' => 1);
			$items['nivel'] = array('type' => 'select', 'text' => array('espanol' => 'Nivel'), 'items' => array(1 => 'Usuario Administrador', 2 => 'Usuario'), 'required' => TRUE);
		}
		
		if($this->mostrar_session('nivel') == 1 || $this->mostrar_session('nivel') == 2)
		{
			$config['where'] = array('estado' => 1, 'nivel' => 2);
			$items['nivel'] = array('type' => 'hidden', 'value' => 2, 'text' => array('espanol' => 'Nivel'));
		}

		if($this->mostrar_session('nivel') == 3 || $this->mostrar_session('nivel') == 4)
		{
			$config['where'] = array('estado' => 1, 'nivel' => 4);
			$items['nivel'] = array('type' => 'hidden', 'value' => 4, 'text' => array('espanol' => 'Nivel'));
		}

		$config['table'] = 'administrador';
		$config['title'] = array('espanol' => 'Listado de Usuarios');
		$config['type'] = 'table';
		$config['publish'] = TRUE;

		// Botones
		$buttons['agregar'] = array('type' => 'add', 'text' => array('espanol' => 'Agregar un Usuario'));
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar un Usuario'));
		$buttons['eliminar'] = array('type' => 'delete', 'text' => array('espanol' => 'Eliminar un Usuario'));
		// Fin de los Botones

		// Elementos
		$items['correo_electronico'] = array('type' => 'text', 'text' => array('espanol' => 'Correo Electrónico', 'english' => 'Email'), 'placeholder' => 'Ingrese su correo electrónico', 'required' => array('valid_email', 'is_unique'), 'table' => TRUE);
		$items['contrasenia'] = array('type' => 'password', 'text' => array('espanol' => 'Contraseña'), 'required' => TRUE);
		$items['nombres'] = array('type' => 'text', 'text' => array('espanol' => 'Nombres', 'english' => 'Name'), 'placeholder' => 'Ingrese sus nombres', 'required' => TRUE, 'table' => TRUE);
		$items['apellidos'] = array('type' => 'text', 'text' => array('espanol' => 'Apellidos', 'english' => 'Last Name'), 'placeholder' => 'Ingrese sus apellidos', 'required' => TRUE, 'table' => TRUE);
		$items['imagen'] = array('type' => 'photo', 'text' => array('espanol' => 'Imagen', 'english' => 'Photo'), 'sizes' => array('33x33'), 'table' => TRUE);
		// Fin de los Elementos

		$config['buttons'] = $buttons;
		$config['items'] = $items;

		// Permisos
		$items = array(); $buttons = array();

		$permisos['campo_referencia'] = 'controlador';

		$permisos['controller'] = 'permisos';
		$permisos['where'] = array('estado' => 1);
		$permisos['table'] = 'permisos';
		$permisos['title'] = array('espanol' => 'Listado de Permisos');
		$permisos['type'] = 'table';

		// Botones
		$buttons['agregar'] = array('type' => 'add', 'text' => array('espanol' => 'Agregar un Permiso'));
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar un Permiso'));
		$buttons['eliminar'] = array('type' => 'delete', 'text' => array('espanol' => 'Eliminar un Permiso'));
		// Fin de los Botones

		if($this->mostrar_session('nivel') == 1 || $this->mostrar_session('nivel') == 2)
		{
			$elementos = $this->module_model->seleccionar('backend_menu', array('estado' => 1));
		}

		if($this->mostrar_session('nivel') == 3 || $this->mostrar_session('nivel') == 4)
		{
			$elementos = array('transparencia' => 'transparencia');
		}

		if($this->mostrar_session('nivel') == 0)
		{
			$elementos = array_merge($this->module_model->seleccionar('backend_menu', array('estado' => 1)), array('transparencia' => 'transparencia'));
		}

		// Elementos
		$items['controlador'] = array('type' => 'select', 'text' => array('espanol' => 'Seleccione el Item de Permiso'), 'items' => $elementos, 'value' => array('key' => 'url', 'item' => 'url', 'table' => 'backend_menu'), 'required' => TRUE, 'table' => TRUE, 'function' => array('event' => 'cargar_datos', 'children' => 'items'));
		$items['items'] = array('type' => 'multiple_select', 'text' => array('espanol' => 'Seleccione el Sub Item de Permiso'), 'items' => array(), 'help' => 'Si no se selecciona un registro en específico, se asumirá como todo el ítem.', 'value' => array('key' => 'id', 'item' => 'titulo'), 'table' => TRUE);
		$items['acciones'] = array('type' => 'multiple_select', 'text' => array('espanol' => 'Seleccione las Acciones Permitidas'), 'items' => array('add' => 'Agregar nuevos registros', 'update' => 'Actualizar registros existentes', 'delete' => 'Eliminar registros existentes', 'all' => 'Todas las acciones', 'view' => 'Sólo ver'), 'table' => TRUE, 'required' => TRUE);

		// Fin de los Elementos

		$permisos['buttons'] = $buttons;
		$permisos['items'] = $items;
		// Fin de los Permisos

		$config['elementos_adicionales'] = array($permisos);

		$this->initialize($config);
	}
}