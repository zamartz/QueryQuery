<?php 
/*-----------------------------------------------------------------------------------------------------//	

	Query Query Admin Page(s) Content

-------------------------------------------------------------------------------------------------------*/
	// get QueryQuery Admin Options
	include_once('QueryQuery_options.php');
?>
<div class="wrap">
 <h2 class="nav-tab-wrapper">
 <a href="<?php if(isset($_GET["page"])){ echo admin_url("admin.php")."?page=".$_GET["page"]."#"; };?>" class="nav-tab <?php if($_GET["action"]== ""){ echo "nav-tab-active";}; ?> ">
 <?php _e( 'Defaults' ); ?>
 </a><a href="<?php  if(isset($_GET["page"])){ echo admin_url("admin.php")."?page=".$_GET["page"]."&action=examples";}; ?>" class="nav-tab <?php if($_GET["action"]=="examples"){ echo "nav-tab-active";}; ?>">
 <?php _e( 'Examples' ); ?>
 </a>
 </h2>

<?php 
/*-----------------------------------------------------------------------------------------------------//	

	//DEFAULT Tab

-------------------------------------------------------------------------------------------------------*/
if(isset($_GET["action"])){$tabaction=$_GET["action"];}else{$tabaction="default";}; 
if ($tabaction =="default"){
?>

<div id="menu-tab-default" <?php if($tabaction =="default" || ""){ echo 'style="display:inherit;"; class"menu-tab-content-default active"';}else { echo 'style="display:none;" class"menu-tab-content"';} ?> >
<h3><?php _e( 'Query Query Defaults'); ?></h3>

<table class="widefat importers" cellspacing="0">
<form method="post" action="options.php">  
            <?php wp_nonce_field('update-options') ?> 
<thead>
<tr>
<th><?php _e( 'Variable Name' ); ?></th>
<th><?php _e( 'Option Description' ); ?></th>
<th><?php _e( 'Custom Default' ); ?></th>
<th><?php _e( 'Preset Default' ); ?></th>
</tr> 
</thead>
<tbody>
<?php 
foreach ($option_list_names as $option_list_name){
	$evenodd ++;
	//TEXT OPTIONS
	if($option_list_name["type"]=="text"){ 
	$value= "QueryQuery_".$option_list_name["name"];
	?>
	<tr class="<?php if ($evenodd % 2 == 0) {echo "even";}else{echo "alternate odd";} ?>">
    	<td class="queryvariable">&quot;<?php echo $option_list_name["name"] ?>&quot;</td>
        <td class="import-system row-title"><label><?php _e( $option_list_name["title"] );?></label></td>
        <td class="desc"><input type="text" name="<?php echo $value ?>" value="<?php  echo get_option($value); ?>"/></td>
        <td><?php echo $option_list_name["default"] ?> <input type="hidden" name="<?php echo $value.'_default'?>" value="<?php echo $option_list_name["default"] ?>" />  </td>
	</tr>
	<?php
	}
	//SELECT OPTIONS
	if($option_list_name["type"]=="select"){ 
	$value= "QueryQuery_".$option_list_name["name"];
    	?>
	<tr class="<?php if ($evenodd % 2 == 0) {echo "even";}else{echo "alternate odd";}?>">
    	<td class="queryvariable">&quot;<?php echo $option_list_name["name"] ?>&quot;</td>
        <td class="import-system row-title"><label><?php _e( $option_list_name["title"] ); ?></label></td>
        <td class="desc">
    		<select name="<?php echo $value ?>" id="<?php echo $value ?>"><?php
                $options_orderby = explode(',',$option_list_name["options"]) ;
                foreach ($options_orderby as $option_orderby) {
                    $select_orderby= get_option($value);
                    if($select_orderby == $option_orderby){$ami_orderby='selected="selected"';}else{$ami_orderby='';};
                    echo '<option value="' . $option_orderby . '" id="'. $option_orderby .'"'. $ami_orderby.'>'. $option_orderby. '</option>';
             }?></select>
   		</td>
    	<td><?php echo $option_list_name["default"] ?> <input type="hidden" name="<?php echo $value.'_default' ?>" value="<?php echo $option_list_name["default"] ?>" />  </td>
    </tr>
	<?php
	}
	//SELECT MULTI-OPTIONS
	if($option_list_name["type"]=="multi-select"){ 
	$options_orderby="";
	$value= "QueryQuery_".$option_list_name["name"];
    	?>
	<tr class="<?php if ($evenodd % 2 == 0) {echo "even";}else{echo "alternate odd";} ?>">
    	<td class="queryvariable">&quot;<?php echo $option_list_name["name"] ?>&quot;</td>
        <td class="import-system row-title"><label><?php _e( $option_list_name["title"] ); ?></label></td>
        <td class="desc">
    		<select multiple="multiple" name="<?php echo $value.'[]' ?>" id="<?php echo $value ?>"><?php
                $option_list_name["name"] == "categorynumbers" || $option_list_name["name"] == "anticategorynumbers" ? $options_orderby = get_all_category_ids() : $options_orderby =  $option_list_name["options"] ;
				$select_orderby = get_option($value);
                foreach ($options_orderby as $option_orderby) {
					$option_list_name["name"] == "anticategorynumbers" ? $option_orderby_value = "-".$option_orderby: $option_orderby_value = $option_orderby ;
					$selected = in_array($option_orderby_value,$select_orderby) !== false && $select_orderby !== "" ? 'selected="selected"' :" ";
                    echo '<option value="' . $option_orderby_value . '" id="'. $option_orderby .'"'. $selected.'>'. get_cat_name($option_orderby). '</option>';
             }?></select>
             
   		</td>
    	<td><?php echo $option_list_name["default"] ?> <input type="hidden" name="<?php echo $value.'_default' ?>" value="<?php echo $option_list_name["default"] ?>" />  </td>
    </tr>
	<?php
    }
    //SELECT CHECK
	if($option_list_name["type"]=="check"){ 
	$value= "QueryQuery_".$option_list_name["name"];
	?>
	<tr class="<?php if ($evenodd % 2 == 0) {echo "even";}else{echo "alternate odd";}?>">
    	<td class="queryvariable">&quot;<?php echo $option_list_name["name"] ?>&quot;</td>
        <td class="import-system row-title"><label><?php _e( $option_list_name["title"] ); ?></label></td>
        <td class="desc">
		<?
        get_option($value) > 0 ? $checked = 'checked="checked"': $checked = " " ; // get our options array from the db
        ?>
        <input type="checkbox" name="<?php echo $value ?>" id="<?php echo $value ?>" value="1>" <?php echo $checked ?>/>
        </td>
        <td><?php echo $option_list_name["default"] ?> <input type="hidden" name="<?php echo $value.'_default' ?>" value="<?php echo $option_list_name["default"] ?>" />  </td>
    </tr>
    <?php
	}
}
?></tbody><tfoot>
	 <tr><td></td><td></td><td></td><td><input type="submit" name="Submit" value="Store Options" class="button button-primary"/></p>  
            <input type="hidden" name="action" value="update" />  
            <input type="hidden" name="page_options" value="<?php
			foreach ($option_list_names as $option_list_name){
			echo "QueryQuery_".$option_list_name["name"]; $i ++;
			if ($i != count($option_list_names)){echo ",";} 
			}?>" />
      </td></tr>
</form>
</tfoot>
</table>
</div>
<?php } //end default content ?>


<?php 
/*-----------------------------------------------------------------------------------------------------//	

	//EXAMPLE Tab

-------------------------------------------------------------------------------------------------------*/
 include_once('QueryQuery_examples.php');
?>
<div id="menu-tab-examples" <?php if($tabaction =="examples"){ echo 'style="display:inherit;" class"menu-tab-content-examples active"';}else { echo 'style="display:none;"; class"menu-tab-content"';} ?>>
<h3><?php _e( 'Query Query Examples'); ?></h3>
<table class="widefat examples" cellspacing="0">
<thead>
<tr>
<th><?php _e( 'Name' ); ?></th>
<th><?php _e( 'Type' ); ?></th>
<th><?php _e( 'Example' ); ?></th>
<th><?php _e( 'Descrption' ); ?></th>
</tr> 
</thead>
<tbody>
<?php foreach ($example_list_names as $example_list_name){ $evenodd2 ++; ?>
<tr class="<?php if ($evenodd2 % 2 == 0) {echo "even";}else{echo "alternate odd";} ?>">
<td><?php echo $example_list_name["title"]; ?></td>
<td><?php echo $example_list_name["type"]; ?></td>
<td><?php echo $example_list_name["example_text"]; ?></td>
<td rowspan="2"><?php echo $example_list_name["desc"]; ?></td>
</tr>
<tr class="<?php if ($evenodd2 % 2 == 0) {echo "even";}else{echo "alternate odd";} ?>">
<td colspan="3"><?php echo '<img class="queryquery-admin-image" src="'.plugins_url( '/assets/'.$example_list_name["image_name"] , __FILE__ ).'" alt="'.$example_list_name["title"].'"/>'; ?></td>
</tr>
<?php }//end example_lust)names?>
</tbody>
</table>
</div><!-- end of tab-options -->
</div><!-- end of wrap -->

