<?php if(isset($help) && $help <> NULL): ?>
<div class="alert alert-warning fade in">
    <button type="button" data-dismiss="alert" class="close close-sm">
        <i class="fa fa-times"></i>
    </button>
    <strong>Ayuda!</strong><br><br>
    <?php echo nl2br($help); ?>
</div>
<?php endif; ?>

<?php if(!isset($breadcrumb) || $breadcrumb === TRUE): ?>
    <?php $this->load->view("backend/templates/breadcrumb_view"); ?>
<?php endif; ?>

<?php $update = FALSE; $delete = FALSE; ?>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <?php echo $title; ?>
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
                            <?php if($type == 'dropzone'): ?>
                                <button type="button" onclick="javascript:agregar_dropzone('<?php echo $controller; ?>');" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                                </button>
                            <?php else: ?>
                                <button type="button" onclick="javascript:agregar('<?php echo $controller; ?>');" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                                </button>
                            <?php endif; ?>
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

                <?php if($type == 'dropzone'): ?>
                <div id="dropzone" style="display:none;margin-top:10px;">
                    <form action="<?php echo backend_url(); ?><?php echo $controller; ?>/agregar" class="dropzone" method="POST" enctype="multipart/form-data"></form>
                </div>

                <script type="text/javascript">
                $(document).ready(function() {
                    xnDropzone = new Dropzone('.dropzone',
                        {
                            queuecomplete: function() {

                                $.ajax({
                                    url: backend_url+'dashboard/regresar',
                                    type: 'GET',
                                    dataType: 'json',
                                    data: { token: xnToken, parent: url_parent, type: 'url_retorno' },
                                    success: function(data) {

                                        if(data != '' && data != null)
                                        {
                                            imprimir(data);

                                            /*
                                            if(url_parent === 'tab_galeria_departamentos')
                                            {
                                                var xnData = { token : xnToken, parent : url_parent };
                                                $.ajax({
                                                    url: backend_url+data['url'],
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    data: xnData,
                                                    success: function(data) {
                                                        if(data != '' && data != null)
                                                        {
                                                            var galeria = $(data).find('#galeria').parent();
                                                            time = $(galeria).find('#galeria').attr('data-time'); $(galeria).find('#galeria').attr('id', 'galeria_departamentos');

                                                            $('#tab_galeria_departamentos').html(galeria); ready(time);
                                                        }
                                                        else
                                                        {
                                                            window.location.reload();
                                                        }
                                                    },
                                                    error: function ()
                                                    {
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                            else
                                            {
                                                if(url_parent === 'tab_galeria')
                                                {
                                                    data['return'] = 'departamentos';
                                                }

                                                data['parent'] = url_parent; titulo = '¡Éxito!'; imprimir(data, true);
                                            }
                                            */
                                        }
                                        else
                                        {
                                            window.location.href = backend_url;
                                        }
                                    },
                                    error: function() {
                                        window.location.href = backend_url;
                                    }
                                });
                            }
                        });
                })
                        
                </script>
                <?php endif; ?>

                <?php if(count($results) > 0): ?>
                <?php if($order === TRUE): ?>
                    <ul id="gallery" data-controller="<?php echo $controller; ?>" class="<?php if($update === TRUE && $readonly === FALSE && !isset($items_unlocked)): ?>sortable <?php endif; ?>media-gal" style="padding-left:0px !important;">
                <?php else: ?>
                    <ul id="gallery" data-controller="<?php echo $controller; ?>" class="media-gal" style="padding-left:0px !important;">
                <?php endif; ?>
                    <?php $item = 0; ?>
                    <?php foreach($results as $key => $result): ?>
                        <li style="text-align:center;" class="item<?php if($update === TRUE && $readonly === FALSE && (isset($result['titulo']) && $result['titulo'] != '0' && $result['titulo'] != '' && isset($result['fecha']) && $result['fecha'] != '')): ?> col-lg-5<?php endif; ?>" id="<?php echo $result[$this->parent_key]; ?>">
                            <img style="max-height:100px;" src="<?php echo base_url(); ?>uploads/<?php echo $result['imagen']; ?>" alt="<?php echo $result['imagen']; ?>"<?php if($readonly === FALSE && (isset($result['titulo']) && $result['titulo'] != '0' && $result['titulo'] != '' && isset($result['fecha']) && $result['fecha'] != '')): ?> class="col-lg-4 row"<?php endif; ?> />
                            <?php if($readonly === FALSE && (isset($result['titulo']) && $result['titulo'] != '0' && $result['titulo'] != '' && isset($result['fecha']) && $result['fecha'] != '')): ?>
                                <div class="col-lg-8">
                                    <?php if(isset($result['titulo']) && $result['titulo'] != '0' && $result['titulo'] != ''): ?><p>Título: <strong><?php echo $result['titulo']; ?></strong></p><?php endif; ?>
                                    <?php if(isset($result['fecha']) && $result['fecha'] != ''): ?><p>Fecha: <strong><?php echo MY_Controller::fecha_muestra($result['fecha']); ?></strong></p><?php endif; ?>
                                    <?php if($update === TRUE && $readonly === FALSE && ((isset($buttons) && count($buttons) > 0) || $publish === TRUE)): ?> 
                                        <p>
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
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php elseif($update === TRUE && $readonly === FALSE && ((isset($buttons) && count($buttons) > 0) || $publish === TRUE)): ?>
                                <div>
                                    <p><input type="text" data-id="<?php echo $result[$parent_key]; ?>" data-controller="<?php echo $controller; ?>" value="<?php echo ($result['titulo'] != '' && $result['titulo'] != '0') ? $result['titulo'] : ''; ?>" class="form-control input-xs title-gallery" placeholder="Título para la foto" /></p>
                                    <p>
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
                                    </p>
                                </div>
                            <?php endif; ?>
                        </li>
                        <?php if(($item+1) % 2 == 0 && (isset($result['titulo']) && $result['titulo'] != '0' && $result['titulo'] != '' && isset($result['fecha']) && $result['fecha'] != '')): ?><br style="clear:both;" /><?php endif; $item++; ?>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>