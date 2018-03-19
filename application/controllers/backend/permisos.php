<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permisos extends MY_Controller {

	function __construct() {
		parent::__construct();

		$items = array(); $buttons = array();

		$config['campo_referencia'] = 'controlador';

		$config['controller'] = 'permisos';
		$config['where'] = array('estado' => 1);
		$config['table'] = 'permisos';
		$config['title'] = array('espanol' => 'Listado de Permisos');
		$config['type'] = 'table';

		// Botones
		$buttons['agregar'] = array('type' => 'add', 'text' => array('espanol' => 'Agregar un Permiso'));
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar un Permiso'));
		$buttons['eliminar'] = array('type' => 'delete', 'text' => array('espanol' => 'Eliminar un Permiso'));
		// Fin de los Botones

		// Elementos
		$elementos = $this->module_model->seleccionar('backend_menu', array('estado' => 1));

		$items['controlador'] = array('type' => 'select', 'text' => array('espanol' => 'Seleccione el Item de Permiso'), 'items' => $elementos, 'value' => array('key' => 'url', 'item' => 'url', 'table' => 'backend_menu'), 'validate' => 'required', 'table' => TRUE, 'function' => array('event' => 'cargar_datos', 'children' => 'items'));
		$items['items'] = array('type' => 'multiple_select', 'text' => array('espanol' => 'Seleccione el Sub Item de Permiso'), 'items' => array(), 'help' => 'Si no se selecciona un registro en específico, se asumirá como todo el ítem.', 'value' => array('key' => 'id', 'item' => 'titulo'));
		$items['acciones'] = array('type' => 'multiple_select', 'text' => array('espanol' => 'Seleccione las Acciones Permitidas'), 'items' => array('add' => 'Agregar nuevos registros', 'update' => 'Actualizar registros existentes', 'delete' => 'Eliminar registros existentes', 'all' => 'Todas las acciones', 'view' => 'Sólo ver'), 'table' => TRUE, 'validate' => 'required');

		// Fin de los Elementos

		$config['buttons'] = $buttons;
		$config['items'] = $items;

		$this->initialize($config);
	}

}