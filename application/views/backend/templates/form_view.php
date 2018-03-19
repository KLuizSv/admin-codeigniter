<?php if(isset($valor_retorno) && $valor_retorno == 1): ?>
<div class="alert alert-info fade in">
    <button data-dismiss="alert" class="close close-sm" type="button">
        <i class="fa fa-times"></i>
    </button>
    <strong><?php echo $this->lang->line('titulo_ayuda'); ?></strong><br><br>
    <?php echo $this->lang->line('primera_linea_ayuda'); ?><br>
    <?php echo $this->lang->line('segunda_linea_ayuda'); ?>
</div>
<?php endif; ?>

<?php if(isset($help) && $help <> NULL): ?>
<div class="alert alert-warning fade in">
    <button data-dismiss="alert" class="close close-sm" type="button">
        <i class="fa fa-times"></i>
    </button>
    <strong><?php echo $this->lang->line('informacion_adicional'); ?></strong><br><br>
    <?php echo nl2br($help); ?>
</div>
<?php endif; ?>

<?php if(!isset($breadcrumb) || $breadcrumb === TRUE): ?>
    <?php $this->load->view("backend/templates/breadcrumb_view"); ?>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <?php if(count($items) > 0): ?>
        <?php if($readonly == FALSE): ?>
        <form role="form" method="post" action="<?php echo current_url(); ?>" autocomplete="off" target="oculto" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?php echo MY_Controller::mostrar_session('token'); ?>" />
        <input type="hidden" name="valor_retorno" value="<?php echo $valor_retorno; ?>" />
        <input type="hidden" name="parent" id="parent" value="" />
        <?php endif; ?>
        <section class="panel">
            <header class="panel-heading">
                <strong><?php echo $title; ?></strong>
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body">
            <div class="adv-table">
                    <span class="tools pull-right" style="margin-top:-50px;">
                        <?php if(isset($valor_retorno) && $valor_retorno == 1): ?>
                            <?php if(isset($values[$parent_key]) && $values[$parent_key] != NULL): ?>
                                <button type="button" onclick="javascript:visualizar('<?php echo $controller; ?>', '<?php echo $values[$parent_key]; ?>');" class="btn btn-info btn-xs tooltips" data-title="<?php echo $this->lang->line('boton_visualizar'); ?>" data-placement="bottom"><i class="fa fa-search"></i></button>
                            <?php endif; ?>
                            <?php if($readonly == FALSE): ?>
                                <?php foreach($buttons as $key => $button): ?>
                                    <?php if($button['type'] === 'update'): ?>
                                        <button type="submit" class="btn btn-primary sin_retorno btn-xs tooltips" data-placement="bottom" data-title="<?php echo $this->lang->line('boton_grabar'); ?>"><i class="fa fa-save"></i></button>
                                        <button type="submit" class="btn btn-success con_retorno btn-xs tooltips" data-placement="bottom" data-title="<?php echo $this->lang->line('boton_grabar_continuar'); ?>"><i class="fa fa-save"></i></button>
                                    <?php endif; ?>
                                    <?php if($button['type'] === 'javascript' && isset($values[$parent_key]) && $values[$parent_key] != NULL): ?>
                                        <button onclick="javascript:<?php echo $button['function']; ?>('<?php echo $values[$parent_key]; ?>');" class="btn btn-white btn-xs tooltips" data-title="<?php echo $button['text'][$this->config->item('language')]; ?>" data-placement="bottom">
                                            <i class="fa fa-<?php echo $button['icono']; ?>"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <button type="button" class="btn btn-danger btn-xs tooltips" onclick="regresar(this);" data-title="<?php echo $this->lang->line('boton_regresar'); ?>" data-placement="bottom"><i class="fa fa-level-up"></i></button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary sin_retorno btn-xs tooltips" data-title="<?php echo $this->lang->line('boton_grabar'); ?>" data-placement="bottom"><i class="fa fa-save"></i></button>
                        <?php endif; ?>
                    </span>
                    <input type="hidden" id="retorno" name="retorno" value="" />
                    <?php $cantidad_items = 0; ?>
                    <?php foreach($items as $key => $item): ?>
                        <?php if($item['type'] == 'label'): ?>
                            <?php if(isset($valor_retorno) && $valor_retorno == 1): ?>
                                <?php if(isset($values[$parent_key]) && $values[$parent_key] <> NULL): ?>
                                    <button type="button" onclick="javascript:visualizar('<?php echo $controller; ?>', '<?php echo $values[$parent_key]; ?>');" class="btn btn-info btn-sm"><i class="fa fa-search"></i> <?php echo $this->lang->line('boton_visualizar'); ?></button>
                                <?php endif; ?>
                                <?php if($solo_lectura == FALSE): ?>
                                    <?php foreach($buttons as $button): ?>
                                        <?php if($button['type'] === 'update'): ?>
                                            <button type="submit" class="btn btn-primary sin_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar'); ?></button>
                                            <button type="submit" class="btn btn-success con_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar_continuar'); ?></button>
                                        <?php endif; ?>
                                        <?php if($button['type'] === 'javascript' && isset($values[$parent_key]) && $values[$parent_key] != NULL): ?>
                                            <button onclick="javascript:<?php echo $button['metodo']; ?>('<?php echo $controller; ?>', '<?php echo $values[$parent_key]; ?>');" class="btn btn-white btn-sm">
                                                <i class="fa <?php echo $button['icono']; ?>"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                                            </button>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <button type="button" class="btn btn-danger btn-sm" onclick="regresar(this);"><i class="fa fa-level-up"></i> <?php echo $this->lang->line('boton_regresar'); ?></button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary sin_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar'); ?></button>
                            <?php endif; ?>
                        </div>
                        </div>
                        </section>
                        <section class="panel" id="heading_<?php echo $key; ?>">
                            <?php $help = (isset($item['help'])) ? ' popovers" data-original-title="Más Información" data-content="'.$item['help'].'" data-placement="bottom" data-trigger="click' : NULL; ?>
                            <header class="panel-heading">
                                <strong><?php echo $item['text'][$this->config->item('language')]; ?></strong> <?php echo (isset($item['help'])) ? ' <span class="badge bg-info'.$help.'"> ? </span>' : NULL; ?>
                            </header>
                            <div class="panel-body">
                            <div class="adv-table">
                        <?php endif; ?>
                        <?php if($item['type'] == 'hidden' && $item['value'] != NULL): ?>
                        <input type="hidden" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $item['value']; ?>" />
                        <?php endif; ?>
                        <?php if($item['type'] !== 'hidden' && $item['type'] !== 'label'): ?>
                        <?php $texto = $item['text'][$this->config->item('language')]; ?>
                        <?php

                            $help = (isset($item['help'])) ? TRUE : FALSE;

                            $class = NULL;
                            if(isset($item['class']))
                            {
                                $class = ' '.$item['class'];
                                if($item['class'] == 'hidden')
                                {
                                    $class .= ' oculto';
                                }

                                if($item['class'] == 'visible')
                                {
                                    $class .= ' visible';
                                }
                            }
                        ?>
                        <div class="form-group<?php echo $class; ?>">
                            <?php $type = $item['type']; ?>

                            <?php if($type !== 'hidden'): ?>
                            	<label class="<?php echo $class; ?>" for="<?php echo $key; ?>"><?php echo $texto; ?></label><?php echo ($help === TRUE) ? ' <a href="#_help_' . $key . '" class="badge bg-info"> ? </a>' : NULL; ?><?php echo (isset($item['validate'])) ? ' <span class="badge bg-important"> * </span>' : NULL; ?> <?php if(isset($item['button_add']) && $item['button_add'] == TRUE && (!isset($item['readonly']) || $item['readonly'] !== TRUE)): ?><a class="btn btn-info btn-xs tooltips" data-toggle="modal" data-backdrop="static" href="#modal" style="margin-left:10px;" data-title="<?php echo $this->lang->line('agregar_registro_select'); ?>" onclick="javascript:agregar_modal('<?php echo $key; ?>', '<?php echo $item['value']['table']; ?>', '<?php echo $item['value']['key']; ?>', '<?php echo $item['value']['item']; ?>');"><i class="fa fa-plus"></i></a><?php endif; ?>
                            <?php endif; ?>
                            <?php

                                $value = (isset($item['default']) && $item['default'] <> NULL) ? htmlspecialchars($item['default']) : NULL;

                                if(isset($values) && isset($values[$key]))
                                {
                                    if($type != 'editor')
                                    {
                                        $value = htmlspecialchars($values[$key]);   
                                    }
                                    else
                                    {
                                        $value = $values[$key];
                                    }
                                }

                                $solo_lectura = NULL;

                                if(isset($item['readonly']) && $item['readonly'] == TRUE)
                                {
                                    $solo_lectura = ' onclick="javascript:blur();"';
                                    if($type == 'select' || $type == 'multiple_select' || $type == 'date')
                                    {
                                        $solo_lectura .= ' disabled="disabled"';
                                    }
                                    else
                                    {
                                        $solo_lectura .= ' readonly="readonly" style="cursor:default;"';
                                    }
                                }

                            ?>

                            <?php if($type === 'text'): ?>
                                <input type="text"<?php echo $solo_lectura; ?> class="form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                            <?php endif; ?>
                            <?php if($type === 'youtube'): ?>
                                <input type="text"<?php echo $solo_lectura; ?> class="form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>"<?php if($value != '' && $value != NULL): ?> value="http://www.youtube.com/watch?v=<?php echo $value; ?>"<?php endif; ?> />
                            <?php if($value != '' && $value != NULL): ?>
                                <iframe src="http://www.youtube.com/embed/<?php echo $value; ?>" style="border:0px;width:450px;height:320px;"></iframe>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php if($type === 'google_maps'): ?>
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-xs-9">
                                        <input type="text"<?php echo $solo_lectura; ?> class="form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"<?php if(isset($item['placeholder'])): ?> placeholder="<?php echo $item['placeholder']; ?>"<?php endif; ?> />
                                    </div>
                                    <input type="hidden" name="<?php echo $key; ?>_latitud" id="<?php echo $key; ?>_latitud" required<?php if(isset($values[$key.'_latitud']) && $values[$key.'_latitud'] != ''): ?> value="<?php echo $values[$key.'_latitud']; ?>"<?php endif; ?> /> <input type="hidden" name="<?php echo $key ?>_longitud" id="<?php echo $key; ?>_longitud" required<?php if(isset($values[$key.'_longitud']) && $values[$key.'_longitud'] != ''): ?> value="<?php echo $values[$key.'_longitud']; ?>"<?php endif; ?> />
                                    <br />
                                </div>
                                <div>
                                    <div id="map_canvas" style="width:75%;height:300px;"></div>
                                </div>

                                <script type="text/javascript">
                                    //Declaramos las variables que vamos a user

                                    var key = "<?php echo $key; ?>";
                                    var lat = "<?php echo (isset($values[$key.'_latitud'])) ? $values[$key.'_latitud'] : ''; ?>";
                                    var lng = "<?php echo (isset($values[$key.'_longitud'])) ? $values[$key.'_longitud'] : ''; ?>";
                                    <?php // $datos = MY_Controller::iploc($_SERVER['REMOTE_ADDR']); ?>
                                    //var pais = "<?php echo ''; //(isset($datos->countryName)) ? ', ' . $datos->countryName : ', '; ?>";
                                    var map = null;
                                    var geocoder = null;
                                    var marker = null;
                                             
                                    $(document).ready(function(){
                                        //obtenemos los valores en caso de tenerlos en un formulario ya guardado en la base de datos
                                        lat = $('#'+key+'_latitud').val();
                                        lng = $('#'+key+'_longitud').val();
                                        //Asignamos al evento click del boton la funcion codeAddress
                                        $('#buscar_mapa').click(function(){
                                            codeAddress();
                                            return false;
                                        });

                                        $('#'+key).keypress(function(event) {
                                            if ( event.which == 13 ) {                                                
                                                codeAddress();
                                                return false;
                                            }
                                        });

                                        //Inicializamos la función de google maps una vez el DOM este cargado
                                        initialize();
                                    });
                                         
                                        function initialize() {
                                         
                                          geocoder = new google.maps.Geocoder();
                                            
                                           //Si hay valores creamos un objeto Latlng
                                           if(lat !='' && lng != '')
                                          {
                                             var latLng = new google.maps.LatLng(lat,lng);
                                          }
                                          else
                                          {
                                             var latLng = new google.maps.LatLng(37.6735925,-1.6968357);
                                          }
                                          //Definimos algunas opciones del mapa a crear
                                           var myOptions = {
                                              center: latLng,//centro del mapa
                                              zoom: 15,//zoom del mapa
                                              mapTypeId: google.maps.MapTypeId.ROADMAP //tipo de mapa, carretera, híbrido,etc
                                            };
                                            //creamos el mapa con las opciones anteriores y le pasamos el elemento div
                                            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                                             
                                            //creamos el marcador en el mapa
                                            marker = new google.maps.Marker({
                                                map: map,//el mapa creado en el paso anterior
                                                position: latLng,//objeto con latitud y longitud
                                                draggable: true //que el marcador se pueda arrastrar
                                            });
                                            
                                           //función que actualiza los input del formulario con las nuevas latitudes
                                           //Estos campos suelen ser hidden
                                            updatePosition(latLng);
                                             
                                             
                                        }
                                         
                                        //funcion que traduce la direccion en coordenadas
                                        function codeAddress() {
                                             
                                            //obtengo la direccion del formulario
                                            var address = document.getElementById(key).value;
                                            console.log(address);
                                            //hago la llamada al geodecoder
                                            geocoder.geocode( { 'address': address}, function(results, status) {
                                             
                                            //si el estado de la llamado es OK
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                //centro el mapa en las coordenadas obtenidas
                                                map.setCenter(results[0].geometry.location);
                                                //coloco el marcador en dichas coordenadas
                                                marker.setPosition(results[0].geometry.location);
                                                //actualizo el formulario      
                                                updatePosition(results[0].geometry.location);
                                                 
                                                //Añado un listener para cuando el markador se termine de arrastrar
                                                //actualize el formulario con las nuevas coordenadas
                                                google.maps.event.addListener(marker, 'dragend', function(){
                                                    updatePosition(marker.getPosition());
                                                });
                                          } else {
                                              //si no es OK devuelvo error
                                              jAlert("No podemos ubicar la Dirección", "Ubicación Equivocada");
                                          }
                                        });
                                      }
                                       
                                      //funcion que simplemente actualiza los campos del formulario
                                      function updatePosition(latLng)
                                      {
                                            $('#'+key+'_latitud').val(latLng.lat());
                                            $('#'+key+'_longitud').val(latLng.lng());
                                      }
                                </script>
                            <?php endif; ?>
                            <?php if($type === 'number'): ?>
                                <div class="spinner">
                                    <div class="input-group" style="width:150px;">
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-up btn-primary">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="text"<?php echo $solo_lectura; ?> class="spinner-input form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>"/>
                                        <div class="spinner-buttons input-group-btn">
                                            <button type="button" class="btn spinner-down btn-warning">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($type === 'date'): ?>
                                <?php $value = ($value != NULL && $value != '') ? date("d-m-Y", strtotime($value)) : date("d-m-Y"); ?>
                                <input type="text"<?php echo $solo_lectura; ?> class="default-date-picker form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                            <?php endif; ?>
                            <?php if($type === 'color'): ?>
                                <input type="text"<?php echo $solo_lectura; ?> class="colorpicker-rgba form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" data-color-format="rgba" value="<?php echo $value; ?>" />
                            <?php endif; ?>
                            <?php if($type === 'time'): ?>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text"<?php echo $solo_lectura; ?> class="form-control timepicker-24<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if($type === 'password'): ?>
                                <input type="password"<?php echo $solo_lectura; ?> class="form-control<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" />
                            <?php endif; ?>
                            <?php if($type == 'textarea'): ?>
                                <textarea<?php echo $solo_lectura; ?> class="form-control autogrow<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>"><?php echo $value; ?></textarea>
                            <?php endif; ?>
                            <?php if($type == 'editor'): ?>
                            <?php
                                $oFCKeditor = new FCKeditor($key);
                                $oFCKeditor->BasePath = backend_view()."fckeditor/";
                                if(isset($value) && $value <> NULL)
                                {
                                    $oFCKeditor->Value = $value;
                                }
                                $oFCKeditor->Width = '100%';
                                $oFCKeditor->Height = '400px';

                                echo $oFCKeditor->Create();
                            ?>
                            <?php endif; ?>
                            <?php if($type == 'font-awesome'): ?>

                            <?php endif; ?>
                            <?php if($type == 'select'): ?>
                            <?php $is_array = TRUE; ?>
                            <br class="clear" />
                            <div>
                                <select<?php echo $solo_lectura; ?> name="<?php echo $key; ?>" id="<?php echo $key; ?>" style="width:100%" class="populate select<?php echo $class; ?>"<?php echo (isset($item['function']) && isset($item['function']['event']) && isset($item['function']['children'])) ? ' onchange="javascript:change_select(\''.$item['function']['event'].'\',\''.$controller.'\', this, \''.$item['function']['children'].'\');"' : NULL; ?>>
                                <option value="">Seleccione una opci&oacute;n</option>
                                    <?php if(is_array($item['items']) && count($item['items']) > 0): ?>
                                    <?php $is_array = FALSE; ?>
                                    <?php foreach($item['items'] as $k => $v): ?>
                                        <?php if(is_array($v) && count($v) > 0): ?>
                                            <?php $is_array = TRUE; ?>
                                            <?php $campo = explode('|', $item['value']['item']); $muestra = NULL; ?>
                                            <?php foreach($campo as $kc => $vc): ?>
                                                <?php $muestra .= $v[$vc]; ?>
                                                <?php $muestra .= ($kc < (count($campo) - 1)) ? ' | ' : NULL; ?>
                                            <?php endforeach; ?>
                                            <option<?php echo ($value == $v[$item['value']['key']]) ? ' selected="selected"' : NULL; ?> value="<?php echo $v[$item['value']['key']]; ?>"><?php echo $muestra; ?></option>
                                        <?php else: ?>
                                            <option<?php echo ($value == $k) ? ' selected="selected"' : NULL; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <?php endif; ?>
                            <?php if($type == 'multiple_select'): ?>
                            <div>
                                <select<?php echo $solo_lectura; ?> multiple name="<?php echo $key ?>[]" id="<?php echo $key; ?>" style="width:100%" class="populate select<?php echo $class; ?>"<?php echo (isset($item['function'])) ? ' onchange="javascript:'.$item['function'].'(\''.$controller.'\', this);"' : NULL; ?>>
                                    <?php $explode = explode("-", $value); ?>
                                    <?php $selected = array(); ?>
                                    <?php foreach($explode as $k_explode => $v_explode): ?>
                                        <?php $selected[$v_explode] = $v_explode; ?>
                                    <?php endforeach; ?>

                                    <?php foreach($item['items'] as $k => $v): ?>
                                        <?php if(is_array($v)): ?>
                                            <option<?php echo (isset($selected[$v[$item['value']['key']]]) && $selected[$v[$item['value']['key']]] == $v[$item['value']['key']]) ? ' selected="selected"' : NULL; ?> value="<?php echo $v[$item['value']['key']]; ?>"><?php echo $v[$item['value']['item']]; ?></option>
                                        <?php else: ?>
                                            <option<?php echo (isset($selected[$k])) ? ' selected="selected"' : NULL; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endif; ?>

                            <?php if($type == 'checkbox'): ?>
                            <?php $checked = ($value == 1) ? ' checked="checked"' : NULL; ?>
                            <div class="square single-row">
                                <div class="checkbox" style="margin:0px !important;padding:0px !important;">
                                    <input<?php echo $solo_lectura; ?> type="checkbox" id="<?php echo $key; ?>"<?php echo $checked; ?> name="<?php echo $key; ?>" class="<?php echo $class; ?>"<?php echo (isset($item['function'])) ? ' onchange="javascript:'.$item['function'].'(\''.$controller.'\', this);"' : NULL; ?>>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($type == 'group_checkbox'): ?>
                            <div>
                                <?php $explode = explode("-", $value); ?>
                                <?php $selected = array(); ?>
                                <?php foreach($explode as $k_explode => $v_explode): ?>
                                    <?php $selected[$v_explode] = $v_explode; ?>
                                <?php endforeach; ?>

                                <div class="square single-row">
                                <?php foreach($item['items'] as $k => $v): ?>
                                <?php $checked = (isset($selected[$k])) ? ' checked="checked"' : NULL; ?>
                                <label class="checkbox-inline" style="margin:0px !important;padding:0px !important;">
                                    <input<?php echo $solo_lectura; ?> type="checkbox" id="<?php echo $k; ?>"<?php echo $checked; ?> name="<?php echo $key; ?>[]" value="<?php echo $k; ?>" class="<?php echo $class; ?>"<?php echo (isset($item['function'])) ? ' onchange="javascript:'.$item['function'].'(\''.$controller.'\', this);"' : NULL; ?>> <?php echo $v; ?>
                                </label>
                                <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($type == 'radio'): ?>
                            <?php $checked = ($value == 1) ? ' checked="checked"' : NULL; ?>
                            <div class="square single-row">
                                <div class="radio" style="margin:0px !important;padding:0px !important;">
                                    <input<?php echo $solo_lectura; ?> type="radio" id="<?php echo $key; ?>"<?php echo $checked; ?> name="<?php echo $key; ?>" class="<?php echo $class; ?>"<?php echo (isset($item['function'])) ? ' onchange="javascript:'.$item['function'].'(\''.$controller.'\', this);"' : NULL; ?>>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($type == 'group_radio'): ?>
                            <style type="text/css"> .checkbox-inline .iradio_square { float:left;margin-right:10px; } </style>
                            <div>
                                <div class="square single-row">
                                <?php foreach($item['items'] as $k => $v): ?>
                                <?php $checked = ($value == $k) ? ' checked="checked"' : NULL; ?>
                                <label class="checkbox-inline" style="padding:5px !important;margin:0px !important;">
                                    <input<?php echo $solo_lectura; ?> type="radio" id="<?php echo $key; ?>"<?php echo $checked; ?> name="<?php echo $key; ?>" value="<?php echo $k; ?>" class="<?php echo $class; ?>"<?php echo (isset($item['function'])) ? ' onchange="javascript:'.$item['function'].'(\''.$controller.'\', this);"' : NULL; ?>><?php echo $v; ?>
                                </label>
                                <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($type == 'photo'): ?>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <?php if($value != NULL): ?>
                                    <div class="fileupload-new thumbnail">
                                        <img style="max-width:100px;max-height:100px;" src="<?php echo base_url(); ?>uploads<?php if(!isset($item['original']) || $item['original'] != TRUE): ?>/100x100<?php endif; ?>/<?php echo $value; ?>" alt="<?php echo $value; ?>" />
                                    </div>
                                    <?php endif; ?>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width:100px;max-height:100px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paperclip"></i> Seleccionar Imagen</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Cambiar Imagen</span>
                                            <input<?php echo $solo_lectura; ?> type="file" class="default<?php echo $class; ?>" name="<?php echo $key; ?>" />
                                        </span>
                                        <?php if($value != NULL && $solo_lectura == FALSE): ?>
                                            <span class="btn btn-danger" onclick="javascript:remover(this, '<?php echo $table; ?>', '<?php echo $key; ?>', '<?php echo $values[$this->parent_key]; ?>');">
                                                <span><i class="fa fa-times"></i> Remover</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($type == 'file'): ?>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Seleccionar Archivo</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Cambiar</span>
                                        <input<?php echo $solo_lectura; ?> type="file" class="default<?php echo $class; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>" />
                                    </span>
                                    <?php if($value != NULL): ?>
                                        <?php if($solo_lectura == FALSE): ?>
                                            <span class="btn btn-danger" onclick="javascript:remover(this, '<?php echo $table; ?>', '<?php echo $key; ?>', '<?php echo $values[$this->parent_key]; ?>');">
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
                            <?php endif; ?>

                            <?php if($type == 'widget'): ?>
                                <?php $new_values = isset($values) ? $values : array($key => '0'); ?>
                                <?php if(!isset($values)): ?>
                                    <?php foreach($item['elementos'] as $k => $value): ?>
                                        <?php $new_values[$value] = ''; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach($item['elementos'] as $k => $value): ?>
                                        <?php $new_values[$value] = $values[$value]; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php $this->load->view("backend/".$item['html'], array('data' => $item, 'key' => $key, 'values' => $new_values)); ?>
                            <?php endif; ?>

                            <?php if($help === TRUE): ?>
                                <p id="_help_<?php echo $key; ?>" class="help-block"><span class="badge bg-info"> ? </span> <strong>Ayuda:</strong> <?php echo $item['help']; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php if(isset($valor_retorno) && $valor_retorno == 1): ?>
                    <?php if(isset($values[$parent_key]) && $values[$parent_key] <> NULL): ?>
                        <button type="button" onclick="javascript:visualizar('<?php echo $controller; ?>', '<?php echo $values[$parent_key]; ?>');" class="btn btn-info btn-sm"><i class="fa fa-search"></i> <?php echo $this->lang->line('boton_visualizar'); ?></button>
                    <?php endif; ?>
                    <?php if($readonly == FALSE): ?>
                        <?php foreach($buttons as $button): ?>
                            <?php if($button['type'] === 'update'): ?>
                                <button type="submit" class="btn btn-primary sin_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar'); ?></button>
                                <button type="submit" class="btn btn-success con_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar_continuar'); ?></button>
                            <?php endif; ?>
                            <?php if($button['type'] === 'javascript' && isset($values[$parent_key]) && $values[$parent_key] != NULL): ?>
                                <button onclick="javascript:<?php echo $button['metodo']; ?>('<?php echo $controller; ?>', '<?php echo $values[$parent_key]; ?>');" class="btn btn-white btn-sm">
                                    <i class="fa <?php echo $button['icono']; ?>"></i> <?php echo $button['text'][$this->config->item('language')]; ?>
                                </button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <button type="button" class="btn btn-danger btn-sm" onclick="regresar(this);"><i class="fa fa-level-up"></i> <?php echo $this->lang->line('boton_regresar'); ?></button>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary sin_retorno btn-sm"><i class="fa fa-save"></i> <?php echo $this->lang->line('boton_grabar'); ?></button>
                <?php endif; ?>
            </div>
        </div>
        </section>
        <?php if($readonly == FALSE): ?>
        </form>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding:0px;"></div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-danger btn-sm" type="button" id="close_modal"> Cerrar Formulario </button>
            </div>
        </div>
    </div>
</div>