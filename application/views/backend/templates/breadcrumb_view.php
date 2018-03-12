<div class="col-md-12 m-bot15" style="margin:0px;padding:0px;">
    <ul class="breadcrumb">
    	<small>Te encuentras en: </small>
        <?php $miga_pan = MY_Controller::mostrar_session('miga_pan'); ?>
        <?php if(is_array($miga_pan)): ?>
	        <?php foreach($miga_pan as $key => $value): ?>
	        	<?php $metodo = (isset($value['metodo'])) ? $value['metodo'] : 'abrir_miga_pan'; ?>
	        	<li><a href="javascript:;" onclick="javascript:<?php echo $metodo; ?>('<?php echo $value['link']; ?>');"><?php echo $value['texto']; ?></a></li>
	    	<?php endforeach; ?>
	    <?php endif; ?>
    </ul>
</div>