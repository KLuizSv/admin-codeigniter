<?php $mes = array('Seleccione un Mes', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'); ?>
<?php $anio_actual = date("Y"); $anio_final = $anio_actual+2; ?>

<br class="clear" />
<input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $values[$key]; ?>" />
<div>
	<select name="dia" class="populate select" id="dia" style="width:48%;">
		<option value="0"<?php if($values['dia'] == '0'): ?> selected="selected"<?php endif; ?>>Seleccione un Día</option>
		<?php for($i=1; $i<=31; $i++):  ?>
			<option value="<?php echo $i; ?>"<?php if($values['dia'] == $i): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>

	<select name="mes" class="populate select" id="mes" style="width:48%;">
		<option value="0"<?php if($values['mes'] == '0'): ?> selected="selected"<?php endif; ?>>Seleccione un Mes</option>
		<?php for($i=1; $i<=12; $i++):  ?>
			<option value="<?php echo $i; ?>"<?php if($values['mes'] == $i): ?> selected="selected"<?php endif; ?>><?php echo $mes[$i]; ?></option>
		<?php endfor; ?>
	</select>

	<?php /* ?>
	<select name="anio" class="populate select" id="anio" style="width:33%;">
		<option value="0"<?php if($values['anio'] == '0'): ?> selected="selected"<?php endif; ?>>Seleccione un Año</option>
		<?php for($i=$anio_actual; $i<=$anio_final; $i++):  ?>
			<option value="<?php echo $i; ?>"<?php if($values['anio'] == $i): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
	<?php */ ?>
</div>