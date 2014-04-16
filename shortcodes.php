<?php
/*-----------------------------------------------------------------------------------------------------//	

	Query Query ShortCode		       	     	 

-------------------------------------------------------------------------------------------------------*/

function QueryQuery( $atts, $content = null ) {

ob_start();


//Custome deflaut list and if none set as null
	$option_list_names = array(QueryQuery_poststatus,QueryQuery_postsperpage,QueryQuery_postsoffset,QueryQuery_orderby,QueryQuery_order,QueryQuery_spacer,QueryQuery_clickthroughtext,QueryQuery_clickthroughlink,QueryQuery_monthsafter,QueryQuery_monthsbefore,QueryQuery_poststags,QueryQuery_searchterm,QueryQuery_categorynumbers,QueryQuery_debugmode,QueryQuery_showthumbnails,QueryQuery_disablequeryurl);
	
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
if ($debugmode > 0){ echo "<!-- QueryQueryDebug : Shortcode Set = ";}
	foreach ($attr_list_names as $attr_list_name_x){
		$currentname = $attr_list_name_x["name"];
		$thisname = str_replace("QueryQuery_","",$currentname);
		$currentvalue = $attr_list_name_x["value"];
		if ($currentvalue !== ""){
			$short_code_atts[$thisname] = $currentvalue;
		}
		if ($debugmode > 0){ echo "[ ".$currentname." / ".$thisname." = ".$currentvalue." ] <br>"; };
	}
	if ($debugmode > 0){echo " -->";};
	
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

		$args = array(

		'post_type' => 'post',

		'posts_per_page' => $postsperpage,

		'post_status' => $poststatus,
		
		);
		
		$categorynumbers !== "null" ? $args['cat'] = implode(",",$categorynumbers) : "";
		$order !== "null" ? $args['order'] = $order : "";
		$orderby !== "null" ? $args['orderby'] = $orderby : "";
		$poststags !== "null" ?$args['poststags'] = $poststags : "";
		$searchterm !== "null" ? $args['s'] = $searchterm : "";
		
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
	$finalAtts = array_merge($args,$atts);
	if ($debugmode > 0){ echo "<!-- QueryQueryDebug : List Merged Atts = ".json_encode($finalAtts).$finalAtts['cat']."-->";};
	
	 //create query url to view all
		  if ($disablequeryurl !=="1"){ 
		  $queryurl = get_site_url()."?"."post_type=post&post_status=".$poststatus;
		  $finalAtts['cat'] !=="null" ? $queryurl .= "&cat=".$finalAtts['cat']: "";
		  $order !=="null" ? $queryurl .= "&order=".$order : "";
		  $orderby !=="null" ? $queryurl .= "&orderby=".$orderby : "";
		  $poststags !=="null" ? $queryurl .= "&tag=".$poststags : "";
		  $searchterm !=="null" ? $queryurl .= "&s=".$searchterm : "";
		  };
	
		$recentEvents = new WP_Query($finalAtts);

		if ( $recentEvents->have_posts() ) {
			?><div class="queryquery-container"><ul><?php

			while ( $recentEvents->have_posts() ) : $recentEvents->the_post();?>
				<li class="queryquery-item">
                <?php if ($showthumbnails > 0 ){ if ( has_post_thumbnail() ) {
						the_post_thumbnail('thumbnail', array('class' => 'queryquery-tumbnail'));
					}
					else {
						echo '<img src="' . get_bloginfo('stylesheet_directory') . '/images/thumbnail-default.jpg" class="queryquery-thumbnail />';
					} }?>
                <h3 class="queryquery-title"><a class="queryquery-link" href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
				</a></h3><p class="queryquery-date">
				<?php
				echo the_time( get_option( 'date_format' ) ).'<span class="QueryQuery-spacer">'.$spacer.'</span>';
				if (get_the_excerpt()){echo "</p><p class='queryquery-details'>". get_the_excerpt()."</p>";}?>
				</li>
				<?php
			endwhile;

			if ($clickthroughlink !=="null"){
				$disablequeryurl !== "1" ? $clickthroughlink = $queryurl :"";
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
			echo '<div class="queryquery-more">No Post(s) to Display</div><!--end .queryquery-more -->';
			}

		  wp_reset_postdata();
		 $out = ob_get_clean();
   return $out;

}

add_shortcode('QueryQuery', 'QueryQuery');

?>