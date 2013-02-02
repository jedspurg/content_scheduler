<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerCalendarViewController extends DashboardBaseController {

		public function view(){
			$html = Loader::helper('html');
			$this->set('html', Loader::helper('concrete/urls'));
			$this->set('uh', $html);
			$this->set('controller',$this);
			$this->set('cat_values', $this->getContentCats());
			$this->addHeaderItem($html->css('cal.css', 'content_scheduler'));
		}
		
		public function getDateSpan($ctID,$start,$end){

			if($ctID != null){
				$category = "AND ctID = '".$ctID."'";
			}else{
				$category = '';
			}
			$start=$start.' 00:00:00';
			$end=$end.' 23:59:59';
			$db = Loader::db();
			
			$r = $db->Query("SELECT * FROM btContentScheduler WHERE pubdatetime >= DATE_FORMAT('$start','%Y-%m-%d %T') AND pubdatetime <= DATE_FORMAT('$end','%Y-%m-%d %T') $category ORDER BY pubdatetime ASC");

			while($row=$r->fetchrow()){
					$contentItems[] = $row;
			}
				
			return $contentItems;
		}
		
		
		public function getContentCats(){
		$db = Loader::db();
		
		$cats = $db->query("SELECT * FROM btContentCategories");
		while($row=$cats->fetchrow()){
			$values[] = $row;
		}		

		return $values;
		}
		
		public function getCatValue($ctID){
		$db = Loader::db();
		$cats = $db->query("SELECT category FROM btContentCategories where ctID ='$ctID'");
		while($row=$cats->fetchrow()){
			$cv = $row;
		}		
		return $cv['category'];
		}
		
		public function getContentImage($fID,$h=200,$w=150){
					   		
			$ih = Loader::helper('image'); 
			$f = File::getByID($fID); 
			$fv = $f->getApprovedVersion();
			$title = $fv->getTitle();
			$imgThumb = $ih->getThumbnail($f,$w,$h);
			if (!$f == null){						
				$mediaImg = '<img class="content-scheduler-img"  alt="'.$title.'" src="' . $imgThumb->src . '" width="' . $imgThumb->width . '" height="' . $imgThumb->height . '" />';
			}else{ 
				$mediaImg='';
			}
			return $mediaImg;
		
		}
	
}