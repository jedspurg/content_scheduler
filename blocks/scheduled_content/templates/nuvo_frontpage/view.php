<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$scon = $this->controller;
$item = $scon->getContentItem($ctID);
$cat = $scon->getCatFromID($ctID);

?>

  <div class="featuredcon">
	
    <div class="conimg">
	<a onclick="_gaq.push(['_trackEvent', 'IUSM Homepage HotSpot', 'Click', '<?php echo $cat[0]['category'].' - '.$item[0]['title']?>'])" href="<?php echo $item[0]['link'];?>" <?php if($item[0]['newTab'] == 1){?>target="_blank"<?php }?> title="<?php echo $item[0]['title'];?>"><?php if (isset($item[0]['fID'])){$scon->getContentImage($item[0]['fID'],200,200);}?></a>
    </div>
   
	<div class="title"><h6><a onclick="_gaq.push(['_trackEvent', 'IUSM Homepage HotSpot', 'Click', '<?php echo $cat[0]['category'].' - '.$item[0]['title']?>'])" href="<?php echo $item[0]['link'];?>" <?php if($item[0]['newTab'] == 1){?>target="_blank"<?php }?> title=<?php echo $item[0]['title'];?>"><?php echo $item[0]['title'];?></a></h6></div>
   </div>
  