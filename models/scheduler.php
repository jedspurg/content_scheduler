<?php   
class Scheduler extends Model{
	
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
			
	
}