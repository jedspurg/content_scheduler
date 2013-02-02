<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerCalendarViewController extends Controller {

		public function view(){
			$this->set('controller',$this);
			Loader::model('scheduler','content_scheduler');
			$this->set('cat_values', $this->getContentCats());
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
		
		public function getContentImage($fID){
					   		
		$ih = Loader::helper('image'); 
		$f = File::getByID($fID); 
		$fv = $f->getApprovedVersion();
		$imgThumb = $ih->getThumbnail($f,150,200);
		if (!$f == null){						
		$mediaImg = '<img class="ccm-output-thumbnail"  src="' . $imgThumb->src . '" width="' . $imgThumb->width . '" height="' . $imgThumb->height . '" />';
		}else{ 
		$mediaImg='';
		}
		print $mediaImg;
		
		}
	
}