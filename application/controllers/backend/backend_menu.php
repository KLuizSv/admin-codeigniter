<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class backend_menu extends MY_Controller {

	function __construct() {
		parent::__construct();

		$items = array(); $buttons = array();

		$config['campo_referencia'] = 'url';

		$config['controller'] = 'backend_menu';
		$config['where'] = array('estado' => 1);
		$config['table'] = 'backend_menu';
		$config['title'] = array('espanol' => 'Listado de Menu');
		$config['order'] = TRUE;
		$config['type'] = 'table';

		// Botones
		$buttons['agregar'] = array('type' => 'add', 'text' => array('espanol' => 'Agregar un Elemento'));
		$buttons['actualizar'] = array('type' => 'update', 'text' => array('espanol' => 'Actualizar un Elemento'));
		$buttons['eliminar'] = array('type' => 'delete', 'text' => array('espanol' => 'Eliminar un Elemento'));
		// Fin de los Botones

		// Elementos
		$items['metodo'] = array('type' => 'text', 'text' => array('espanol' => 'Ingrese un Método'));
		$items['url'] = array('type' => 'text', 'text' => array('espanol' => 'Ingrese una URL del Elemento'), 'table' => TRUE, 'required' => TRUE);
		$items['icono'] = array('type' => 'group_radio', 'text' => array('espanol' => 'Icono Predeterminado del Elemento'), 'items' => $this->mostrar_iconos());
		$items['grupo'] = array('type' => 'text', 'text' => array('espanol' => 'Nombre del Grupo'), 'table' => TRUE, 'required' => TRUE);

		// Fin de los Elementos

		$config['buttons'] = $buttons;
		$config['items'] = $items;

		$this->initialize($config);
	}
}