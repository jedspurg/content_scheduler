<?php   
require_once(DIR_FILES_BLOCK_TYPES_CORE . '/library_file/controller.php');

	class ScheduledContentBlockController extends BlockController {
		
		var $pobj;

		protected $btTable = 'btScheduledContent';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "200";
		
		public function getBlockTypeDescription() {
			return t("Scheduled Content");
		}
		
		public function getBlockTypeName() {
			return t("Scheduled Content");
		}
	
		
		function getbID() {return $this->bID;}
		


		
		function view() {
			

		}	
		
		public function getContentCats(){
			$db = Loader::db();
			
			$cats = $db->query("SELECT * FROM btContentCategories");
			while($row=$cats->fetchrow()){
				$values[] = $row;
			}		
	
			return $values;
		}
		
		public function getContentItem($ctID){
			$db = Loader::db();
			
			$cats = $db->query("SELECT * FROM btContentScheduler WHERE pubdatetime <= NOW() AND ctID = '$ctID' ORDER BY pubdatetime DESC LIMIT 1");
			while($row=$cats->fetchrow()){
				$values[] = $row;
			}	
	
			return $values;
		}
		
		public function getContentImage($fID, $w, $h){
					   		
			$ih = Loader::helper('image'); 
			$f = File::getByID($fID); 
			$fv = $f->getApprovedVersion();
			
			
			$imgThumb = $ih->getThumbnail($f,$w,$h);
			if (!$f == null){
				if($fv->getExtension() == 'gif'){
					$mediaImg = '<img src="' . $fv->getURL() . '"/>';
				}else{
					$mediaImg = '<img src="' . $imgThumb->src . '" width="' . $imgThumb->width . '" height="' . $imgThumb->height . '" />';
				}
			
			}else{ 
				$mediaImg='';
			}
			print $mediaImg;
		
		}

		function save($data) { 

			$args['ctID'] = isset($data['cat']) ? $data['cat'] : '1';
			
			parent::save($args);
		}	
		
		public function on_page_view() {

		}
		

}
?>