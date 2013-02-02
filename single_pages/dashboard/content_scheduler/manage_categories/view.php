
<style>
	.message {width: 740px;}
</style>


<div style="width: 760px;">
		<h1><span><?php   echo t('Content Categories')?></span></h1>
		<div class="ccm-dashboard-inner">
<?php if ($this->controller->getTask() == 'edit'){
	$action=$this->url('/dashboard/content_scheduler/manage_categories', 'update');
}else{
	$action=$this->url('/dashboard/content_scheduler/manage_categories', 'add');
}
?>	


<form method="post" action="<?php echo $action?>" id="content-form">			
		<table border="0" class="sortable" cellspacing="0" cellpadding="0">
			<thead>
            <tr>
				<?php    if ($this->controller->getTask() != 'edit') { ?><th><?php   echo t('Edit')?></th><?php }?>
				<th <?php    if ($this->controller->getTask() == 'edit') { ?>colspan="3"<?php }?>><?php   echo t('Category')?></th>
                <?php    if ($this->controller->getTask() != 'edit') { ?><th class="noheader"><?php   echo t('Delete')?></th><?php }?>
			</tr>
            </thead>
				<?php
                $pkt = Loader::helper('concrete/urls');
				$pkg= Package::getByHandle('nexxt');
				foreach($cat_values as $cat){
            	?>
			<tr>
             <?php    if ($this->controller->getTask() != 'edit' && $cat['ctID']!=$ctIDedit) { ?>
				<td width="20px" align="center">
               
				<A href="<?php   echo $this->url('/dashboard/content_scheduler/manage_categories', 'edit', $cat['ctID'])?>"><img src="<?php   echo $pkt->getPackageURL($pkg).'/tools/edit.png';?>"/></a>
                
                </td>
                <?php }?>
				
<?php    if ($this->controller->getTask() == 'edit' && $cat['ctID']==$ctIDedit) { ?>

<td <?php    if ($this->controller->getTask() == 'edit') { ?>colspan="3"<?php }?>> 
<?php  echo $form->text('editcat',  $cat['category'], array('style' => 'width: 79%'))?> 
&nbsp;&nbsp;
<input type="image" src="<?php   echo $pkt->getPackageURL($pkg).'/tools/apply.png';?>" style="vertical-align:middle"/>
<?php   echo $form->hidden('ctID', $cat['ctID'])?>

&nbsp;&nbsp;
<A href="<?php   echo $this->url('/dashboard/content_scheduler/manage_categories')?>">
<img src="<?php   echo $pkt->getPackageURL($pkg).'/tools/cancel.png';?>"style="vertical-align:middle"/>
</a>
</td>
<?php }else{?>
<td <?php    if ($this->controller->getTask() == 'edit') { ?>colspan="3"<?php }?>><?php   echo $cat['category']?></td>
<?php }?>
 <?php    if ($this->controller->getTask() != 'edit' && $cat['ctID']!=$ctIDedit) { ?>
                <td width="20px" align="center">
               
                <A href="<?php   echo $this->url('/dashboard/content_scheduler/manage_categories', 'delete_check', $cat['ctID'],$cat['category'])?>"><img src="<?php   echo $pkt->getPackageURL($pkg).'/tools/delete.png';?>" /></a>
                
				</td>
                <?php }?>
			</tr>
	<?php }?>	
<?php    if ($this->controller->getTask() != 'edit'){?>
            <tr>
            <td class="subheader" colspan="3">
            <strong><?php   echo $form->label('addCat', t('Add New Category'))?></strong>
            </td>
            </tr>
            <tr>
            <td colspan="2">
            <?php  echo $form->text('newcat', $newcat, array('style' => 'width: 98%'))?>
            </td>
            <td align="center">

			<input type="image" src="<?php   echo $pkt->getPackageURL($pkg).'/tools/add.png';?>">

            </td>
            </tr>
         <?php } ?>
			</table>
			<br/>
				<div class="ccm-spacer">&nbsp;</div>

	</form>
            
		</div>
	</div>