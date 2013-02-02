<?php 
defined('C5_EXECUTE') or die(_("Access Denied.")); 
 
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Scheduled Content Calendar'), false,'span10 offset1', false);
?>


<div class="ccm-pane-body">
<?php 
if(isset($_GET['back'])){
	$month = $_GET['CurrentMonth'];
	$year = $_GET['CurrentYear'];
	if($month == 1){
		$month = 12;
		$year = $year-1;
	}else{
		$month--;
	}
	$ctID = $_GET['ctID'];
}else if (isset($_GET['next'])){
	$month = $_GET['CurrentMonth'];
	$year = $_GET['CurrentYear'];
	if($month == 12){
		$month = 1;
		$year = $year+1;
	}else{
		$month++;
	}
	$ctID = $_GET['ctID'];
}else if (isset($_GET['dateset'])){
	$date =time () ;
	$day = date('d', $date) ;
	$year = $_GET['setyear'];
	$month = $_GET['setmo'];
	$ctID = $_GET['cat'];
}else{
	$date =time () ;
	$day = date('d', $date) ;
	$month = date('m', $date) ;
	$year = date('Y', $date) ;
	$ctID='';
}

$days_in_month = cal_days_in_month(0, $month, $year) ; 

$contentItems = $controller->getDateSpan($ctID,date('Y-m-d',strtotime($year.'-'.$month.'-01')),date('Y-m-d',strtotime($year.'-'.$month.'-'.$days_in_month)));

$first_day = mktime(0,0,0,$month, 1, $year) ; 

$title = date('F', $first_day) ; 

$day_of_week = date('D', $first_day) ; 

switch($day_of_week){ 
		case date('D', strtotime('Mon')) : $padding = 1; break; 
		case date('D', strtotime('Tue')) : $padding = 2; break; 
		case date('D', strtotime('Wed')) : $padding = 3; break; 
		case date('D', strtotime('Thu')) : $padding = 4; break; 
		case date('D', strtotime('Fri')) : $padding = 5; break; 
		case date('D', strtotime('Sat')) : $padding = 6; break; 
		case date('D', strtotime('Sun')) : $padding = 0; break; 
}?>
		

<div class="pull-left">
<form action="<?php echo $this->url('dashboard/content_scheduler/calendar_view')?>" method="GET">

  <select name="setyear" style="width:80px;">
      <option value="<?php   echo $year-2?>"><?php   echo $year-2?></option>
      <option value="<?php   echo $year-1?>"><?php   echo $year-1?></option>
      <option value="<?php   echo $year?>" selected="selected"><?php   echo $year?></option>
      <option value="<?php   echo $year+1?>"><?php   echo $year+1?></option>
      <option value="<?php   echo $year+2?>"><?php   echo $year+2?></option>
  </select>
  <select name="setmo" style="width:80px;">
      <option value="01" <?php   if($month == '01'){?> selected="selected"<?php } ?>><?php   echo t('Jan');?></option>
      <option value="02" <?php   if($month == '02'){?> selected="selected"<?php } ?>><?php   echo t('Feb');?></option>
      <option value="03" <?php   if($month == '03'){?> selected="selected"<?php } ?>><?php   echo t('Mar');?></option>
      <option value="04" <?php   if($month == '04'){?> selected="selected"<?php } ?>><?php   echo t('Apr');?></option>
      <option value="05" <?php   if($month == '05'){?> selected="selected"<?php } ?>><?php   echo t('May');?></option>
      <option value="06" <?php   if($month == '06'){?> selected="selected"<?php } ?>><?php   echo t('Jun');?></option>
      <option value="07" <?php   if($month == '07'){?> selected="selected"<?php } ?>><?php   echo t('Jul');?></option>
      <option value="08" <?php   if($month == '08'){?> selected="selected"<?php } ?>><?php   echo t('Aug');?></option>
      <option value="09" <?php   if($month == '09'){?> selected="selected"<?php } ?>><?php   echo t('Sep');?></option>
      <option value="10" <?php   if($month == '10'){?> selected="selected"<?php } ?>><?php   echo t('Oct');?></option>
      <option value="11" <?php   if($month == '11'){?> selected="selected"<?php } ?>><?php   echo t('Nov');?></option>
      <option value="12" <?php   if($month == '12'){?> selected="selected"<?php } ?>><?php   echo t('Dec');?></option>
  </select>
  <select name="cat" style="width:130px;">
          <option value=''>All</option>
      <?php foreach($cat_values as $cat){?>
          <option <?php if($_GET['cat']==$cat['ctID']){?> selected="selected"<?php }?> value="<?php echo $cat['ctID']?>"><?php echo $cat['category']?></option>
      <?php }?>
  </select>
  <input type="hidden" name="dateset" value="1">
  
  <button type="submit" class="btn"/><?php echo t('Filter')?> <i class="icon-tasks"></i></button>
			
</form>
</div>

<div class="pull-right btn-group">
<a href="<?php echo $this->url('dashboard/content_scheduler/calendar_view')?>?back=1&CurrentMonth=<?php   echo $month ;?>&CurrentYear=<?php   echo $year  ; ?>&cat=<?php   echo $ctID ;?>" class="btn"><i class="icon-chevron-left"></i> <?php echo t('Prev')?></a>
<a href="javascript:void(0);" class="btn"><?php echo $title.' '. $year;?></a>
<a href="<?php echo $this->url('dashboard/content_scheduler/calendar_view')?>?next=1&CurrentMonth=<?php   echo $month ;?>&CurrentYear=<?php   echo $year  ; ?>&cat=<?php   echo $ctID ;?>" class="btn"><?php echo t('Next')?> <i class="icon-chevron-right"></i></a>
</div>
	
<table class="table table-bordered" id="content-cal">	
    <thead>			
        <tr>
        <th><?php echo t('Sunday')?></th>
        <th><?php echo t('Monday')?></th>
        <th><?php echo t('Tuesday')?></th>
        <th><?php echo t('Wednesday')?></th>
        <th><?php echo t('Thursday')?></th>
        <th><?php echo t('Friday')?></th>
        <th><?php echo t('Saturday')?></th>
        </tr>
    </thead>
			
<?php $day_count = 1;?>

<tr>
<?php while ( $padding > 0 ) { ?>
    <td class="blank-day"></td>
<?php $padding--; $day_count++;
}

$day_num = 1;

while ( $day_num <= $days_in_month ) { 
	if(date('Y-m-d') == date('Y-m-d',strtotime($year.'-'.$month.'-'.$day_num))){ $today = 'id="current"';}else{$today='';}
?>
				<td <?php echo $today?>>
				<?php   
				echo $day_num ;
				$pkt = Loader::helper('concrete/urls');
				$pkg= Package::getByHandle('content_scheduler');
				?>
    			<a href="<?php echo View::url('/dashboard/content_scheduler/add_content', $year.'-'.$month.'-'.$day_num)?>" class="pull-right" title="<?php echo t('Add Content')?>"><i class="icon-plus-sign"></i></a>

				<div class="cal-day">
				<?php  
				
				$daynum = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day_num));
				
		//we want to loop through each event, check it's recur state, then check if the current date block being looped through is with that range
		if ($contentItems != null){
					foreach($contentItems as $key => $row){
							
							$date = date('Y-m-d',strtotime($row['pubdatetime']));
							
							if($date == $daynum){
								$url = $this->url('/dashboard/content_scheduler/add_content', 'edit', $row['scID']); 
								$content_item = $day_num;
							}
									
							
								$i += 1;

								if($content_item==$day_num){
								

									?>
									<div id="normal">
									<a  href="<?php   echo $url ; ?>" class="tooltip">
									<?php   echo substr($row['title'],0,15).'...' ;?>
									
									<span>
										<h2><?php   echo $row['title'] ; ?></h2>
                                        
											<?php   
												$time = 'Publish Time: '.date('g:ia',strtotime($row['pubdatetime']));
												echo $time;?>
												<br/><br/>
												<?php $this->controller->getContentImage($row['fID']);?>
											
										<br/>
										<p><?php   
											$content = strip_tags($row['content']);
											echo  substr($content,0,90).'.....';
											?></p>
								     <p>category: <?php   echo $this->controller->getCatValue($row['ctID']) ; ?></p>
									</span>
									</a>
								</div>
									
									<?php  
									
								}
							unset($content_item);
						}
		}
		?>
	</div>


</td> 
<?php  
$day_num++; 
$day_count++;

if ($day_count > 7){?>
    </tr>
    
    <tr>
<?php 
$day_count = 1;
	}
}

while ( $day_count > 1 && $day_count <= 7 ) { ?>
	<td class="blank-day"> </td> 
<?php
	$day_count++; 
} 
?>

	</tr>
</table>
	

</div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false); ?>
