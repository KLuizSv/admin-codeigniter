<option value="">Seleccione una opci&oacute;n</option>
<?php foreach($values as $k => $v): ?>
<option value="<?php echo $v[$id]; ?>"><?php echo $v[$valor]; ?></option>
<?php endforeach; ?>