


		<form method="get" action="<?php   echo $this->action('view')?>" class="form-inline">



			<?php   echo t('View by category')?>
				<select name="cat">
					<option value=''>--</option>
				<?php  
				foreach($cat_values as $cat){
					if($_GET['cat']==$cat['ctID']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.' value="'.$cat['ctID'].'">'.$cat['category'].'</option>';
				}	
				?>
				</select>
				
				<?php   echo $form->submit('submit', 'Filter')?>
				
		
		</form>
</div>
<div class="pull-right">
<a href="#" class="btn btn-success">Add Content</a>
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
				<td width="20px" align="center">
				<a href="<?php   echo $this->url('/dashboard/content_scheduler/add_content', 'edit', $contentItem['scID'])?>"><img src="<?php   echo $pkt->getPackageURL($pkg).'/tools/edit.png';?>"/></a></td>
				<td><A href="<?php   echo $this->url('/dashboard/content_scheduler/add_content', 'edit', $contentItem['scID'])?>"><?php   echo $contentItem['title']?></A></td>
				<td><?php   echo date('M j, Y g:ia - (l)', strtotime($contentItem['pubdatetime']))?></td>
				<td><?php   echo $this->controller->getCatValue($contentItem['ctID'])?></td>
                <td width="20px" align="center"><a href="<?php   echo $this->url('/dashboard/content_scheduler/content_list', 'delete_check', $contentItem['scID'], $contentItem['title'])?>"><img src="<?php   echo $pkt->getPackageURL($pkg).'/tools/delete.png';?>" /></a>
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