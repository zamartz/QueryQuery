<?php
/*-----------------------------------------------------------------------------------------------------//	

	Query Query ShortCode		       	     	 

-------------------------------------------------------------------------------------------------------*/

function QueryQuery( $atts, $content = null ) {

ob_start();


//Custome deflaut list and if none set as null
	$option_list_names = array(QueryQuery_poststatus,QueryQuery_postsperpage,QueryQuery_postsoffset,QueryQuery_orderby,QueryQuery_order,QueryQuery_spacer,QueryQuery_clickthroughtext,QueryQuery_clickthroughlink,QueryQuery_monthsafter,QueryQuery_monthsbefore,QueryQuery_poststags,QueryQuery_searchterm,QueryQuery_categorynumbers,QueryQuery_debugmode,showthumbnails);
	foreach ($option_list_names as $option_list_name){
		$defaultname = $option_list_name."_default";
		get_option($option_list_name) !== "" && get_option($option_list_name) !== "default" ? $option_list_names[$option_list_name]["value"] = get_option($option_list_name) : $option_list_names[$option_list_name]["value"] = get_option($defaultname);
		get_option($option_list_name) == "default" ? $option_list_names[$option_list_name]["value"] = get_option($defaultname):"";
		
	}
	
//EXTRACT SHORTCODES and If none repalce with saved option 
    extract(shortcode_atts(array(
		'poststatus' => get_option('QueryQuery_poststatus') !== "" ? get_option('QueryQuery_poststatus') : $option_list_names['QueryQuery_poststatus']["value"],
		
		'postsperpage'	=> get_option('QueryQuery_postsperpage') !== "" ? get_option('QueryQuery_postsperpage') : $option_list_names['QueryQuery_postsperpage']["value"],
		
		'postsoffset' => get_option('QueryQuery_postsoffset') !== "" ? get_option('QueryQuery_postsoffset') : $option_list_names['QueryQuery_postsoffset']["value"],
		
		'orderby'	=> get_option('QueryQuery_orderby') !== "" ? get_option('QueryQuery_orderby') : $option_list_names['QueryQuery_orderby']["value"],
		
		'order'	=> get_option('QueryQuery_order') !== "" ? get_option('QueryQuery_order') : $option_list_names['QueryQuery_order']["value"],
		
		'spacer'=> get_option('QueryQuery_spacer') !== "" ? get_option('QueryQuery_spacer') : $option_list_names['QueryQuery_spacer']["value"],
		
		'clickthroughtext' => get_option('QueryQuery_clickthroughtext') !== "" ? get_option('QueryQuery_clickthroughtext') : $option_list_names['QueryQuery_clickthroughtext']["value"],

		'clickthroughlink' => get_option('QueryQuery_clickthroughlink') !== "" ? get_option('QueryQuery_clickthroughlink') : $option_list_names['QueryQuery_clickthroughlink']["value"],
		
		'monthsafter' => get_option('QueryQuery_monthsafter') !== "" ? get_option('QueryQuery_monthsafter') : $option_list_names['QueryQuery_monthsafter']["value"],

		'monthsbefore' => get_option('QueryQuery_monthsbefore') !== "" ? get_option('QueryQuery_monthsbefore') : $option_list_names['QueryQuery_monthsbefore']["value"],
		
		'poststags' => get_option('QueryQuery_poststags') !== "" ? get_option('QueryQuery_poststags') : $option_list_names['QueryQuery_poststags']["value"],
		
		'searchterm' => get_option('QueryQuery_searchterm') !== "" ? get_option('QueryQuery_searchterm') : $option_list_names['QueryQuery_searchterm']["value"],
		
	    'categorynumbers'=> get_option('QueryQuery_categorynumbers') !== "" ? get_option('QueryQuery_categorynumbers') : $option_list_names['QueryQuery_categorynumbers']["value"],
		'debugmode'=> get_option('QueryQuery_debugmode') !== "" ? get_option('QueryQuery_debugmode') : $option_list_names['QueryQuery_debugmode']["value"],
		'showthumbnails'=> get_option('QueryQuery_showthumbnails') !== "" ? get_option('QueryQuery_showthumbnails') : $option_list_names['QueryQuery_showthumbnails']["value"]
   		 ),
	 $atts));
	
	
	if ($debugmode > 0){ echo "<!-- List Options Set = ".json_encode($option_list_names)."-->";};
	
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

	if ($debugmode > 0){ echo "<!-- Post Query = ".json_encode($args)."-->";};

		$recentEvents = new WP_Query($args);

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
                <a href="<?php the_permalink(); ?>"><h3 class="queryquery-title">
				<?php the_title(); ?>
				</h3></a><p class="queryquerydate">
				<?php
				echo the_time( get_option( 'date_format' ) ). $spacer."</p><p class='queryquery-details'>". get_the_excerpt();?>
				</p></li>
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
			echo '<div class="queryquery-more">No Post(s) to Display</div><!--end .queryquery-more -->';
			}

		  wp_reset_postdata();
		 $out = ob_get_clean();
   return $out;

}

add_shortcode('QueryQuery', 'QueryQuery');

?>