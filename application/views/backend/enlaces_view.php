<?php
	// Items..
	$items = $data['items'];

	/*
	$items[] = array('alias' => 'convocatorias', 'titulo' => 'Convocatorias', 'tipo' => 1, 'tipo_padre' => 0, 'id' => NULL);
	$items[] = array('alias' => 'fotos', 'titulo' => 'Fotos', 'tipo' => 1, 'tipo_padre' => 0, 'id' => NULL);
	$items[] = array('alias' => 'videos', 'titulo' => 'Videos', 'tipo' => 1, 'tipo_padre' => 0, 'id' => NULL);
	$items[] = array('alias' => 'libro_reclamaciones', 'titulo' => 'Libro de Reclamaciones', 'tipo' => 1, 'tipo_padre' => 0, 'id' => NULL);
	$items[] = array('alias' => 'noticias', 'titulo' => 'Noticias', 'tipo' => 1, 'tipo_padre' => 0, 'id' => NULL);
	*/
	// Fin de los Items..
?>

<br class="clear" />
<div>
	<select name="<?php echo $key; ?>" class="populate select" id="<?php echo $key; ?>" style="width:100%;" onchange="javascript:toggle_url(this);">
		<option value="0"<?php if($values[$key] == '0'): ?> selected="selected"<?php endif; ?>>Url Externo</option>
		<?php foreach($items as $k => $value):  ?>
				<?php if($value['tipo_padre'] == 0): ?>
					<?php $tipo_padre = ''; ?>
				<?php endif; ?>

				<?php if($value['tipo_padre'] == 1): ?>
					<?php $tipo_padre = 'institucional/'; ?>
				<?php endif; ?>

				<?php if($value['tipo_padre'] == 2): ?>
					<?php $tipo_padre = 'servicios/'; ?>
				<?php endif; ?>

				<?php if($value['tipo_padre'] == 3): ?>
					<?php $tipo_padre = 'sistema_nacional_de_archivos/'; ?>
				<?php endif; ?>

				<?php if($value['tipo_padre'] == 4): ?>
					<?php $tipo_padre = 'nuestros_aliados/'; ?>
				<?php endif; ?>

				<?php if(isset($value['id_padre']) && $value['id_padre'] != 0): ?>
					<?php $padre = $this->module_model->seleccionar('institucional', array('id' => $value['id_padre'], 'estado' => 1, 'activado' => 1), 1, 1); ?>
				<?php endif; ?>
				<?php $valor = $tipo_padre.$value['id'].'-'.$value['alias']; ?>
				<?php if($value['tipo_padre'] == 0 || isset($padre)): ?>
					<option value="<?php echo $valor; ?>"<?php if($values[$key] == $valor): ?> selected="selected"<?php endif; ?>><?php echo $value['titulo']; ?><?php echo (isset($padre) && isset($padre['titulo'])) ? ' - <strong>' . $padre['titulo'] . '</strong>' : NULL; ?></option>
				<?php endif; ?>
		<?php endforeach; ?>
	</select>
</div>

<div<?php if($values[$key] == '0'): ?> style="display:block;"<?php else: ?> style="display:none;"<?php endif; ?>>
	<div style="margin-top:10px;">
		<input class="form-control" type="text" name="<?php echo $key; ?>_alternativo" id="<?php echo $key; ?>_alternativo" value="<?php echo $values[$key.'_alternativo']; ?>" />
	</div>
</div>

<script type="text/javascript">
	function toggle_url(elemento)
	{
		var url = $(elemento).val(); var key = "<?php echo $key; ?>";

		if(url == 0)
		{
			$('#'+key+'_alternativo').parent().parent().css('display', 'block');
		}
		else
		{
			$('#'+key+'_alternativo').parent().parent().css('display', 'none');
		}
	}
</script>