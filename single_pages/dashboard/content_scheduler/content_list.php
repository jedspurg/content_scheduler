<?php
defined('C5_EXECUTE') or die(_("Access Denied.")); 
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Scheduled Content List'), t('Schedule content on your site.'), 'span10 offset1', false);?>
<div class="ccm-pane-body">

	<div class="pull-left">
		<form method="post" action="<?php   echo $this->action('view')?>" class="form-inline">



			<?php   echo t('View by category')?>
				<select name="cat">
					<option value=''>--</option>
				<?php  
				foreach($cat_values as $cat){
					if($selectedCat==$cat['ctID']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.' value="'.$cat['ctID'].'">'.$cat['category'].'</option>';
				}	
				?>
				</select>
				
				<?php   echo $form->submit('submit', 'Filter')?>
				
		
		</form>
</div>
<div class="pull-right btn-group">
<a href="<?php   echo $this->url('/dashboard/content_scheduler/calendar_view')?>" class="btn ">View Calendar <i class="icon-calendar"></i></a>
<a href="<?php   echo $this->url('/dashboard/content_scheduler/add_content')?>" class="btn btn-success">Add Content <i class="icon-plus-sign icon-white"></i></a>


</div>
			
		<table class="table table-bordered table-striped">
			<thead>
            <tr>
				<th><?php   echo t('Edit')?></th>
				<th><?php   echo t('Title')?></th>
				<th><?php   echo t('Scheduled Date / Time')?></th>
				<th><?php   echo t('Content Category')?></th>
                <th><?php   echo t('Delete')?></th>
			</tr>
            </thead>
				<?php
                $pkt = Loader::helper('concrete/urls');
				$pkg= Package::getByHandle('nexxt');
				if ($contentItems != null){
				foreach($contentItems as $contentItem){
            	?>
			<tr>
				<td style="width:20px;text-align:center;">
				<a href="<?php   echo $this->url('/dashboard/content_scheduler/add_content', 'edit', $contentItem['scID'])?>" class="btn"><i class="icon-edit"></i></a></td>
				<td><a href="<?php   echo $this->url('/dashboard/content_scheduler/add_content', 'edit', $contentItem['scID'])?>"><?php   echo $contentItem['title']?></a></td>
				<td><?php   echo date('M j, Y g:ia - (l)', strtotime($contentItem['pubdatetime']))?></td>
				<td><?php   echo $this->controller->getCatValue($contentItem['ctID'])?></td>
                <td style="width:20px;text-align:center;"><a id="targetEl" class="btn btn-danger"><i class="icon-remove-circle icon-white"></i></a>
				</td>
			</tr>
		
			<?php }}else{?>
            <tr>
            <td colspan="6" align="center"><?php   echo t('There are no content items to display')?></td>
            </tr>
            <?php } ?>
			</table>
	

</div>    
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>

<script>
$('#targetEl').dialog({
  modal : true,
  width  : 500,
  height : 500,
  close   : function(){
    doSomething();
  }
});
</script>