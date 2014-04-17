<?php
// Admin Examples on Query Query

$example_list_names = array(
		array(
			"title" => "Standard QueryQuery",
			"type" => "shortcode",
			"example_text" =>"&#091;QueryQuery&#093;",
			"image_name" => "standard.png",
			"desc" =>"This does the standard format that is shown when the basic shortcode is used. If there is no featured image applied to show a thumbnail a default thumbnail is applied."
			),
			array(
			"title" => "Disable Featured Thumbnail",
			"type" => "default",
			"example_text" =>"&#091;QueryQuery disablethumbnails=&quot;1&quot;&#093; ",
			"image_name" => "standard-no-image.png",
			"desc" =>"This is the standard view with the featured images disabled. This will disable both applied and fallback thumbnail imaged"
			)
		);
?>