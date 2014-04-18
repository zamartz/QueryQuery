<?php
// Admin Options Avalible on Query Query

$option_list_names = array(
		array(
			"name" => "poststatus",
			"type" => "select",
			"title" => "Post by Status",
			"default" => "publish",
			"options" =>"publish,pending,draft,auto-draft,future,private,inherit,trash,any"
			),
		array(
			"name" => "postsperpage",
			"type" => "text",
			"title" => "Posts Per/Page",
			"default" => "1"
			),
		array(
			"name" => "offset",
			"type" => "text",
			"title" => "Offset by ? Number of Posts",
			"default" => "null"
			),
		array(
			"name" => "orderby",
			"type" => "select",
			"title" => "Order Post By",
			"default" => "date",
			"options" => "none,ID,author,title,name,date,modified,parent,rand,comment_count,menu_order,meta_vlaue,meta_value_num,post__in"
			),
		array(
			"name" => "order",
			"type" => "select",
			"title" => "Arrange List by",
			"default" => "DESC",
			"options" => "DESC,ASC"
			),
		array(
			"name" => "spacer",
			"type" => "text",
			"title" => "Spacer Character",
			"default" => " - ",
			),
		array(
			"name" => "displaytitle",
			"type" => "text",
			"title" => "Display Title",
			"default" => "More post you will like",
			),
		array(
			"name" => "noposttext",
			"type" => "text",
			"title" => "No Post Text",
			"default" => "No Post(s) to Display",
			),
		array(
			"name" => "clickthroughtext",
			"type" => "text",
			"title" => "Clickthrough Text",
			"default" => "Read More",
			),
		array(
			"name" => "clickthroughlink",
			"type" => "text",
			"title" => "Clickthrough Link",
			"default" => "null",
			),
		array(
			"name" => "monthsafter",
			"type" => "text",
			"title" => "Limit Post ? Months After",
			"default" => "null",
			),
		array(
			"name" => "monthsbefore",
			"type" => "text",
			"title" => "Limit Post ? Months Before",
			"default" => "null",
			),
		array(
			"name" => "tag",
			"type" => "text",
			"title" => "Show Post with Tag-slug(s)",
			"default" => "null"
			),
		array(
			"name" => "s",
			"type" => "text",
			"title" => "Show Post with Search term(s)",
			"default" => "null"
			),
		 array(
			"name" => "categorynumbers",
			"type" => "multi-select",
			"title" => "Show Posts with Category <br> (Ctrl/cmd click to selet multiple)",
			"default" => "null"
			),
		array(
			"name" => "anticategorynumbers",
			"type" => "multi-select",
			"title" => "Exclude Post with Category <br> (Ctrl/cmd click to selet multiple)",
			"default" => "null"
			),
		 array(
			"name" => "disableshowonlyonpost",
			"type" => "check",
			"title" => "Show only within Sigle-Post <br> (not in query lists or pages)",
			"default" => "0"
			),
		array(
			"name" => "disabledisplaytitle",
			"type" => "check",
			"title" => "Disable Display Title",
			"default" => "0"
			),
		 array(
			"name" => "disablethumbnails",
			"type" => "check",
			"title" => "Disable Thumbnails",
			"default" => "0"
			),
		array(
			"name" => "disabledefautlthumb",
			"type" => "check",
			"title" => "Disable Thumbnail Default Image",
			"default" => "0"
			),
		 array(
			"name" => "disablequeryurl",
			"type" => "check",
			"title" => "Disable Auto Query &quot;Read More&quot; URL",
			"default" => "0"
			),
		array(
			"name" => "disabledate",
			"type" => "check",
			"title" => "Disable Date",
			"default" => "0"
			),
		array(
			"name" => "disableexcerpt",
			"type" => "check",
			"title" => "Disable Excerpt",
			"default" => "0"
			),
		array(
			"name" => "disablespacer",
			"type" => "check",
			"title" => "Disable Spacer",
			"default" => "0"
			),
		array(
			"name" => "disablenoposttext",
			"type" => "check",
			"title" => "Disable No Post Text",
			"default" => "0"
			),
		array(
			"name" => "debugmode",
			"type" => "check",
			"title" => "Run Front-End Debug Mode",
			"default" => "0"
			)				
		);

?>