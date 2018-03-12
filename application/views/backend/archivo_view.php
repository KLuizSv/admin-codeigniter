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
		<option value="0"<?php if($values[$key] == '0'): ?> selected="selected"<?php endif; ?>>Archivo</option>
		<option value="1"<?php if($values[$key] == '1'): ?> selected="selected"<?php endif; ?>>Enlace</option>
	</select>
</div>

<div<?php if($values[$key] == '0'): ?> style="display:block;"<?php else: ?> style="display:none;"<?php endif; ?>>
	<div style="margin-top:10px;">
		<div class="fileupload fileupload-new" data-provides="fileupload">
            <span class="btn btn-white btn-file">
                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Seleccionar Archivo</span>
                <span class="fileupload-exists"><i class="fa fa-undo"></i> Cambiar</span>
                <input<?php echo $readonly; ?> type="file" class="default<?php echo $class; ?>" id="_<?php echo $key; ?>_archivo" name="<?php echo $key; ?>_archivo" />
            </span>
            <?php if($value != NULL): ?>
                <?php if($readonly == FALSE): ?>
                    <span class="btn btn-danger" onclick="javascript:remover(this, '<?php echo $table; ?>', '<?php echo $key; ?>_archivo', '<?php echo $values[$this->parent_key]; ?>');">
                        <span><i class="fa fa-times"></i> Remover</span>
                    </span>
                <?php endif; ?>

                <a class="btn btn-primary" href="https://drive.google.com/viewerng/viewer?url=<?php echo base_url(); ?>uploads/<?php echo $value; ?>" target="_blank">
                    <span><i class="fa fa-file"></i> Visualizar</span>
                </span>
            <?php endif; ?>
            <span class="fileupload-preview" style="margin-left:5px;"></span>
            <a href="javascript:;" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
        </div>
	</div>
</div>

<div<?php if($values[$key] == '1'): ?> style="display:block;"<?php else: ?> style="display:none;"<?php endif; ?>>
	<div style="margin-top:10px;">
		<input class="form-control" type="text" name="<?php echo $key; ?>_enlace" id="_<?php echo $key; ?>_enlace" value="<?php echo $values[$key.'_enlace']; ?>" />
	</div>
</div>

<script type="text/javascript">
	function toggle_url(elemento)
	{
		var url = $(elemento).val(); var key = "<?php echo $key; ?>";

		if(url == 0)
		{
			$('#_'+key+'_archivo').parents('.fileupload').parent().css('display', 'block'); $('#_'+key+'_enlace').parent().parent().css('display', 'none');
		}
		else
		{
			$('#_'+key+'_archivo').parents('.fileupload').parent().css('display', 'none'); $('#_'+key+'_enlace').parent().parent().css('display', 'block');
		}
	}
</script>