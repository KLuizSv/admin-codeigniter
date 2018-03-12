<!-- page start-->
<section class="panel">
    <header class="panel-heading">
        <?php echo $title; ?>
    </header>
    <div class="panel-body">
        <?php foreach($items as $key => $value): ?>
            <?php if(isset($value['titulo']) && isset($value['contenido']) && count($value) > 0): ?>
                <h3><?php echo $value['titulo']; ?></h3>
                <?php echo $value['contenido']; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>
<!-- page end-->