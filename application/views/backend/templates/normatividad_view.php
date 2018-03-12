<div class="right-stat-bar">
    <?php if(isset($normatividad)): ?>
        <ul class="right-side-accordion">
        <?php if(count($normatividad) > 0): ?>
        <?php foreach($normatividad as $key => $value): ?>
        <?php if(count($value) > 0): ?>
            <li class="widget-collapsible">
                <a href="#" class="head widget-head red-bg clearfix">
                    <span class="pull-left"><?php echo $value['titulo']; ?></span>
                    <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                </a>
                <ul class="widget-container">
                    <li>
                        <div style="display:block;padding:10px;font-size:12px !important;color:#FFF !important;font-family:Arial;">
                            <?php echo $value['contenido']; ?>
                        </div>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
            <li class="widget-collapsible">
                <a href="#" class="head widget-head red-bg clearfix">
                    <span class="pull-left">Sin Contenido</span>
                    <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                </a>
                <ul class="widget-container">
                    <li>
                        <div style="display:block;padding:10px;font-size:12px !important;color:#FFF !important;font-family:Arial;">
                            No hay contenido disponible para su visualización.
                        </div>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
        </ul>
    <?php endif; ?>
</div>