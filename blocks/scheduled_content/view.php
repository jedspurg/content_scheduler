<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$scon = $this->controller;
$item = $scon->getContentItem($ctID);
$newwindow = ($item[0]['newTab'] == 0) ? '':'target="_blank"';

?>
  <div class="scheduledcongen">
	<h2><?php echo $item[0]['title'];?></h2>
    <div class="genconimg">
	<?php if (isset($item[0]['fID'])){$scon->getContentImage($item[0]['fID'],200,200);}?>
    <br/>
    <span><?php echo $item[0]['caption']?></span>
    </div>
	<p><?php echo $item[0]['content']?><br/>
    <a href="<?php echo $item[0]['link']?>" <?php echo $newwindow?> ><?php echo $item[0]['linkText']?></a></p>
   </div>
  