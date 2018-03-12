<?php $this->load->view("backend/templates/header_view"); ?>

<section class="row">
	<div class="col-md-12">
		<?php if(MY_Controller::mostrar_session('nivel') == 0 || MY_Controller::mostrar_session('nivel') == 1): ?>
			<section class="panel">
		        <header class="panel-heading">
		            <i class="fa fa-clock-o"></i> Últimos Movimientos en la Plataforma
		            <span class="tools pull-right">
		                <a href="javascript:;" class="fa fa-chevron-down"></a>
		            </span>
		        </header>
		        <div class="panel-body">
		        	<!-- div class="alert alert-warning">	
		                <span class="alert-icon"><i class="fa fa-bell-o"></i></span>
		                <div class="notification-info">
		                    <ul class="clearfix notification-meta" style="padding-left:0px !important;">
		                        <li class="pull-left notification-sender"><?php echo $this->lang->line('informacion_adicional'); ?></li>
		                    </ul>
		                    <p>
		                        La información aquí mostrada es de caracter técnico para futuras auditorías.<br /><small>Máximo 7 registros.</small>
		                    </p>
		                </div>
		            </div -->

		            <div class="col-xs-12">
                        <div class="row">
                            <form class="form-inline" style="margin-bottom:15px;" action="<?php echo current_url(); ?>" role="form" method="GET">
                            	<div class="form-group">
	                                <label class="sr-only" for="usuario">Usuario</label>
	                                <select name="usuario" class="form-control" id="usuario">
	                                	<option value="">Cualquier Usuario</option>
	                                	<?php foreach($usuarios as $key => $value): ?>
	                                		<option value="<?php echo $key; ?>"<?php echo ($key == @$_GET['usuario']) ? ' selected="selected"' : ''; ?>><?php echo $value['nombres']; ?> <?php echo $value['apellidos']; ?></option>
	                                	<?php endforeach; ?>
	                                </select>
	                            </div>
	                            <div class="form-group">
	                                <label class="sr-only" for="fecha_inicio">Fecha de Inicio</label>
	                                <input class="form-control default-date-picker" id="fecha_inicio" name="fecha_inicio" value="<?php echo (isset($_GET['fecha_inicio'])) ? $_GET['fecha_inicio'] : ''; ?>" type="text" readonly="readonly" />
	                            </div>
	                            <div class="form-group">
	                                <label class="sr-only" for="fecha_fin">Fecha de Fin</label>
	                                <input class="form-control default-date-picker" id="fecha_fin" name="fecha_fin" value="<?php echo (isset($_GET['fecha_fin'])) ? $_GET['fecha_fin'] : ''; ?>" type="fecha_fin" readonly="readonly" />
	                            </div>
	                            <button type="submit" class="btn btn-success">Filtrar Resultados</button>
	                        </form>
                        </div>
                    </div>
		        
			        <table class="table table-bordered table-striped">
			            <thead>
			            <tr>
			                <th>Fecha</th>
			                <th>Petición</th>
			                <th>IP</th>
			                <th>Usuario</th>
			                <th>Ruta</th>
			            </tr>
			            </thead>
			            <tbody>
			            	<?php if(count($logs) > 0): ?>
								<?php foreach($logs as $key => $value): ?>
								<?php if(strpos(current_url(), 'undefined') != TRUE): ?>
								<tr>
									<td style="text-align:center;vertical-align:middle;"><?php echo MY_Controller::fecha_hora_muestra($value['fecha']); ?></td>
									<td style="text-align:center;vertical-align:middle;"><?php echo $value['accion']; ?></td>
									<td style="text-align:center;vertical-align:middle;"><?php echo $value['ip']; ?></td>
									<td style="text-align:center;vertical-align:middle;"><img class="tooltips" title="<?php echo $usuarios[$value['usuario']]['nombres']; ?> <?php echo $usuarios[$value['usuario']]['apellidos']; ?>" src="<?php echo base_url(); ?>uploads/33x33/<?php echo $usuarios[$value['usuario']]['imagen']; ?>" alt="Usuario" /></td>
									<td style="text-align:center;vertical-align:middle;"><?php echo str_replace(array(backend_url()), array(''), $value['ruta']); ?></td>
								</tr>
								<?php endif; ?>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="5" scope="row">No hay información para mostrar. <strong><small>(*) No se guarda información de visitantes.</small></strong></td>
								</tr>
							<?php endif; ?>
			            </tbody>
			        </table>

			        <?php $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0; ?>
	            	<ul class="pagination">
		                <?php $primero = $pagina - 4; $ultimo = $pagina + 7; if($primero < 1){ $primero = 1; } if($ultimo > $links){ $ultimo = $links; } ?>

		                <?php if($pagina > 0 && $pagina <= $links): ?>
		                    <li><a href="<?php echo backend_url(); ?>?<?php if(isset($_GET['usuario'])): ?>usuario=<?php echo $_GET['usuario']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_inicio'])): ?>fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_fin'])): ?>fecha_fin=<?php echo $_GET['fecha_fin']; ?>&<?php endif; ?>pagina=<?php echo ($pagina - 1); ?>">Anterior</a></li>
		                <?php endif; ?>

		            	<?php for($i=$primero;$i<=$ultimo;$i++): ?>
		                	<li<?php if(($pagina + 1) == $i): ?> class="active"<?php endif; ?>><a href="<?php echo backend_url(); ?>?<?php if(isset($_GET['usuario'])): ?>usuario=<?php echo $_GET['usuario']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_inicio'])): ?>fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_fin'])): ?>fecha_fin=<?php echo $_GET['fecha_fin']; ?>&<?php endif; ?>pagina=<?php echo ($i - 1); ?>"><?php echo $i; ?></a></li>
		                <?php endfor; ?>

		                <?php if($pagina < $links && $links > 1): ?>
		                    <li><a href="<?php echo backend_url(); ?>?<?php if(isset($_GET['usuario'])): ?>usuario=<?php echo $_GET['usuario']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_inicio'])): ?>fecha_inicio=<?php echo $_GET['fecha_inicio']; ?>&<?php endif; ?><?php if(isset($_GET['fecha_fin'])): ?>fecha_fin=<?php echo $_GET['fecha_fin']; ?>&<?php endif; ?>pagina=<?php echo ($pagina + 1); ?>">Siguiente</a></li>
		                <?php endif; ?>
					</ul>
			    </div>
			</section>
		<?php else: ?>
			
		<?php endif; ?>
	</div>
</section>

<script type="text/javascript">

	$(document).ready(function(){
		$('.default-date-picker').datepicker({
	        format: 'dd-mm-yyyy'
	    });
	});
	setInterval(function() {
		// Generación del Tiempo..

		var f=new Date();
		var hora = f.getHours(); var minuto = f.getMinutes(); var segundo = f.getSeconds();
		
		if(hora < 10)
		{
			hora = '0'+hora.toString();
		}

		if(minuto < 10)
		{
			minuto = '0'+minuto.toString();
		}

		if(segundo < 10)
		{
			segundo = '0'+segundo.toString();
		}

		$('.time').html(hora+":"+minuto+":"+segundo);

	}, 1000);
</script>
<?php $this->load->view("backend/templates/footer_view"); ?>