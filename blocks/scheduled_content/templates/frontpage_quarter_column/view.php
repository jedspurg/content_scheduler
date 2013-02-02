<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$scon = $this->controller;
$item = $scon->getContentItem($ctID);

?>
  <div class="featuredcon">
	<div class="title"><?php echo $item[0]['title'];?></div>
    <div class="conimg">
	<?php if (isset($item[0]['fID'])){$scon->getContentImage($item[0]['fID'],200,200);}?>
    </div>
	<div class="feature"><?php echo $item[0]['content']?></div>
   </div>
  