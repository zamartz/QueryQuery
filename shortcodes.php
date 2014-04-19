<?php
/*-----------------------------------------------------------------------------------------------------//	

	Query Query ShortCode		       	     	 

-------------------------------------------------------------------------------------------------------*/

function QueryQuery($atts) {
ob_start();
// load debug value
	$debugmode = get_option("QueryQuery_debugmode");
	
// get QueryQuery Admin Options
	include('QueryQuery_options.php');
	$opt_names = array();
	foreach ($option_list_names as $option_list_name){
		$standard = "QueryQuery_".$option_list_name["name"];
		array_push($opt_names,$standard); 
	}

//Custome deflaut list and if none set as null
	$option_list_names = $opt_names;
	
//Checks Options for overrides and blanks and negotiates
	foreach ($option_list_names as $option_list_name){
		$defval = $option_list_name;
		$defval .= "_default";
		
		if (get_option($option_list_name) !== "" && get_option($option_list_name) !== "default"){  
		$attr_list_names[$option_list_name]["value"] = get_option($option_list_name);
		$attr_list_names[$option_list_name]["name"] = $option_list_name;
		}
		if (get_option($option_list_name) == "default"){ 
		$attr_list_names[$option_list_name]["value"] = get_option($defval);
		$attr_list_names[$option_list_name]["name"] = $option_list_name;
		}
		if (!get_option($option_list_name)){
		$attr_list_names[$option_list_name]["value"] = get_option($defval);
		$attr_list_names[$option_list_name]["name"] = $option_list_name;
		}
	}
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : List Name & Value Set = ".json_encode($attr_list_names)."-->";};
	
//EXTRACT SHORTCODES and If none repalce with saved option 
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : Shortcode Set = -->";}
		foreach ($attr_list_names as $attr_list_name_x){
			$currentname = $attr_list_name_x["name"];
			$thisname = str_replace("QueryQuery_","",$currentname);
			$currentvalue = $attr_list_name_x["value"];
			if ($currentvalue !== ""){
				$short_code_atts[$thisname] = $currentvalue;
			}
		if ($debugmode > 0){ echo "<!-- [ ".$currentname." / ".$thisname." = ".$currentvalue." ] -->"; };
	 }
	if ($debugmode > 0){echo "<!-- END : Shortcode Set -->";};	
	extract($short_code_atts);

	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : List Options Set = ".json_encode($option_list_names)."-->";};
	
	$today = getdate();
	$themonth = $today["mon"];
	$theyear = $today["year"];	

//months forward
	if ($monthsbefore != "null"){
		$goforwardm = $monthsafter;
		$goforwardy = $theyear;
		if ($goforwardm < 12){
			// get remaining months and add to current
			$extramonths = $themonth + $goforwardm;
			//
			if ($extramonths == 12){$goforwardy += 1; $goforwardm = 1;}
			if ($extramonths < 12){$goforwardm = $extramonths;}
		}
		//divide into years and remaining months forward
		if ($goforwardm > 12){
			//finds number of years
			$yforward = floor($goforwardm / 12);
			//finds remaining months
			$rmforward = $goforwardm - ($yforward * 12);
			//go forward in years
			$goforwardy += $yforward;
			// get remaining months and add to current
			$extramonths = $themonth + $rmforward;
			if($extramonths > 12){$goforwardy +=1; $goforwardm = $extramonths - (12-$themonth);}
			if ($extramonths < 12){$goforwardm = $extramonths;}
			if ($extramonths == 12 || $goforwardm == 12){$goforwardy += 1; $goforwardm = $themonth;}
		}
		
	}else{$goforwardm =""; $goforwardy = $theyear;}//end months before
	
//months after
	if ($monthsafter != "null"){
		$gobackwardm = $monthsbefore;
		$gobackwardy = $theyear;
		if ($gobackwardm > 12){
			$ybackward = floor($gobackwardm / 12);
			//finds remaining months
			$rmbackward = $gobackwardm - ($ybackward * 12);
			// go back in years
			$gobackwardy -= $ybackward;
			$gobackwardm = $rmbackward;
		}
	
		if ($gobackwardm < 12){
			//check to see if months back drops into last year
			if ($themonth - $gobackwardm < 0){
				$gobackwardy -= 1;
				$gobackwardm = 12 - ($gobackwardm - $themonth);
			}
			//check to see if month drops back to last year
			if ($themonth - $gobackwardm == 0){
				$gobackwardy -= 1;
				$gobackwardm = 12;
			}
			if ($themonth - $gobackwardm > 0){
				$gobackwardm = $themonth - $gobackwardm;
			}
		}
	}else{$gobackwardm = ""; $gobackwardy = $theyear;}//end months after
	if ($debugmode > 0){ echo ("<!--(".$monthsbefore."/m Backward) After= YEAR:".$gobackwardy." MONTH:".$gobackwardm."~ (".$monthsafter."/m Forward) Before=YEAR:". $goforwardy." MONTH:".$goforwardm."-->");};
		
//Default Post Arguments to pass
		$args = array(

		'post_type' => 'post',

		'posts_per_page' => $postsperpage,

		'post_status' => $poststatus,
		
		);
		
//Negotiates Categories
		count($anticategorynumbers) > 0 && is_array($anticategorynumbers) ? $anticategorynumbers = implode(",",$anticategorynumbers) : "";
		count($categorynumbers) > 0 && is_array($categorynumbers) ? $categorynumbers = implode(",",$categorynumbers) : "";
		// remove if null and if both combind with seperator
		$anticategorynumbers == "null" ? $anticategorynumbers = "" : "";
		$categorynumbers == "null" ? $categorynumbers = "":"";
		$anticategorynumbers !==  "null" && $anticategorynumbers !== "" ? $catjoiner ="," : "";
		//create final list
		$finalcatlist = $anticategorynumbers.$catjoiner.$categorynumbers;
		//send final list to arguments
		$finalcatlist !== "" ? $args['cat'] = $finalcatlist : "";
		
		// debug category negotiation 
		if ($debugmode > 0){ echo "<!-- QueryQueryDebug : Normal Cat Numbers = ".$categorynumbers."-->";};
		if ($debugmode > 0){ echo "<!-- QueryQueryDebug :Anti Cat Numbers = ".$anticategorynumbers."-->";};
		if ($debugmode > 0){ echo "<!-- QueryQueryDebug : Final Cat Numbers = ".json_encode($finalcatlist)."-->";};
		
//Default Sort Arguments to pass
		$order !== "null" ? $args['order'] = $order : "";
		$orderby !== "null" ? $args['orderby'] = $orderby : "";
		$tag !== "null" ?$args['tag'] = $tag:  "";
		$s !== "null" ? $args['s'] = $s : "";
		
		$monthsafter !== "null" || $monthsbefore !== "null" ?
		$args['date_query'] = array(
				'after'     => array(
					'year'  => $gobackwardy,
					'month' => $gobackwardm,
					),
				'before'    => array(
					'year'  => $goforwardy,
					'month' => $goforwardm,
					),
				'inclusive' => true,
		  ) : "";
	
// List of Negotiated Default Options
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : Post Query = ".json_encode($args)."-->";};

// List of Shortcode entered Attributes
	extract(shortcode_atts(array($args), $atts),'QueryQuery');
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : List Shortcode Atts = ".json_encode($atts)."-->";};

// Final List of Merged Shortcode & Default Attributes
	$atts ? $finalAtts = array_merge($args,$atts) : $finalAtts = $args ;
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : List Merged Atts = ".json_encode($finalAtts)."-->";};
	
//create query url to view all
	if ($disablequeryurl <= 0 ){ 
	  $queryurl = get_site_url()."?"."post_type=post&post_status=".$poststatus;
	  $finalAtts['cat'] && $finalAtts['cat'] !=="null" ? $queryurl .= "&cat=".$finalAtts['cat']: "";
	  $finalAtts['order'] !=="null" ? $queryurl .= "&order=".$finalAtts['order'] : "";
	  $finalAtts['orderby'] !=="null" ? $queryurl .= "&orderby=".$finalAtts['orderby'] : "";
	  $finalAtts['tag'] && $finalAtts['tag'] !=="null" ? $queryurl .= "&tag=".$finalAtts['tag'] : "";
	  $finalAtts['s'] && $finalAtts['s']  !=="null" ? $queryurl .= "&s=".$finalAtts['s']  : "";
	  // if no custome clickthrough url use created one
	  if ($clickthroughlink == "null" ){$clickthroughlink = $queryurl;}
	};

//Start to do the Query and Show Content
	$recentEvents = new WP_Query($finalAtts);
	$showonlyonpost > 0 && !is_single() ? $showqueryhere = 1 : $showqueryhere = 0 ; 
	// if none query attribute override extract them here to overrite data
	extract($finalAtts);
	
	if ( $recentEvents->have_posts() && $showqueryhere  <= 0 ) { ?>
    <div class="queryquery-container">
		<?php if ($disabledisplaytitle <= 0 ){echo '<h2 class="queryquery-head-title">'.$displaytitle.'</h2>';}?>
		<ul><?php

		while ( $recentEvents->have_posts() ) : $recentEvents->the_post();?>
			<li class="queryquery-item">
		<?php if ($disablethumbnails <= 0 ){ 
					if ( has_post_thumbnail() ) {
					the_post_thumbnail('thumbnail', array('class' => 'queryquery-tumbnail'));
					} elseif ($disabledefautlthumb <= 0 ){
					echo '<img class="queryquery-tumbnail" src="' . plugins_url( '/thumbnail-default.png' , __FILE__ ) .'"/>';
					} 
				}
				?>
			<h3 class="queryquery-title"><a class="queryquery-link" href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
			</a></h3> 
			<?php if($disabledate <= 0){ ?> 
					<p class="queryquery-date"> <?php echo the_time(get_option( 'date_format' ));
					if($disablespacer <= 0){ echo '<span class="QueryQuery-spacer">'.$spacer.'</span>'; }
					echo '</p>';
					} 
					if ( get_the_excerpt() && $disableexcerpt <= 0 ){
						echo "<p class='queryquery-details'>". get_the_excerpt()."</p>";
					}?>
			</li>
			<?php
		endwhile;

		if ($clickthroughlink !=="null"){
			echo'<div class="queryquery-more"><a href="'.$clickthroughlink.'">';
			if ($clickthroughtext !=="null"){
				echo $clickthroughtext;
				}else{
				echo '(Click to View More)';
				}
			echo'</a></div><!--end .queryquery-more -->';
		}
		?></ul></div><!-- end .queryquery --><?php
	}else{
		// if no post tell them
		if ($disablenoposttext <= 0 ){
			 echo '<div class="queryquery-more">'.$noposttext.'</div><!--end .queryquery-more -->' ;}
	}
	  wp_reset_postdata();
	  return ob_get_clean();
	  ob_flush();
}// end query query shortcode

add_shortcode('QueryQuery', 'QueryQuery');

?>