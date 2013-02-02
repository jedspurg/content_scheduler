<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
$fm = Loader::helper('form'); 
$cat_values = $this->controller->getContentCats();
?>

	<span>
	  	<div><h2><?php    echo t('Scheduled Content Category');?></h2></div>
	  					<select name="cat">

				<?php  
				foreach($cat_values as $cat){
					if($ctID==$cat['ctID']){$selected = 'selected="selected"';}else{$selected=null;}
					echo '<option '.$selected.' value="'.$cat['ctID'].'">'.$cat['category'].'</option>';
				}	
				?>
				</select>
	</span><br/><br/>
    <span>Scheduled Content can be styled using <strong>Custom Templates</strong></span>
