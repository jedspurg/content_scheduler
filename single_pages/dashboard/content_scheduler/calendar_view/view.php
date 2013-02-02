<?php  
$html = Loader::helper('html');
$this->addHeaderItem($html->css('fullcal.css', 'content_scheduler'));

?>

<style>
#event_cal{border-color: #b5b5b5;}
#event_cal TD {border-color:#b5b5b5;background-color: #FFFFFF;}
#event_cal TD:hover {background-color:#f4f4f4;}
#event_cal #cal_blank{background-color: #e7e7e7;}
#event_cal #current{background-color: #f5f5f5;}
#event_cal #allday, #allday a{background-color: #e6e1de;}
.label {text-align: right;}
.struct a {padding-left: 8px; padding-right: 5px;}
.struct {padding-bottom: 5px;}
a.tooltip {position: relative; text-decoration: none;}
a.tooltip span{
	border-style: solid;
	border-color: #999999;
	border-width: 1px;
	color: #787777;
	display: none;
	position: absolute;
	top: -110px;
	left: -155px;
	width: 155px;
	padding: 5px;
	z-index: 100;
	background: #e6e6e6;
	-moz-border-radius: 5px; /* this works only in camino/firefox */
	-webkit-border-radius: 5px; /* this is just for Safari */
}
a:hover.tooltip span{display: block;}
</style>
<div style="width: 760px;">
	<h1><span><?php   echo t('Content Scheduler Calendar View')?></span></h1>
	<div class="ccm-dashboard-inner">
<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$html = Loader::helper('html');
$uh = Loader::helper('concrete/urls');

global $c;
$cParentID =  $c->getCollectionID(); 
$hoveroffset = 'left';

//set this value to one to change the calendar view to Euro format with weeks starting on Mon.
 $euro_cal = 0;

//if the 'BACK' button is selected, bump the month back by one
if(isset($_GET['back'])){
	$month = $_GET['CurrentMonth'];
	$year = $_GET['CurrentYear'];
	if($month == 1){
		$month = 12;
		$year = $year-1;
	}
	else
	{
		$month=$month-1;
	}
	$ctID = $_GET['ctID'];
}
//if the 'NEXT' button is selected, bump the month by one
else if (isset($_GET['next'])){
	$month = $_GET['CurrentMonth'];
	$year = $_GET['CurrentYear'];
	if($month == 12){
		$month = 1;
		$year = $year+1;
	}
	else
	{
	$month= ++$month;
	}
	$ctID = $_GET['ctID'];
}
// if the month select option is used, set the month to that month
else if (isset($_GET['dateset'])){
	$date =time () ;
	$day = date('d', $date) ;
	$year = $_GET['setyear'];
	$month = $_GET['setmo'];
	$ctID = $_GET['cat'];
}
else
{
// if nothing then set the date to today
$date =time () ;
$day = date('d', $date) ;
$month = date('m', $date) ;
$year = date('Y', $date) ;
$ctID='';
}

		$db = Loader::db();

	//We then determine how many days are in the current month
		$days_in_month = cal_days_in_month(0, $month, $year) ; 

	//go grab the posts, check if they are current, return only current posts
		$contentItems = Scheduler::getDateSpan($ctID,date('Y-m-d',strtotime($year.'-'.$month.'-01')),date('Y-m-d',strtotime($year.'-'.$month.'-'.$days_in_month)));

	//Here we generate the first day of the month 
		$first_day = mktime(0,0,0,$month, 1, $year) ; 

	//This gets us the month name 
		$title = date('F', $first_day) ; 

	//Here we find out what day of the week the first day of the month falls on 
		$day_of_week = date('D', $first_day) ; 

	//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
	
	switch($day_of_week){ 
			case date('D', strtotime('Mon')) : if($euro_cal >= 1){$blank = 0;}else{$blank = 1;} break; 
			case date('D', strtotime('Tue')) : if($euro_cal >= 1){$blank = 1;}else{$blank = 2;} break; 
			case date('D', strtotime('Wed')) : if($euro_cal >= 1){$blank = 2;}else{$blank = 3;} break; 
			case date('D', strtotime('Thu')) : if($euro_cal >= 1){$blank = 3;}else{$blank = 4;} break; 
			case date('D', strtotime('Fri')) : if($euro_cal >= 1){$blank = 4;}else{$blank = 5;} break; 
			case date('D', strtotime('Sat')) : if($euro_cal >= 1){$blank = 5;}else{$blank = 6;} break; 
			case date('D', strtotime('Sun')) : if($euro_cal >= 1){$blank = 6;}else{$blank = 0;} break; 
	}
		
			echo "<table  id='event_cal'>";
			echo "<tr><th colspan=5 id='select'>";
			
			
	//here we set up our drop down month select
	$link = Loader::helper('navigation')->getLinkToCollection($c);
	$link = Scheduler::URLfix($link);			

		?>
		<form action="<?php   echo $link ;?>" method="GET">
			<a href="<?php   echo $link ;?>back=1&CurrentMonth=<?php   echo $month ;?>&CurrentYear=<?php   echo $year  ; ?>&cat=<?php   echo $ctID ;?>"><?php   echo t('PREV'); ?></a>
			&nbsp;
			<select name="setyear">
				<option value="<?php   echo $year-2?>"><?php   echo $year-2?></option>
				<option value="<?php   echo $year-1?>"><?php   echo $year-1?></option>
				<option value="<?php   echo $year?>" selected ><?php   echo $year?></option>
				<option value="<?php   echo $year+1?>"><?php   echo $year+1?></option>
				<option value="<?php   echo $year+2?>"><?php   echo $year+2?></option>
			</select>
			<select name="setmo">
				<option value="01" <?php   if($month == '01'){echo 'selected' ; } ?>><?php   echo t('Jan');?></option>
				<option value="02" <?php   if($month == '02'){echo 'selected' ; } ?>><?php   echo t('Feb');?></option>
				<option value="03" <?php   if($month == '03'){echo 'selected' ; } ?>><?php   echo t('Mar');?></option>
				<option value="04" <?php   if($month == '04'){echo 'selected' ; } ?>><?php   echo t('Apr');?></option>
				<option value="05" <?php   if($month == '05'){echo 'selected' ; } ?>><?php   echo t('May');?></option>
				<option value="06" <?php   if($month == '06'){echo 'selected' ; } ?>><?php   echo t('Jun');?></option>
				<option value="07" <?php   if($month == '07'){echo 'selected' ; } ?>><?php   echo t('Jul');?></option>
				<option value="08" <?php   if($month == '08'){echo 'selected' ; } ?>><?php   echo t('Aug');?></option>
				<option value="09" <?php   if($month == '09'){echo 'selected' ; } ?>><?php   echo t('Sep');?></option>
				<option value="10" <?php   if($month == '10'){echo 'selected' ; } ?>><?php   echo t('Oct');?></option>
				<option value="11" <?php   if($month == '11'){echo 'selected' ; } ?>><?php   echo t('Nov');?></option>
				<option value="12" <?php   if($month == '12'){echo 'selected' ; } ?>><?php   echo t('Dec');?></option>
			</select>
			<select name="cat">
					<option value=''>--</option>
				<?php  
				foreach($cat_values as $cat){
					if($_GET['cat']==$cat['ctID']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.' value="'.$cat['ctID'].'">'.$cat['category'].'</option>';
				}	
				?>
				</select>
			<input type="hidden" name="dateset" value="1">
			<input type="submit" value="Filter" />
			&nbsp;
			<a href="<?php   echo $link ;?>next=1&CurrentMonth=<?php   echo $month ;?>&CurrentYear=<?php   echo $year  ; ?>&cat=<?php   echo $ctID ;?>"><?php   echo t('NEXT'); ?></a>
		</form>

		<?php  
		//Here we start building the table heads 
			   
			echo "</th><th colspan=3 id='year'>$title $year</th></tr>";
	
			if($euro_cal >= 1){
			
			echo '<tr class="header"><td>'.date('D',strtotime('Monday')).'</td><td>'.date('D',strtotime('Tuesday')).'</td><td>'.date('D',strtotime('Wednesday')).'</td><td>'.date('D',strtotime('Thursday')).'</td><td>'.date('D',strtotime('Friday')).'</td><td>'.date('D',strtotime('Saturday')).'</td><td>'.date('D',strtotime('Sunday')).'</td></tr>';
			
			}else{
			
			echo '<tr class="header"><td>'.date('D',strtotime('Sunday')).'</td><td>'.date('D',strtotime('Monday')).'</td><td>'.date('D',strtotime('Tuesday')).'</td><td>'.date('D',strtotime('Wednesday')).'</td><td>'.date('D',strtotime('Thursday')).'</td><td>'.date('D',strtotime('Friday')).'</td><td>'.date('D',strtotime('Saturday')).'</td></tr>';
			
			}

		//This counts the days in the week, up to 7
			$day_count = 1;

			echo "<tr>";

		//first we take care of those blank days
			while ( $blank > 0 ) { 
				echo "<td id='cal_blank'></td>"; 
				$blank = $blank-1; 
				$day_count++;
			}

		//sets the first day of the month to 1 
			$day_num = 1;

		//count up the days, untill we've done all of them in the month
			while ( $day_num <= $days_in_month ) { 
		
		//if the current date block being looped through is equal to today's date, then highlight it via CSS	
			if(date('Y-m-d') == date('Y-m-d',strtotime($year.'-'.$month.'-'.$day_num))){ $daystyle = 'current';}else{$daystyle = 'day';}
			 ?>
				<td  valign="top" id="<?php   echo $daystyle ; ?>">
				<?php   
				echo $day_num ;
				$pkt = Loader::helper('concrete/urls');
				$pkg= Package::getByHandle('content_scheduler');
				?>
    			<a href="<?php echo View::url('/dashboard/content_scheduler/add_content', $year.'-'.$month.'-'.$day_num)?>"><img style="float:right;padding-right:2px; padding-top:2px;" src="<?php   echo $pkt->getPackageURL($pkg).'/css/add-cal.png';?>" title="Add Content"/></a>

				<div id="cal_day">
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

//Make sure we start a new row every week
	if ($day_count > 7){
		echo "</tr><tr>";
		$day_count = 1;
	}
}

//Finaly we finish out the table with some blank details if needed
while ( $day_count >1 && $day_count <=7 ) { 
	echo "<td id='cal_blank'> </td>"; 
	$day_count++; 
} 

echo "</tr></table>";
	
//is iCal feed option is sellected, show it
		if($showfeed==1){		
			?>
			   	<div class="iCal">
        			<p><img src="<?php    echo Scheduler::getCalUrl() ;?>" width="25" alt="iCal feed" />&nbsp;&nbsp;
        			<a href="<?php    echo(Scheduler::getiCalUrl());?>?ctID=<?php   echo $ctID ;?>&bID=<?php   echo $bID ; ?>&ordering=<?php   echo $ordering ;?>" id="getFeed">
        			<?php    echo t('get iCal link');?></a></p>
        			<link href="<?php    echo Scheduler::getiCalUrl();?>" rel="alternate" type="application/rss+xml" title="<?php    echo t('RSS');?>" />
    			</div>
    		<?php  
    	}


	if (isset($bID)) { echo '<input type="hidden" name="bID" value="'.$bID.'" />';}
	
?>
	</div>
</div>
