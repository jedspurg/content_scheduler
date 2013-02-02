<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$scon = $this->controller;
$item = $scon->getContentItem($ctID);


?>
  <div>
  
    <div class="quote-bottom"><div class="quote-top"><em><?php echo $item[0]['content']?></em></div></div>
    </div>
  