<div id="section_<?php echo $this->controller; ?>">

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
                <?php echo MY_Controller::mostrar_item_tree(); ?>
            </div>
        </div>
    </div>
</div>

</div>