<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $pgTitle;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="<?php echo $arrCfg['web_root'];?>player/jwplayer.min.js"></script>
		<link rel="stylesheet" href="<?php echo $arrCfg['web_root'];?>css/main.css" type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="/live/favicon.ico">
	</head>
	<script type="text/javascript">
		var start = 0; //start point in seconds
		//sniff for a hash
		if(window.location.hash) {
			var hash = window.location.hash;
			hash = hash.substring(1);
			hashParts = hash.split(':');
			if (hashParts.length == 3) {
				start = parseInt(hashParts[0], 0)*60*60 + parseInt(hashParts[1], 0)*60 + parseInt(hashParts[2], 0);
			}
			else if (hashParts.length == 2) {
				start = parseInt(hashParts[0], 0)*60 + parseInt(hashParts[1], 0);
			}
			else {
				start = hash;
			}
		}//END if a has was found
	</script>
	<body>
		<div id="mainContainer">
			<div id="bannerContainer">
				<div id="banner">
					<a href="http://www.libraries.rutgers.edu" target="_blank" title="Rutgers Libraries Home Page"><div style="height: 75px; width: 200px; position: absolute;"></div></a>
					<img src="<?php echo $arrCfg['web_root'];?>img/banner.png" border="0">

<?php
	if (isset($_SESSION, $_SESSION['courses'])) {
		echo "\t\t\t\t\t<div class=\"logout\"><a href=\"" . $arrCfg['web_root']  . "logout/\">Log out</a></div>\n";
	}
?>
				</div>
			</div>
			<?php
			if (isset($arrCfg['show alert'], $arrCfg['alert_message']) && $arrCfg['show alert'] == TRUE) {
				echo "\t\t<div id=\"alertContainer\"><div id=\"alert\">" . $arrCfg['alert_message'] . "</div></div>\n";
			}
			?>
			<div id="contentContainer">
				<div id="content">
