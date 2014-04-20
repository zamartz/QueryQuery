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
			"type" => "shortcode",
			"example_text" =>"&#091;QueryQuery disablethumbnails=&quot;1&quot;&#093; ",
			"image_name" => "standard-no-image.png",
			"desc" =>"This is the standard view with the featured images disabled. This will disable both applied and fallback thumbnail imaged"
			),
			array(
			"title" => "Disable Date",
			"type" => "shortcode",
			"example_text" =>"&#091;QueryQuery disablethumbnails=&quot;1&quot; disabledate=&quot;1&quot;&#093; ",
			"image_name" => "standard-no-image-date.png",
			"desc" =>"This is the standard view with no image and no date shown."
			),
			array(
			"title" => "Disable Excerpts",
			"type" => "shortcode",
			"example_text" =>"&#091;QueryQuery disablethumbnails=&quot;1&quot; disabledate=&quot;1&quot; disableexcerpt=&quot;1&quot; &#093; ",
			"image_name" => "standard-no-image-date-exerpt.png",
			"desc" =>"This is the standard view with no image, no date shown, and no excerpt."
			),
			array(
			"title" => "Default Admin Tab",
			"type" => "admin",
			"example_text" =>"N/A",
			"image_name" => "admin-default.png",
			"desc" =>"<p>All &#091;QueryQuery&#093; shortcodes have defaults set on install.</p><p> Those defaults can be seen in the last column within the table under the &quot;Default&quot; tab.</p><p> Each of these Default values can be overridden with corrisponding admin values.</p><p> These defaults or override values function as &quot;Global&quot; when using &#091;QueryQuery&#093; shortcode.</p><p> Any shortcode variables you place within a &#091;QueryQuery&#093; shortcode override admin values for that specific instance of the &#091;QueryQuery&#093; shortcode tag.</p><p> Avalible shortcode values for &#091;QueryQuery&#093; shortcode are listed with the correct spelling on this same &quot;Default&quot; tab page. </p>"
			)
		);
?>

