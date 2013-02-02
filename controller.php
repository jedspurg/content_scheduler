<?php   defined('C5_EXECUTE') or die(_("Access Denied."));

class ContentSchedulerPackage extends Package {

	protected $pkgHandle = 'content_scheduler';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '1.1';
	
	public function getPackageDescription() {
		return t('Installs a content scheduler on your site.');
	}
	
	public function getPackageName() {
		return t('Content Scheduler');
	}
	
	
	
	public function install() {
		$pkg = parent::install();
		$db= Loader::db();
		
		
		//Install Single Pages
		$cp = SinglePage::add('/dashboard/content_scheduler/', $pkg);
		$cp->update(array('cName'=>t('Content Scheduler'), 'cDescription'=>t('Schedule content on your site')));
		SinglePage::add('/dashboard/content_scheduler/content_list/', $pkg);
		$an = SinglePage::add('/dashboard/content_scheduler/add_content/', $pkg);
		$an->update(array('cName'=>t('Add Content')));
		$cv = SinglePage::add('/dashboard/content_scheduler/calendar_view/', $pkg);
		$cv->update(array('cName'=>t('Calendar View')));
		$mc = SinglePage::add('/dashboard/content_scheduler/manage_categories/', $pkg);
		$mc->update(array('cName'=>t('Manage Content Categories')));
	
		
		//Install Blocks
		$scbt = BlockType::getByHandle('scheduled_content');
		if(!is_object($scbt)){
		BlockType::installBlockTypeFromPackage('scheduled_content', $pkg);
		}
	
		
		//set the catch-all category for the content scheduler
		 $db->Execute("INSERT INTO btContentCategories (category) VALUES ('Uncategorized')");
	
	}
	
	public function upgrade(){
		parent::upgrade();
	}
	
	public function uninstall(){
			
		$db= Loader::db();
		$db->Execute("DROP TABLE btScheduledContent");
		$db->Execute("DROP TABLE btContentScheduler");
		$db->Execute("DROP TABLE btContentCategories");
	
		parent::uninstall();
	}
	
}

?>
