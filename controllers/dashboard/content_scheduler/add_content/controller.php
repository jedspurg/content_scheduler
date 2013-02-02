<?php    
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerAddContentController extends DashboardBaseController  {
	

	public $helpers = array('html','form');
	
	
	
	public function view($date = '') {
		$this->setupForm();
		$this->set('date', $date);
	}


	public function getContentCats(){
		$db = Loader::db();
		
		$cats = $db->query("SELECT * FROM btContentCategories");
		while($row=$cats->fetchrow()){
			$values[] = $row;
		}		

		return $values;
	}


	public function edit($scID) {
		$this->setupForm();

		$this->set('thisContentItem', $this->getContentItem($scID));
		$this->set('scID', $scID);

		

	}
	
	public function update($scID) {
		if ($this->isPost()) {

			if (!$this->error->has()) {
		
				$data = array('title' => $this->post('contitle'), 'pudatetime' => Loader::helper('form/date_time')->translate('pubdatetime'), 'content' => $this->post('contentBody'), 'ctID' => $this->post('ctID'),'fID' => $this->post('contentimage'),'link' => $this->post('link'),'newTab' => $this->post('newTab'),'linkText' => $this->post('linktext'),'caption' => $this->post('caption'));

				$this->updateData($data,$scID);

				$this->redirect('/dashboard/content_scheduler/content_list/', 'content_updated');
			}
		}
	}

	protected function setupForm() {
		$this->set('cat_values', $this->getContentCats());
		
		$this->addHeaderItem(Loader::helper('html')->javascript('tiny_mce/tiny_mce.js'));
	}
	
	public function getContentItem($scID){
		$db = Loader::db();
		
		$contentItems = $db->query("SELECT * FROM btContentScheduler where scID = '$scID'");
		while($row=$contentItems->fetchrow()){
			$schedContent[] = $row;
		}		
		return $schedContent;
	}


	public function add() {


		if ($this->isPost()) {

			if (!$this->error->has()) {
		
				$data = array('title' => $this->post('contitle'), 'pudatetime' => Loader::helper('form/date_time')->translate('pubdatetime'), 'content' => $this->post('contentBody'), 'ctID' => $this->post('ctID'),'fID' => $this->post('contentimage'),'link' => $this->post('link'),'newTab' => $this->post('newTab'),'linkText' => $this->post('linktext'),'caption' => $this->post('caption'));

				$this->saveData($data);

				$this->redirect('/dashboard/content_scheduler/content_list/', 'content_scheduled');
			}
		}
	}



	
	
	private function saveData($data) {

		$db= Loader::db();

		$q = ("INSERT INTO btContentScheduler (title,pubdatetime,content,ctID,fID,link,newTab,linkText,caption) VALUES (?,?,?,?,?,?,?,?,?)");
		$db->EXECUTE($q,$data);

	}
	
	private function updateData($data,$scID) {

		$db= Loader::db();
		
		$db->query("UPDATE btContentScheduler SET title = ?, pubdatetime = ?, content = ?, ctID = ?, fID = ?, link = ?, newTab = ?, linkText = ?, caption = ? WHERE scID ='$scID'", $data);


	}
	
		
	public function on_before_render() {
		$this->set('error', $this->error);
	}
	
}