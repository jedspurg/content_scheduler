<?php  defined('C5_EXECUTE') or die('Access Denied');
   
	$df = Loader::helper('form/date_time');
	if ($this->controller->getTask() == 'edit') { 

		$task = 'update';
		$buttonText = t('Update Content');
		$title = 'Update';
	} else {
		$task = 'add';
		$buttonText = t('Add Content');
		$title = 'Add';
	}
	
	?>

	
	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Schedule Content'), t('Schedule content on your site.'),'span10 offset1', false);?>


	<?php    if ($this->controller->getTask() == 'edit') { ?>
		<form method="post" action="<?php   echo $this->action($task,$scID)?>" id="content-form" class="form-vertical">
		<?php   echo $form->hidden('scID', $scID)?>
	<?php    }else{ ?>
		<form method="post" action="<?php   echo $this->action($task)?>" id="content-form" class="form-vertical">
	<?php   } ?>
<div class="ccm-pane-body">	

	<table id="add_event" class="table table-bordered">

		<tr>
			<td width="50%">
				<strong><?php   echo t('Content Title')?></strong>
			</td>
            <td >
				<strong><?php   echo t('Category')?></strong>
			</td>
		</tr>
		<tr>
			<td >
				<?php   echo $form->text('contitle', $thisContentItem[0]['title'], array('style' => 'width: 98%'))?>
			</td>
			<td >

				<select name="ctID">
				<?php  
				foreach($cat_values as $cat){
					if($thisContentItem[0]['ctID']==$cat['ctID']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.' value="'.$cat['ctID'].'">'.$cat['category'].'</option>';
				}	
				?>
				</select>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<strong><?php   echo t('Publish Date/Time')?></strong>
			</td>
		
		</tr>
		<tr>
			<td colspan="2">
            <?php 
			if($this->controller->getTask()!='edit'){
				echo $df->datetime('pubdatetime', $date.' 12:00:00');
			}else{
				echo $df->datetime('pubdatetime', $thisContentItem[0]['pubdatetime']);
			}
			?>
			</td>


		</tr>

		
		<tr>
			<td>
				
				<strong><?php   echo t('Image')?></strong>
			</td>
			<td>
				<strong><?php   echo t('Image Caption')?></strong>
			</td>
		</tr>
		<tr>
			<td>
				 <?php 
				 $ih = Loader::helper('image'); 
				 $f = File::getByID($thisContentItem[0]['fID']); 
				 $al = Loader::helper('concrete/asset_library');
                 echo $al->image('ccm-1-image', 'contentimage', 'Choose file',$f );
				 ?>
			</td>
			<td>
				<?php  echo $form->textarea('caption', $thisContentItem[0]['caption'], array('style' => 'width: 98%'))?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php   echo t('Read More Link')?></strong>
			</td>
			<td>
				<strong><?php   echo t('Link Text')?></strong>
			</td>
		</tr>
        <tr>
			<td>
           
			<?php  
			 $link = ($thisContentItem[0]['link'] == '') ? 'http://' : $thisContentItem[0]['link'];
			 echo $form->text('link', $link, array('style' => 'width: 98%'));
			 ?>
            <br/>
            
			<?php $linkChecked = ($thisContentItem[0]['newTab'] == '1') ? 'checked="checked"' : '' ?>
			<input type="checkbox" value="1" name="newTab"  <?php echo $linkChecked?>/> open link in new window
			</td>
			<td>
			<?php  echo $form->text('linktext', $thisContentItem[0]['linkText'], array('style' => 'width: 98%'))?>
            <br/>&nbsp;
			</td>
		</tr>
        <tr>
			<td colspan="2">
				<strong><?php echo  t('Content Text')?></strong>
			</td>
			
		</tr>
		<tr>
			<td  colspan="2">	
				<?php    Loader::element('editor_init'); ?>
                <?php    Loader::element('editor_config'); ?>
                <?php    Loader::element('editor_controls'); ?>
                <?php   echo $form->textarea('contentBody', $thisContentItem[0]['content'], array('style' => 'width: 100%; font-family: sans-serif;', 'class' => 'ccm-advanced-editor'))?>
			</td>
		</tr>
	</table>
</div>
<div class="ccm-pane-footer">  
	<?php   
	
	print $interface->submit($buttonText, 'site-form', 'right','primary');
	?>
</div>	


	</form>
    
    <?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
	