<?php 
defined('C5_EXECUTE') or die(_("Access Denied.")); 
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Content Categories'), false, 'span10 offset1', false);

if ($this->controller->getTask() == 'edit'){
	$action=$this->url('/dashboard/content_scheduler/manage_categories', 'update');
}else{
	$action=$this->url('/dashboard/content_scheduler/manage_categories', 'add');
}
?>	
<div class="ccm-pane-body">

<form method="post" action="<?php echo $action?>" id="content-form">			
<table class="table table-bordered">

    <thead>
        <tr>
			<?php if ($this->controller->getTask() != 'edit') { ?><th><?php   echo t('Edit')?></th><?php }?>
            <th <?php if ($this->controller->getTask() == 'edit') { ?>colspan="3"<?php }?>><?php   echo t('Category')?></th>
            <?php if ($this->controller->getTask() != 'edit') { ?><th><?php   echo t('Delete')?></th><?php }?>
        </tr>
    </thead>


	<?php foreach($cat_values as $cat){?>
        <tr>
           <?php    if ($this->controller->getTask() != 'edit' && $cat['ctID']!=$ctIDedit) { ?>
                <td style="width:20px;text-align:center;">
                   <a href="<?php   echo $this->url('/dashboard/content_scheduler/manage_categories', 'edit', $cat['ctID'])?>" class="btn"><i class="icon-edit"></i></a>
                 </td>
    <?php }?>
				
<?php    if ($this->controller->getTask() == 'edit' && $cat['ctID']==$ctIDedit) { ?>

<td <?php    if ($this->controller->getTask() == 'edit') { ?>colspan="2"<?php }?>> 
<?php  echo $form->text('editcat',  $cat['category'], array('class'=>'span7'))?>
<?php   echo $form->hidden('ctID', $cat['ctID'])?>
</td>
<td>
<div class="btn-group">
<button type="submit" class="btn btn-success"><?php echo t('Save')?> <i class="icon-ok icon-white"></i></button>
<a href="<?php echo $this->url('/dashboard/content_scheduler/manage_categories')?>" class="btn"><?php echo t('Cancel')?></a>
</div>
</td>
<?php }else{?>
<td <?php    if ($this->controller->getTask() == 'edit') { ?>colspan="3"<?php }?>><?php   echo $cat['category']?></td>
<?php }?>
 <?php    if ($this->controller->getTask() != 'edit' && $cat['ctID']!=$ctIDedit) { ?>
                <td width="20px" align="center">
               
                <a href="<?php   echo $this->url('/dashboard/content_scheduler/manage_categories', 'delete_check', $cat['ctID'],$cat['category'])?>" class="btn btn-danger"><i class="icon-remove-circle icon-white"></i></a></a>
                
				</td>
                <?php }?>
			</tr>
	<?php }?>	
<?php    if ($this->controller->getTask() != 'edit'){?>
<thead>
    <tr>
        <th class="subheader" colspan="3">
        <strong><?php   echo t('Add New Category')?></strong>
        </th>
    </tr>
</thead>
            <tr>
            <td colspan="2">
            <?php  echo $form->text('newcat', $newcat, array('style' => 'width: 98%'))?>
            </td>
            <td align="center">

			<input type="image" src="">

            </td>
            </tr>
         <?php } ?>
			</table>
	

	</form>
            

	</div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>