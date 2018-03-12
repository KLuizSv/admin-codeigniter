<div id="section_<?php echo $controller; ?>">
<?php if(isset($help) && $help <> NULL): ?>
<div class="alert alert-warning fade in">
    <button type="button" data-dismiss="alert" class="close close-sm">
        <i class="fa fa-times"></i>
    </button>
    <strong><?php echo $this->lang->line('titulo_ayuda'); ?></strong><br><br>
    <?php echo nl2br($help); ?>
</div>
<?php endif; ?>

<?php if(!isset($breadcrumb) || $breadcrumb === TRUE): ?>
    <?php $this->load->view("backend/templates/breadcrumb_view"); ?>
<?php endif; ?>

<?php $update = FALSE; $delete = FALSE; ?>

<div class="row">
    <div class="col-md-12">
        <?php if(count($items) > 0): ?>
        <section class="panel">
            <header class="panel-heading">
                <strong><?php echo $title; ?></strong>
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body">
            <?php if(isset($buttons) && count($buttons) > 0): ?>
                <?php foreach($buttons as $key => $button): ?>
                    <?php if($button['type'] == 'update' && $readonly === FALSE): ?>
                    <?php $update = TRUE; ?>
                    <?php endif; ?>
                    <?php if($button['type'] == 'delete' && $readonly === FALSE): ?>
                    <?php $delete = TRUE; ?>
                    <?php endif; ?>
                    <?php if(($button['type'] == 'add' || $button['type'] == 'top_javascript' || $button['type'] == 'top_link') && $readonly === FALSE): ?>
                        <?php if($button['type'] == 'add'): ?>
                        <button type="button" onclick="javascript:agregar('<?php echo $controller; ?>');" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                        </button>
                        <?php endif; ?>

                        <?php if($button['type'] == 'top_javascript'): ?>
                        <button type="button" onclick="javascript:<?php echo $button['function']; ?>();" class="btn btn-white btn-sm">
                            <i class="fa fa-<?php echo $button['icon']; ?>"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                        </button>
                        <?php endif; ?>

                        <?php if($button['type'] == 'top_link'): ?>
                        <button type="button" onclick="javascript:;" class="btn btn-white btn-sm">
                            <i class="fa fa-<?php echo $button['icon']; ?>"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                        </button>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if($import !== FALSE || $export !== FALSE): ?>
                <div class="pull-right">
                    <?php if($import !== FALSE): ?>
                        <form class="pull-right" action="<?php echo backend_url(); ?><?php echo $controller; ?>/import" target="oculto" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="controller" value="<?php echo $controller; ?>" />
                            <input type="file" name="file_import_<?php echo $controller; ?>" id="file_import_<?php echo $controller; ?>" onchange="javascript:importar_registros(this);" style="display:none;">
                            <label for="file_import_<?php echo $controller; ?>" class="btn btn-sm btn-info tooltips" data-container="body" title="Desde archivo excel"><i class="fa fa-upload"></i> Importar registros</label>
                        </form>
                    <?php endif; ?>
                    <?php if($export !== FALSE): ?>
                        <form class="pull-right" action="<?php echo backend_url(); ?><?php echo $controller; ?>/export" target="oculto" method="POST" enctype="multipart/form-data">
                            <label class="btn btn-sm btn-info tooltips" data-container="body" title="Desde archivo excel" onclick="javascript:exportar_registros(this);"><i class="fa fa-upload"></i> Exportar registros</label>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="adv-table">
            <form class="form_masivo" action="<?php echo backend_url(); ?><?php echo $controller; ?>" method="POST" target="oculto">
                <input type="hidden" name="token" value="<?php echo MY_Controller::mostrar_session('token'); ?>">
                <table cellpadding="0" cellspacing="0" border="0" class="dynamic-table table table-bordered table-striped">
                <thead>
                <tr>
                    <?php $cantidad = 0; ?>
                    <th nowrap style="text-align:center;vertical-align:middle;"><input type="checkbox" id="all" /></th>
                    <th class="sorting_<?php echo strtolower($item_order['value']); ?>" style="display:none;">Orden Inicial</th>
                    <?php if(isset($order) && $order == TRUE && $update === TRUE): ?>
                    	<th nowrap class="no-sort" style="text-align:center;vertical-align:middle;width:150px;">
                            <button type="button" class="btn btn-xs btn-info btn-masivo tooltips" data-title="<?php echo $this->lang->line('cabecera_orden'); ?>" value="ordenar"><i class="fa fa-refresh"></i></button>
                        </th>
                    	<?php $cantidad++; ?>
                	<?php endif; ?>
                    <?php foreach($items as $key => $value): ?>
                        <?php if(isset($value['table']) && $value['table'] === TRUE): ?>
                            <th style="text-align:left;vertical-align:middle;"><?php echo $value['text'][$this->config->item('language')]; ?></th>
                            <?php $cantidad++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <th style="text-align:left;vertical-align:middle;"><?php echo $this->lang->line('cabecera_estado'); ?></th>
                    <th style="text-align:left;vertical-align:middle;"><?php echo $this->lang->line('cabecera_acciones'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($results as $key => $result): ?>
                <tr>
                    <td nowrap style="text-align:center;vertical-align:middle;"><input type="checkbox" class="item" name="item[]" id="item_<?php echo $result[$parent_key]; ?>" value="<?php echo $result[$parent_key]; ?>" /></td>
                    <td nowrap style="text-align:center;vertical-align:middle;display:none;"><?php echo $result[$item_order['key']]; ?></td>
                    <?php if(isset($order) && $order == TRUE && $update === TRUE): ?>
                    	<td nowrap style="text-align:center;vertical-align:middle;width:150px;">
                            <?php if(!isset($result[$show_order['key']]) || (isset($result[$show_order['key']]) && $result[$show_order['key']] == $show_order['value'])): ?>
                                <div class="spinner" style="width:122px;margin:0px auto;">
                                    <div class="input-group" style="width:122px;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="spinner-input form-control" name="orden[<?php echo $result[$parent_key]; ?>]" value="<?php echo $result['orden']; ?>" />
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                    	</td>
                	<?php endif; ?>
                    <?php foreach($items as $k => $v): ?>
                        <?php if(isset($v['table']) && $v['table'] === TRUE): ?>

                            <?php if($v['type'] == 'date'): ?>
                                <?php $value = date("d-m-Y", strtotime($result[$k])); ?>
                            <?php else: ?>
                                <?php $value = $result[$k]; ?>
                            <?php endif; ?>

	                        <?php if(isset($v['elementos']) && $result[$k] == '0'): ?>
	                    		<?php $value = ''; ?>
	                    		<?php foreach($v['elementos'] as $a => $b): ?>
	                    			<?php $value .= $result[$b]; ?>
	                    			<?php if(count($v['elementos']) > ($a + 1)): ?>/<?php endif; ?>
	                    		<?php endforeach; ?>
	                    	<?php endif; ?>

                            <?php $value = str_replace(base_url(), '/', $value); ?>

	                        <td style="max-width:400px;vertical-align:middle;">
	                            <?php if($v['type'] == 'select'): ?>
	                                <?php foreach($v['items'] as $k_item => $v_item): ?>
	                                    <?php if(is_array($v_item)): ?>
	                                        <?php if($v_item[$v['value']['key']] == $value): // siempre y cuando esto sea verdad ?>
	                                            <?php $campo = explode('|', $v['value']['item']); $muestra = NULL; ?>
	                                            <?php if(is_array($campo) && count($campo) > 0): ?>
	                                            <?php foreach($campo as $kc => $vc): ?>
	                                                <?php $muestra .= $v_item[$vc]; ?>
	                                                <?php $muestra .= ($kc < (count($campo) - 1)) ? ' | ' : NULL; ?>
	                                            <?php endforeach; ?>
	                                            <?php endif; ?>
	                                            <?php echo $muestra; ?>
	                                        <?php endif; ?>
	                                    <?php else: ?>
	                                        <?php if($k_item == $value): // siempre y cuando esto sea verdad ?>
	                                            <?php echo $v_item; ?>
	                                        <?php endif; ?>
	                                    <?php endif; ?>
	                                <?php endforeach; ?>
	                            <?php elseif($v['type'] == 'multiple_select'): ?>
	                                <?php foreach($v['items'] as $k_item => $v_item): ?>
	                                    <?php $x = explode("-", $value); ?>
	                                    <?php if(is_array($v_item)): ?>
	                                        <?php foreach($x as $k_x => $v_x): ?>
	                                            <?php if($v_item[$v['value']['key']] == $v_x): // siempre y cuando esto sea verdad ?>
	                                                <?php echo ' <span class="label label-inverse"><i class="fa fa-check"></i> '.$v_item[$v['value']['item']].'</span> '; ?>
	                                            <?php endif; ?>
	                                        <?php endforeach; ?>
	                                    <?php else: ?>
	                                        <?php foreach($x as $k_x => $v_x): ?>
	                                            <?php if($k_item == $v_x): // siempre y cuando esto sea verdad ?>
	                                                <?php echo ' <span class="label label-inverse"><i class="fa fa-check"></i> '.$v_item.'</span> '; ?>
	                                            <?php endif; ?>
	                                        <?php endforeach; ?>
	                                    <?php endif; ?>
	                                <?php endforeach; ?>
	                            <?php elseif($v['type'] == 'checkbox'): ?>
	                                <?php echo ($value == 1) ? 'Si' : 'No'; ?>
	                            <?php elseif($v['type'] == 'date'): ?>
	                                <?php echo $value; ?>
	                            <?php elseif($v['type'] == 'photo'): ?>
                                    <?php if($value != ''): ?>
                                        <center>
                                        <?php if(isset($v['original']) && $v['original'] === TRUE): ?>
                                            <img src="<?php echo base_url(); ?>uploads/<?php echo $value; ?>" style="max-width:150px;max-height:150px;" />
                                        <?php else: ?>
    	                                   <img src="<?php echo base_url(); ?>uploads/100x100/<?php echo $value; ?>" style="max-width:150px;max-height:150px;" />
                                        <?php endif; ?>
                                        </center>
                                    <?php endif; ?>
	                            <?php else: ?>
	                                <?php echo $value; ?>
	                            <?php endif; ?>
	                        </td>

                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php

                        $estado = '<span class="label label-success">'.$this->lang->line('estado_publicado').'</span>';

                        if(isset($status) && is_array($status) && count($status) > 0)
                        {
                            $exit = 0;
                            $ca = $status['campo']; // Obtenemos el campo..
                            $it = $status['items']; // Obtenemos todos los items..
                            $co = $status['colors']; // Obtenemos todos los colores..

                            foreach($it as $k => $v)
                            {
                                if($result[$ca] == $k)
                                {
                                    $estado = '<span class="label label-'.$co[$k].'">'.$v.'</span>';
                                    break;
                                }
                            }
                        }
                        else
                        {
                            if(isset($result['activado']))
                            {
                                if($result['activado'] == 1)
                                {
                                    $estado = '<span class="label label-inverse">'.$this->lang->line('estado_publicado').'</span>';
                                }
                                else
                                {
                                    $estado = '<span class="label label-danger">'.$this->lang->line('estado_despublicado').'</span>'; 
                                }
                            }
                        }
                    ?>

                    <td nowrap style="text-align:center;vertical-align:middle;"><?php echo $estado; ?></td>
                        <td nowrap style="text-align:center;vertical-align:middle;">
                        	<div class="">
	                            <button type="button" onclick="javascript:visualizar('<?php echo $controller; ?>', '<?php echo $result[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $this->lang->line('boton_visualizar'); ?>" rel="tooltip">
	                                <i class="fa fa-search"></i>
	                            </button>

	                            <?php if(isset($publish) && $publish === TRUE && $update === TRUE && (!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$result[$parent_key]])))): ?>
	                            <?php

	                                $titulo = ($result['activado'] == 1) ? $this->lang->line('boton_despublicar') : $this->lang->line('boton_publicar');
	                                $thumbs = ($result['activado'] == 1) ? 'down' : 'up';
	                                $valor = ($result['activado'] == 1) ? '0' : '1';

	                            ?>
	                                <button type="button" onclick="javascript:publicar('<?php echo $controller; ?>', '<?php echo $result[$parent_key]; ?>', '<?php echo $valor; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $titulo; ?>" rel="tooltip">
	                                    <i class="fa fa-thumbs-o-<?php echo $thumbs; ?>"></i>
	                                </button>
	                            <?php endif; ?>
		                        <?php if((!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$result[$parent_key]]))) && $update === TRUE &&((isset($buttons) && count($buttons) > 0) || $publish === TRUE)): ?>
			                        <?php foreach($buttons as $key => $button): ?>
			                            <?php if($button['type'] === 'update'): ?>
			                                <button type="button" onclick="javascript:actualizar('<?php echo $controller; ?>', '<?php echo $result[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
			                                    <i class="fa fa-pencil"></i>
			                                </button>
			                            <?php endif; ?>
			                            <?php if($button['type'] === 'delete'): ?>
			                                <button type="button" onclick="javascript:eliminar('<?php echo $controller; ?>', '<?php echo $result[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
			                                    <i class="fa fa-trash-o"></i>
			                                </button>
			                            <?php endif; ?>
			                            <?php if($button['type'] === 'javascript'): ?>
			                                <button type="button" onclick="javascript:<?php echo $button['function']; ?>('<?php echo $result[$parent_key]; ?>');" class="btn btn-white btn-sm tooltips" title="<?php echo $button['text'][$this->config->item('language')]; ?>" rel="tooltip">
			                                    <i class="fa fa-<?php echo $button['icon']; ?>"></i>
			                                </button>
			                            <?php endif; ?>
			                        <?php endforeach; ?>
		                        <?php endif; ?>
                                <?php if((!isset($items_unlocked) || (isset($items_unlocked) && isset($items_unlocked[$result[$parent_key]]))) && $update === TRUE): ?>
                                    <?php foreach($actions as $k => $v): ?>
                                    <?php $thumbs = ($result[$k] == 1) ? 'down' : 'up'; $valor = ($result[$k] == 1) ? '0' : '1'; $titulo = $v; ?>
                                    <button type="button" onclick="javascript:action_update('<?php echo $controller; ?>', '<?php echo $k; ?>', '<?php echo $result[$parent_key]; ?>', '<?php echo $valor; ?>');" class="btn btn-white btn-sm">
                                        <i class="fa fa-thumbs-o-<?php echo $thumbs; ?>"></i> <?php echo $titulo; ?>
                                    </button>
                                    <?php endforeach; ?>
                                <?php endif; ?>
		                    </div>
		                    <div class="">
		                    	<?php $usuario_modificacion = $this->module_model->buscar('administrador', $result['usuario_modificacion']); ?>
		                    	<?php if(count($usuario_modificacion) > 0): ?>
			                    	<span style="font-size:10px;">Usuario de Modificación: <strong><?php echo $usuario_modificacion['nombres'].' '.$usuario_modificacion['apellidos']; ?></strong><br />
			                    	Fecha de Modificación: <strong><?php echo MY_Controller::fecha_muestra($result['fecha_modificacion']); ?></strong></span>
			                    <?php else: ?>
			                    	<span style="font-size:10px;">No ha sido modificado.</span>
			                    <?php endif; ?>
		                    </div>
                        </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?php echo ($cantidad + 3); ?>" scope="row">
                            <?php if($update === TRUE || $delete === TRUE): ?>
                                <strong style="margin-bottom:10px;"><?php echo $this->lang->line('elementos_marcados'); ?>: </strong> <?php if(isset($publish) && $publish === TRUE && $update === TRUE): ?><button type="button" value="despublicar" class="btn btn-info btn-xs btn-masivo"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->lang->line('boton_despublicar'); ?></button> <button type="button" value="publicar" class="btn btn-info btn-xs btn-masivo"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->lang->line('boton_publicar'); ?></button><?php endif; ?> <?php if($delete === TRUE): ?><button type="button" value="eliminar" class="btn btn-info btn-xs btn-masivo"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('boton_eliminar'); ?></button><?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tfoot>
                </table>
            </form>

            <?php if(isset($paginate) && $paginate !== FALSE): ?>
                <?php $limite = $paginate; ?>
                <div class="text-center">
                    <ul class="pagination">
                        <?php if($page > 1): ?>
                            <li><a href="javascript:;" onclick="javascript:paginar('<?php echo $controller; ?>?page=<?php echo $page; ?>', this);">«</a></li>
                        <?php endif; ?>
                        <?php if($links <= $limite): ?>
                            <?php for($i=0;$i<$links;$i++): ?>
                                <li <?php echo ($page == $i) ? 'class="active"' : ''; ?>><a href="javascript:;" onclick="javascript:paginar('<?php echo $controller; ?>?page=<?php echo ($i + 1); ?>', this);"><?php echo ($i + 1); ?></a></li>
                            <?php endfor; ?>
                        <?php else: ?>
                            <?php if($page >= ($limite - 1)): ?>
                                <?php $mitad = ceil($limite / 2); $mitad += (($links - $page) < $limite) ? ceil(($links - $page) / $mitad) : 0; ?>
                                <?php for($i=($page - $mitad);$i<($page + $mitad + 1);$i++): ?>
                                    <?php if($i < $links): ?>
                                        <li <?php echo ($page == $i) ? 'class="active"' : ''; ?>><a href="javascript:;" onclick="javascript:paginar('<?php echo $controller; ?>?page=<?php echo ($i + 1); ?>', this);"><?php echo ($i + 1); ?></a></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            <?php else: ?>
                                <?php for($i=0;$i<$limite;$i++): ?>
                                    <li <?php echo ($page == $i) ? 'class="active"' : ''; ?>><a href="javascript:;" onclick="javascript:paginar('<?php echo $controller; ?>?page=<?php echo ($i + 1); ?>', this);"><?php echo ($i + 1); ?></a></li>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($page < ($links - 1)): ?>
                            <li><a href="javascript:;" onclick="javascript:paginar('<?php echo $controller; ?>?page=<?php echo ($page + 2); ?>', this);">»</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
            </div>
            </div>
        </section>
        <!-- page end-->
        <?php endif; ?>
    </div>
</div>

<style type="text/css">
    .dataTables_info { display:none !important; }
</style>

</div>