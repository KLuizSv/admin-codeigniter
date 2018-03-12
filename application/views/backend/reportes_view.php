<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                Reportes por Encuestas
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body" id="response" style="padding:15px 0px;">
                <?php if(count($encuesta) > 0): ?>
                    <div class="adv-table">
                        <span class="tools pull-right" style="margin-top:-50px;margin-right:15px;">
                            <button type="button" onclick="javascript:redireccionar('<?php echo backend_url(); ?>dashboard/exportar_estadisticas/<?php echo $encuesta['id'] ?>');" class="btn btn-success btn-xs tooltips" data-container="body" title="Exportar a Excel"><i class="fa fa-cloud-download"></i></button>
                        </span>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="select" style="width:100%;" onchange="javascript:filtrar_encuesta(this);">
                                    <?php foreach($encuestas as $key => $value): ?>
                                        <option value="<?php echo $value['id']; ?>"<?php if($encuesta['id'] == $value['id']): ?> selected="selected"<?php endif; ?>><?php echo $value['titulo']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php if(isset($usuarios) && count($usuarios) > 0): ?>
                            <div class="col-md-12">
                                <table cellpadding="0" cellspacing="0" border="0" class="dynamic-table table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;vertical-align:middle;">Correo Electrónico</th>
                                            <th style="text-align:center;vertical-align:middle;">Nombres</th>
                                            <th style="text-align:center;vertical-align:middle;">Apellidos</th>
                                            <th style="text-align:center;vertical-align:middle;">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cantidad_votaron = 0; $cantidad_no_votaron = 0; ?>
                                        <?php foreach($usuarios as $key => $value): ?>
                                            <?php $votacion = $this->module_model->total('votaciones', array('id_padre' => $value['id'], 'id_encuesta' => $encuesta['id'])); ?>
                                            <tr>
                                                <td><?php echo $value['correo_electronico']; ?></td>
                                                <td><?php echo $value['nombres']; ?></td>
                                                <td><?php echo $value['apellidos']; ?></td>
                                                <td><?php echo ($votacion == 1) ? 'VOTÓ' : 'NO VOTÓ'; ?></td>
                                            </tr>
                                            <?php ($votacion == 1) ? $cantidad_votaron++ : $cantidad_no_votaron++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-9">
                                <strong class="text-center">Preguntas de la Encuesta: <?php echo $encuesta['titulo']; ?></strong>
                                <br /><br />
                                <div class="form-group">
                                    <select class="select" style="width:100%;" onchange="javascript:filtrar_pregunta(this);">
                                        <option value="">Seleccione una Pregunta</option>
                                        <?php foreach($preguntas as $key => $value): ?>
                                            <option value="<?php echo $value['alias']; ?>"><?php echo $value['titulo']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="graph-line"></div>
                            </div>

                            <div class="col-md-3">
                                <strong class="text-center">Observaciones del Gráfico</strong>
                                <div>
                                    Usuarios Totales: <strong><?php echo count($usuarios); ?></strong><br />
                                    Usuarios que votaron: <strong><?php echo $cantidad_votaron; ?></strong><br />
                                    Usuarios que no votaron: <strong><?php echo $cantidad_no_votaron; ?></strong><br />
                                </div>

                                <div>
                                    <br class="clearfix" />
                                    <button type="button" class="btn btn-sm col-xs-12 btn-primary" onclick="javascript:imprimir_fisico('graph-line');"><i class="fa fa-print"></i> Imprimir Gráfico</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <strong class="col-md-12">No hay encuestas para hacer el reporte respectivo.</strong>
                <?php endif; ?>
            </div>

            <?php if(count($encuesta) > 0): ?>
                <script type="text/javascript">
                    var morris = Morris.Line({
                        element: 'graph-line',
                        data: [],
                        xkey: ['x'],
                        ykeys: ['y'],
                        labels: ['Cantidad de Usuarios'],
                        lineColors:['#E67A77'],
                        parseTime: false
                    });

                    function filtrar_pregunta(elemento) {

                        $.ajax({
                            url: '<?php echo current_url(); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: { pregunta: $(elemento).attr('value'), _token: xnToken },
                            success: function(response) {
                                console.log(response);

                                morris.setData(response.cantidad);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                    }

                    function filtrar_encuesta(elemento) {

                        $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

                        $.ajax({
                            url: '<?php echo current_url(); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: { encuesta: $(elemento).attr('value'), _token: xnToken },
                            success: function(response) {
                                $(parent).html(response); docReady();
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                        
                    }
                </script>
            <?php endif; ?>

        </section>
    </div>
</div>