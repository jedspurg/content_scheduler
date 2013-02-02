<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
class DashboardContentSchedulerController extends DashboardBaseController {
	


	public function view() {
		$this->redirect('/dashboard/content_scheduler/content_list/');
	}
	
}