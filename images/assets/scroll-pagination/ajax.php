<?php

mysql_connect('localhost', 'root', '') or die();
mysql_select_db('dams_master');

$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die();


//$run = mysql_query("SELECT * FROM wp_posts WHERE post_status = 'publish' AND post_type ='post' ORDER BY id DESC LIMIT ".$postnumbers." OFFSET ".$offset);
$run = mysql_query("SELECT * FROM package_client ORDER BY id DESC LIMIT ".$postnumbers." OFFSET ".$offset);

while($row = mysql_fetch_array($run)) {
	
	$content = substr(strip_tags($row['hosting']), 0, 500);
	
	echo '<h1><a href="'.$row['id'].'">'.$row['domain'].'</a></h1><hr />';
	echo '<p>'.$content.'...</p><hr />';

}

?>