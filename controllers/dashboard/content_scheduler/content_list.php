<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerContentListController extends DashboardBaseController {
	
	public $num = 15;
	
	public $helpers = array('html','form');
	
	
	
	public function view() {
		
		$html = Loader::helper('html');
	
		
		if(isset($_POST['cat']) && $_POST['cat'] !=''){
			$this->set('contentItems', $this->getFilteredContent($_POST['cat']));	
			$this->set('selectedCat',$_POST['cat']);		   
		}else{
			$this->set('contentItems', $this->getAllContent());
		}
	
		$this->set('cat_values', $this->getContentCats());
	
	}


	
	public function delete_check($scID,$title) {
		$this->set('message', t('Are you sure you want to delete "'.$title.'"?').'<a href="'.BASE_URL.DIR_REL.'/index.php/dashboard/content_scheduler/content_list/delete/'.$scID.'" class="btn btn-danger">'.t('Delete').'</a>');
		$this->view();
	}
	
	public function delete($scID) {
		$db = Loader::db();
		$db->Execute("DELETE from btContentScheduler where scID = '$scID'");
		$this->set('message', t('Content deleted')); 
		$this->view();
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
	
		public function getAllContent(){
		$db = Loader::db();
		
		$contentItems = $db->query("SELECT * FROM btContentScheduler ORDER BY ctID, pubdatetime ");
		while($row=$contentItems->fetchrow()){
			$schedContent[] = $row;
		}		

		return $schedContent;	

	}
	
		public function getFilteredContent($ctID){
		$db = Loader::db();
		
		$contentItems = $db->query("SELECT * FROM btContentScheduler where ctID = '$ctID'");
		while($row=$contentItems->fetchrow()){
			$schedContent[] = $row;
		}		

		return $schedContent;
	}

	
	
	public function content_scheduled() {
		$this->set('message', t('Content scheduled.'));
		$this->view();
	}
	
	public function content_updated() {
		$this->set('message', t('Content updated.'));
		$this->view();
	}
	
	
	
}