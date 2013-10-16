<?php

/**
 *	Filename: config.php
 * 	Date: 11/30/2012
 *	Purpose: Configuration file for audio/video content management script
 *
 * @version $Id$
 * @copyright 2012
 */


ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL | E_STRICT);

$arrCfg = array();

//Absolute filesystem location for reserves
$arrCfg['wowza_content_directory'] = "/usr/local/WowzaMediaServer/content/vod/";
//wowza server address and port and content directory
$arrCfg['wowza_server'] = "rtmpe://dev-stream.libraries.rutgers.edu:1935/vod";

//base web directory for content
$arrCfg['web_root'] = "/vod/";

//array of valid media file extensions to support
$arrCfg['extensions'] = array(".mp4", ".mp3", ".avi", ".mov", ".url");

//location of passcode file
#$arrCfg['passcode_file'] = "/srv/www/htdocs/reserves/incs/passcode.txt";
#$arrCfg['passcode_file'] = "/home/avbijur/passcode.txt";

//show alert
$arrCfg['show alert'] = FALSE;
//alert mesage
$arrCfg['alert_message'] = "This is the test streaming media server";

?>
