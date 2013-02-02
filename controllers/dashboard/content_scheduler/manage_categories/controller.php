<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerManageCategoriesController extends Controller {
	
	public $helpers = array('html','form');
	
	public function on_start() {
		$this->error = Loader::helper('validation/error');
		$html = Loader::helper('html');


	}
	
	public function view() {
		
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('sortable.css', 'nexxt'));
		$this->set('cat_values', $this->getContentCats());
	
	}


	
	public function delete_check($ctID,$title) {
		if ($ctID == 1){
			$this->set('message', t('This category cannot be deleted.'));
		$this->view();
		}else{
		$this->set('message', t('Are you sure you want to delete "'.$title.'"? &nbsp;&nbsp; 
			<form method="post" action="'.BASE_URL.DIR_REL.'/index.php/dashboard/content_scheduler/manage_categories/delete/'.$ctID.'"><br/>
			<input type="submit" value="Yes, delete this category" /></form>'));
		$this->view();
		}
	}
	
	public function delete($ctID) {
		$db = Loader::db();
		$db->Execute("DELETE from btContentCategories where ctID = '$ctID'");
		$db->Execute("UPDATE btContentCategories SET ctID = '1' where ctID = '$ctID'");
		$this->set('message', t('Category deleted')); 
		$this->view();
	}
	
	public function add() {
		$db = Loader::db();
		$value = $this->post('newcat');
		$db->Execute("INSERT INTO btContentCategories (category) VALUES ('$value')");
		$this->set('message', t('Category "'.$value.'" added')); 
		$this->view();
	}
	
	public function edit($ctID) {

		$this->set('ctIDedit', $ctID);
		$this->view();
	}
	
	public function update() {
		
		$db = Loader::db();
		$ctID= $this->post('ctID');
		$value = $this->post('editcat');
		$db->Execute("UPDATE btContentCategories SET category = '$value' WHERE ctID = '$ctID'");

		$this->set('message', t('Content category updated.'));
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
	

	
	

	

	
	
	
}