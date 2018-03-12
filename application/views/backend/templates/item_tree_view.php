<?php $update = FALSE; $delete = FALSE; ?>

<?php if(isset($buttons) && count($buttons) > 0): ?>
	<?php foreach($buttons as $key => $button): ?>
	    <?php if($button['type'] == 'update' && $readonly === FALSE): ?>
	    <?php $update = TRUE; ?>
	    <?php endif; ?>
	    <?php if($button['type'] == 'delete' && $readonly === FALSE): ?>
	    <?php $delete = TRUE; ?>
	    <?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php if(count($response) > 0): ?>
	<ol class="dd-list">
		<?php foreach($response as $key => $value): ?>
			<?php if(isset($value['id_padre'])): ?>
				<li class="dd-item dd3-item dd-collapsed" data-id="<?php echo $value['id']; ?>" data-orden="<?php echo $value['orden']; ?>" data-id-padre="<?php echo $value['id_padre']; ?>">
			<?php else: ?>
				<li class="dd-item dd3-item dd-collapsed" data-id="<?php echo $value['id']; ?>" data-orden="<?php echo $value['orden']; ?>">
			<?php endif; ?>
				<div class="dd-handle dd3-handle"></div>
				<div class="dd3-content tooltips"<?php if(isset($publish) && $publish === TRUE && $update === TRUE && $value['activado'] == 1): ?> style="background-color:#FCF8E3 !important;border-color:#FAEBCC !important;"<?php endif; ?> title="<?php echo $value['titulo']; ?>">
				<?php if(isset($value['tipo'])): ?>
					<?php

						$type = NULL; $type_title = NULL;

						switch($value['tipo'])
						{
							case 0:
							{
								$type = 'archive'; $type_title = 'MiniWeb';
							}; break;
							case 1:
							{
								$type = 'file'; $type_title = 'Texto';
							}; break;
							case 2:
							{
								$type = 'link'; $type_title = 'Enlace Directo';
							};break;
							case 3:
							{
								$type = 'cloud-download'; $type_title = 'Descarga Directa';
							};break;
							case 4:
							{
								$type = 'folder-open'; $type_title = 'Repositorios';
							};break;
							default:
							{
								$type = 'share'; $type_title = 'Listado';
							}
						}

					?>
					<i class="fa fa-<?php echo $type; ?> tooltips" title="<?php echo $type_title; ?>"></i><?php endif; ?> <?php echo substr($value['titulo'], 0, 100); ?><?php echo (count($value['titulo']) > 100) ? '...' : NULL; ?>
				</div>
				<div class="display:block;position:absolute;right:0;top:0;">
					<button type="button" onclick="javascript:visualizar('<?php echo $controller; ?>', '<?php echo $value[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $this->lang->line('boton_visualizar'); ?>" rel="tooltip"><i class="fa fa-search"></i></button>
                    <?php if((!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$value[$parent_key]]))) && isset($publish) && $publish === TRUE && $update === TRUE): ?>
                    <?php

                        $titulo = ($value['activado'] == 1) ? $this->lang->line('boton_despublicar') : $this->lang->line('boton_publicar');
                        $thumbs = ($value['activado'] == 1) ? 'down' : 'up';
                        $valor = ($value['activado'] == 1) ? '0' : '1';

                    ?>
                        <button type="button" onclick="javascript:publicar('<?php echo $controller; ?>', '<?php echo $value[$parent_key]; ?>', '<?php echo $valor; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $titulo; ?>" rel="tooltip">
                            <i class="fa fa-thumbs-o-<?php echo $thumbs; ?>"></i>
                        </button>
                    <?php endif; ?>
					<?php if((!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$value[$parent_key]]))) && $update === TRUE && ((isset($buttons) && count($buttons) > 0) || $publish === TRUE)): ?>
                        <?php foreach($buttons as $key => $button): ?>
                            <?php if($button['type'] === 'update'): ?>
                                <button type="button" onclick="javascript:actualizar('<?php echo $controller; ?>', '<?php echo $value[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            <?php endif; ?>
                            <?php if($button['type'] === 'delete'): ?>
                                <button type="button" onclick="javascript:eliminar('<?php echo $controller; ?>', '<?php echo $value[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            <?php endif; ?>
                            <?php if($button['type'] === 'javascript'): ?>
                                <button type="button" onclick="javascript:<?php echo $button['function']; ?>('<?php echo $value[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
                                    <i class="fa fa-<?php echo $button['icon']; ?>"></i>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; ?>
					<?php endif; ?>

					<?php if((!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$value[$parent_key]]))) && $update === TRUE): ?>
						<?php foreach($actions as $k => $v): ?>
						<?php $thumbs = ($value[$k] == 1) ? 'down' : 'up'; $valor = ($value[$k] == 1) ? '0' : '1'; $titulo = $v; ?>
						<button type="button" onclick="javascript:action_update('<?php echo $controller; ?>', '<?php echo $k; ?>', '<?php echo $value[$parent_key]; ?>', '<?php echo $valor; ?>');" class="btn btn-white btn-sm">
                            <i class="fa fa-thumbs-o-<?php echo $thumbs; ?>"></i> <?php echo $titulo; ?>
                        </button>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php $config['item_order'] = array('key' => 'id', 'value' => 'asc'); MY_Controller::initialize($config); ?>
					<?php $usuario_modificacion = $this->module_model->seleccionar('administrador', array('id' => $value['usuario_modificacion'], 'estado' => 1), 1, 1); ?>
                	<?php if(count($usuario_modificacion) > 0): ?>
                    	<span style="font-size:10px;">Usuario de Modificación: <strong><?php echo $usuario_modificacion['nombres'].' '.$usuario_modificacion['apellidos']; ?></strong> | Fecha de Modificación: <strong><?php echo MY_Controller::fecha_muestra($value['fecha_modificacion']); ?></strong></span>
                    <?php else: ?>
                    	<span style="font-size:10px;">No ha sido modificado.</span>
                    <?php endif; ?>
				</div>
				<?php if(isset($value['id_padre']) && ($value['tipo'] == 0)): // Validando que sea una Miniweb.. ?>
					<?php echo MY_Controller::mostrar_item_tree($value['id']); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>