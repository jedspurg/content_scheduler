<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$scon = $this->controller;
$item = $scon->getContentItem($ctID);

?>
    <div class="iotd">
	<?php if (isset($item[0]['fID'])){$scon->getContentImage($item[0]['fID'],200,200);}?>
    <br/>
    <span><?php echo $item[0]['caption']?></span>
    </div>