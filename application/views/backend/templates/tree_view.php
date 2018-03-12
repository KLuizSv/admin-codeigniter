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
        <div class="panel">
            <div class="panel-heading">
                <strong><?php echo $title; ?></strong>
				<span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </div>

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
				
            	<div class="dd<?php if($update === TRUE && !isset($items_unlocked)): ?> nestable<?php endif; ?>">
                	<?php echo MY_Controller::mostrar_item_tree(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>