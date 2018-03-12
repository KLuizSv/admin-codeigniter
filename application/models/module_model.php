<?php

class module_model extends CI_Model {

	private $last_id = NULL;

	function __construct()
	{
		parent::__construct();
	}

	function next_result()
	{
		if (is_object($this->conn_id))
		{
			return mysqli_next_result($this->conn_id);
		}
	}

	function last_insert_id()
	{
		return $this->last_id;
	}

	function paginacion($table = NULL, $por_pagina = 0, $segmento = 0, $order_by = array(), $where = array(), $where_or = array(), $or_like = array())
	{
		if(is_array($order_by))
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by($order_by, 'DESC');
		}

		if(is_array($where_or))
		{
			$this->db->or_where($where_or);
		}

		if(is_array($or_like))
		{
			$this->db->or_like($or_like);
		}

		if(is_array($where))
		{
			$this->db->where($where);
		}
		
		$query = $this->db->get($table, $por_pagina, ($segmento * $por_pagina)); $data = array();

		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $fila)
			{
				$data[] = $fila;
			}
		}
		
		return $data;
	}

	function total($table = NULL, $where = array(), $where_or = array(), $like = array())
	{
		if(is_array($where_or))
		{
			foreach($where_or as $k => $v)
			{
				$this->db->or_where($k, $v);
			}
		}

		if(is_array($where))
		{
			foreach($where as $k => $v)
			{
				$this->db->where($k, $v);
			}
		}

		if(is_array($like))
		{
			foreach($like as $k => $v)
			{
				$this->db->or_like($k, $v);
			}
		}

		$query = $this->db->get($table);
        return $query->num_rows();
	}

	function seleccionar($table = NULL, $where = array(), $tipo = 2, $limit = 1000)
	{
		$this->db->order_by($this->item_order['key'], $this->item_order['value']);
		$this->db->where($where);
		$this->db->limit($limit);
		$query = $this->db->get($table);
		return ($tipo == 2) ? $query->result_array() : $query->row_array();
	}

	function buscar_mayor($table = NULL, $where = array())
	{
		$this->db->order_by($this->parent_key, 'DESC');
		$this->db->where($where);
		$query = $this->db->get($table);
		return $query->row_array();
	}

	function buscar_like($table = NULL, $campo = NULL, $like = NULL)
	{
		$this->db->like($campo, $like);
		$query = $this->db->get($table);
		return $query->row_array();
	}

	function buscar($table = NULL, $id = 0)
	{
		$this->db->where($this->parent_key, $id);
		$query = $this->db->get($table);
		return $query->row_array();
	}

	function guardar($table = NULL, $array = array())
	{
		$mensaje = $this->lang->line("error_formulario");

		if(!isset($array[$this->parent_key]))
		{
			$array[$this->parent_key] = time();
		}

		if($this->alias !== FALSE)
		{
			if(isset($array[$this->alias]))
			{
				$array['alias'] = MY_Controller::limpiar_texto($array[$this->alias]);
			}
		}

		// Iniciando Transacción ...
		$this->db->trans_begin();
		
		$this->db->insert($table, $array);

		if ($this->db->trans_status() === FALSE)
		{
    		$this->db->trans_rollback();
    		$mensaje = $this->db->_error_message();
		}
		else
		{
			$this->last_id = $array[$this->parent_key];
    		$this->db->trans_commit();
    		$mensaje = sprintf($this->lang->line("guardar_formulario"), '');

    		$this->db->cache_delete_all();
		}
		// Fin de la Transacción..

		return $mensaje;
	}

	function actualizar($table = NULL, $array = array(), $where = NULL)
	{
		$mensaje = $this->lang->line("error_formulario");

		// Iniciando Transacción..
		$this->db->trans_begin();

		if(is_array($where))
		{
			foreach($where as $key => $value)
			{
				$this->db->where($key, $value);
			}

			$id = $where[$this->parent_key];
		}
		else
		{
			$this->db->where($this->parent_key, $where); $id = $where;
		}

		if($this->alias !== FALSE)
		{
			if(isset($array[$this->alias]))
			{
				$array['alias'] = MY_Controller::limpiar_texto($array[$this->alias]);
			}
		}

		if(isset($array['id_padre']) && $array['id_padre'] == $id)
		{
			unset($array['id_padre']);
		}

		if(isset($array[$this->parent_key]))
		{
			if($array[$this->parent_key] == NULL)
			{
				unset($array[$this->parent_key]);
			}
		}

		$this->db->update($table, $array);

		if ($this->db->trans_status() === FALSE)
		{
    		$this->db->trans_rollback();
    		$mensaje = $this->db->_error_message();
		}
		else
		{
    		$this->db->trans_commit();
    		$mensaje = sprintf($this->lang->line("modificar_formulario"), '');

    		$this->db->cache_delete_all();
		}
		// Fin de la Transacción..

		return $mensaje;
	}

	function eliminar($table = NULL, $where = NULL)
	{
		$mensaje = $this->lang->line("error_formulario");

		// Iniciando Transacción..
		$this->db->trans_begin();

		if(is_array($where))
		{
			foreach($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		else
		{
			$this->db->where($this->parent_key, $where);
		}

		$this->db->delete($table);

		if ($this->db->trans_status() === FALSE)
		{
    		$this->db->trans_rollback();
    		$mensaje = $this->db->_error_message();
		}
		else
		{
    		$this->db->trans_commit();
    		$mensaje = sprintf($this->lang->line("eliminar_formulario"), '');

    		$this->db->cache_delete_all();
		}
		// Fin de la Transacción..

		return $mensaje;
	}

	function procedure($procedure, $where = array(), $tipo = 2)
	{
		$parameters = NULL; $item = 0; $total = count($where) - 1;
		foreach($where as $key => $value)
		{
			if($value != '')
			{
				$parameters .= "'".$value."'";
			}
			else
			{
				$parameters .= "'".NULL."'";
			}
			if($item < $total)
			{
				$parameters .= ', ';
			}
			$item++;
		}

		$query = $this->db->query('CALL '.$procedure.'('.$parameters.')');
		$resultado = ($tipo == 2) ? $query->result_array() : $query->row_array();

		$query->next_result();
		$query->free_result();

        return $resultado;
	}
}

?>