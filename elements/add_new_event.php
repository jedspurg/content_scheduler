<script type="text/javascript">
function showstuff(boxid){
   document.getElementById('proevent-tab-'+boxid).style.display="block";
   $('ul#ccm-formblock-tabs li').each(function(num,el){ $(el).removeClass('ccm-nav-active') });
   $(document.getElementById('ccm-formblock-tab-'+boxid).parentNode).addClass('ccm-nav-active');
}

function hidestuff(boxid){
   document.getElementById('proevent-tab-'+boxid).style.display="none";
}
</script>
	<?php   
	$form = Loader::helper('form');
	$df = Loader::helper('form/date_time');
	$dti = Loader::helper('form/time','proevents');
	Loader::model('eventify','proevents');
	Loader::model("attribute/categories/collection");
	$settings = Eventify::getSettings();

	$task = 'add';
	$buttonText = t('Add Event Entry');
	$title = 'Add';
	?>
<ul class="ccm-dialog-tabs" id="ccm-formblock-tabs">
	<li class="ccm-nav-active"><a href="javascript:void(0)" onclick="showstuff('settings'); hidestuff('post'); hidestuff('links');" id="ccm-formblock-tab-settings"><?php    echo t('Settings')?></a></li>
	<li><a href="javascript:void(0)" onclick="showstuff('post'); hidestuff('settings');hidestuff('links');" id="ccm-formblock-tab-post"><?php    echo t('Post')?></a></li>
	<li><a href="javascript:void(0)" onclick="showstuff('links'); hidestuff('post'); hidestuff('settings');" id="ccm-formblock-tab-links"><?php    echo t('Links')?></a></li>
</ul>

	<form method="post" action="<?php   echo BASE_URL.DIR_REL.'/index.php/dashboard/proevents/add_event/'.$task.'/'?>" id="event-form">
	
	<div id="proevent-tab-settings" style="display: block;">
	<table id="add_event" class="entry-form">
		<tr>
			<td class="header" colspan="2">
				<?php echo t('Event Info')?>
			</td>
		</tr>
		<tr>
			<td  class="subheader" colspan="2">
				<strong><?php   echo $form->label('eventTitle', t('Event Title'))?></strong>
			</td>
		</tr>
		<tr>
			<td  colspan="2">
				<?php   echo $form->text('eventTitle', $eventTitle, array('style' => 'width: 230px'))?>
			</td>
		</tr>
		<tr>
			<td class="subheader"  colspan="1" style="width: 300px;">
				<strong><?php   echo $form->label('cParentID', t('Section'))?></strong>
			</td>
			<td class="subheader"  colspan="1">
				<strong><?php   echo $form->label('eventCategory', t('Category'))?></strong>
			</td>
		</tr>
		<tr>
			<td  colspan="1">
				<?php    if (count($sections) == 0) { ?>
					<div><?php   echo t('No sections defined. Please create a page with the attribute "event_entry" set to true.')?></div>
				<?php    } else { ?>
					<div><?php   echo $form->select('cParentID', $sections, $cParentID)?></div>
				<?php    } ?>
			</td>
			<td  colspan="1">
				<?php    
			
				$akct = CollectionAttributeKey::getByHandle('event_category');
				if (is_object($event)) {
					$tcvalue = $event->getAttributeValueObject($akct);
				}
				?>
				<div class="event-attributes">
					<div>
						<?php   echo $akct->render('form', $tcvalue, true);?>
					</div>
				</div>			
			</td>
		</tr>
		<tr>
			<td class="subheader"  colspan="1">
				<strong><?php echo t('Exclude Link to Event Item?')?></strong>
			</td>
			<td class="subheader"  colspan="1">
				<strong><?php   echo $form->label('ctID', t('Page Type'))?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="1">
				<?php  
			
				$aknv = CollectionAttributeKey::getByHandle('exclude_nav');
				if (is_object($event)) {
					$nvvalue = $event->getAttributeValueObject($aknv);
				}
				?>
				<?php   
				
				echo $aknv->render('form', $nvvalue, 1, array('size'=>'50'));
	
				?>
			</td>
			<td colspan="1">
				<?php   echo $form->select('ctID', $pageTypes, $ctID)?>
			</td>
		</tr>
	</table>
	<br/><br/>
	<table id="add_event" class="entry-form">
		<tr>
			<td class="header" colspan="4">
				<?php echo t('Date Info')?>
			</td>
		</tr>
		<tr>
			<td class="subheader">
				<?php  
					$evth = CollectionAttributeKey::getByHandle('event_thru');
					if (is_object($event)) {
						$etvalue = $event->getAttributeValueObject($evth);
					}
					$akrr = CollectionAttributeKey::getByHandle('event_recur');
					if (is_object($event)) {
						$rrvalue = $event->getAttributeValueObject($akrr);
					}
				?>	
				<strong><?php   echo $form->label('eventDate', t('Start Date'))?></strong>
			</td>
			<td class="subheader">
				<strong><?php   echo $evth->render('label');?></strong>
			</td>
			<td class="subheader" colspan="2">
				<strong><?php   echo $akrr->render('label');?></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?php   echo $df->date('eventDate', $eventDate)?>	
			</td>
			<td>
				<?php   echo $evth->render('form', $etvalue);?>
			</td>
			<td colspan="2">
				<?php   echo $akrr->render('form', $rrvalue, true);?>
				<i style="padding-left: 15px;">(End date will be ignored if recurring is set to "none".)</i>

			</td>
		</tr>
	</table>
	<br/><br/>
	<table id="add_event" class="entry-form">
		<tr>
			<td class="header" colspan="2">
				<?php echo t('Time Info')?>
			</td>
		</tr>
		<tr>
			<td  class="subheader" colspan="1"  style="width: 300px;">
				<?php  
	
				$akst = CollectionAttributeKey::getByHandle('start_time');
				if (is_object($event)) {
					$stvalue = $event->getAttributeValueObject($akst);
				}
				?>
				<strong><?php   echo $akst->render('label');?></strong>
			</td>
			<td  class="subheader" colspan="1">
				<?php  
				$aket = CollectionAttributeKey::getByHandle('end_time');
				if (is_object($event)) {
					$etvalue = $event->getAttributeValueObject($aket);
				}
				?>
				<strong><?php   echo $aket->render('label');?></strong>
			</td>
		</tr>
		<tr>
			<td  colspan="1">
				<?php   echo $akst->render('form', $stvalue, true);?>
			</td>
			<td  colspan="1">
				<?php   echo $aket->render('form', $etvalue, true);?>
			</td>
		</tr>
		<tr>
			<td  class="subheader" colspan="2">
				<?php  

				$akad = CollectionAttributeKey::getByHandle('event_allday');
				if (is_object($event)) {
					$advalue = $event->getAttributeValueObject($akad);
				}
				?>
				<strong><?php   echo $akad->render('label');?></strong>
			</td>
		</tr>
		<tr>
			<td  colspan="2">
				<?php   echo $akad->render('form', $advalue, true);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>(times will be ignored if this is checked)</i>
			</td>
		</tr>
	</table>
	<br/>
	</div>

	<div id="proevent-tab-post" style="display: none">

	<strong><?php   echo $form->label('eventDescription', t('Event Description'))?></strong>
	<div><?php   echo $form->textarea('eventDescription', $eventDescription, array('style' => 'width: 98%; height: 90px; font-family: sans-serif;'))?></div>
	<br/>	

	<strong><?php   echo $form->label('eventBody', t('Event Content'))?></strong>
	<?php    Loader::element('editor_init'); ?>
	<?php    Loader::element('editor_config'); ?>
	<?php    Loader::element('editor_controls', array('mode'=>'full')); ?>
	<?php   echo $form->textarea('eventBody', $eventBody, array('style' => 'width: 100%; font-family: sans-serif;', 'class' => 'ccm-advanced-editor'))?>
	<br/>
	</div>
	
	
	<div id="proevent-tab-links" style="display: none">
	<?php  

	$akt = CollectionAttributeKey::getByHandle('thumbnail');
	if (is_object($event)) {
		$tvalue = $event->getAttributeValueObject($akt);
	}
	?>
	<div class="event-attributes">
		<div style="width: 230px;">
			<strong><?php   echo $akt->render('label');?></strong>
			<?php   echo $akt->render('form', $tvalue, true);?>
		</div>
	</div>
	<br/>
	<?php  

	$aku = CollectionAttributeKey::getByHandle('event_local');
	if (is_object($event)) {
		$uvalue = $event->getAttributeValueObject($aku);
	}
	?>
	<div class="event-attributes">
		<div>
			<strong><?php   echo $aku->render('label');?></strong><br/>
			<?php   
			
			echo $aku->render('form', $uvalue, array('size'=>'50'));

			?>
		</div>
	</div>
	<br/>
	<?php  

	$aku = CollectionAttributeKey::getByHandle('address');
	if (is_object($event)) {
		$uvalue = $event->getAttributeValueObject($aku);
	}
	?>
	<div class="event-attributes">
		<div>
			<strong>Event&nbsp;<?php   echo $aku->render('label');?></strong><br/>
			<?php   
			
			echo $aku->render('form', $uvalue, array('size'=>'50'));

			?>
		</div>
	</div>
	<br/>
	<?php  

	$aku = CollectionAttributeKey::getByHandle('contact_name');
	if (is_object($event)) {
		$uvalue = $event->getAttributeValueObject($aku);
	}
	?>
	<div class="event-attributes">
		<div>
			<strong><?php   echo $aku->render('label');?></strong><br/>
			<?php   
			
			echo $aku->render('form', $uvalue, array('size'=>'50'));

			?>
		</div>
	</div>
	<br/>
	<?php  

	$aku = CollectionAttributeKey::getByHandle('contact_email');
	if (is_object($event)) {
		$uvalue = $event->getAttributeValueObject($aku);
	}
	?>
	<div class="event-attributes">
		<div>
			<strong><?php   echo $aku->render('label');?></strong><br/>
			<?php   
			
			echo $aku->render('form', $uvalue, array('size'=>'50'));

			?>
		</div>
	</div>
	<br/>
	<?php    
	Loader::model("attribute/categories/collection");
	$akt = CollectionAttributeKey::getByHandle('event_tag');
	if (is_object($event)) {
		$tvalue = $event->getAttributeValueObject($akt);
	}
	?>
	<div class="event-attributes">
		<div>
			<strong><?php   echo $akt->render('label');?></strong>
			<?php   echo $akt->render('form', $tvalue, true);?>
		</div>
	</div>
	<br/>
	</div>
	<?php   
	
	$ih = Loader::helper('concrete/interface');
	print $ih->submit($buttonText, 'event-form');
	?>
	</form>