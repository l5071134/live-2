<?php

/**
 *	Filename: index.php
 * 	Date: 11/30/2012
 *	Purpose: Content management for the audio/video reserves
 *
 * @version $Id$
 * @copyright 2012
 */

session_start();

//include configuration
require 'incs/config.php';
//sniff for https
$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https://" : "http://";
$errMsg = "";//init
$output = "";//init
$pgTitle = "Commercial Media";//init

//read in parameters, if any
if (isset($_GET['param1']) && !empty($_GET['param1'])) {
	//clean param1
	$p1 = str_replace("/", "", $_GET['param1']);
	//test that file exists
	if (file_exists($arrCfg['wowza_content_directory'] . $p1)) {
		//form title
		$pgTitle = printTitle($arrCfg['wowza_content_directory'], $p1, TRUE);
		//breadcrumbs
		$bCrumb = "&lt;&lt; <a href=\"" . $http . $_SERVER['HTTP_HOST'] . $arrCfg['web_root'] . "\">Home</a> ";
		$parentDir = printTitle($arrCfg['wowza_content_directory'], $p1, TRUE);
		$bCrumb .= "&nbsp;&nbsp;&lt;&lt; <a href=\"" . $http . $_SERVER['HTTP_HOST'] . $arrCfg['web_root'] . $p1 . "/\">" . $parentDir . "</a>";

		//is it a video or mp3 file?
		$fParts = explode(".", $p1);
		if (strtolower(end($fParts)) == "mp3" || strtolower(end($fParts)) == "mp4" || strtolower(end($fParts)) == "avi" || strtolower(end($fParts)) == "mov") {
			//form output
			$jw = "\tjwplayer('media').setup({\n";
			$jw .= "\t\t\t\t\t\t\tflashplayer: '" . $arrCfg['web_root'] . "player/jwplayer.swf',\n";
			$jw .= "\t\t\t\t\t\t\tplugins: {'timeslidertooltipplugin-3':{'displayhours':true}},\n";
			$jw .= "\t\t\t\t\t\t\tstreamer:'" . $arrCfg['wowza_server'] . "',\n";
			$jw .= "\t\t\t\t\t\t\tfile: 'commercial/" . $p1 . "',\n";
			$jw .= "\t\t\t\t\t\t\tstart: start,\n";

			if (strtolower(end($fParts)) == "mp3") {
				$jw .= "\t\t\t\t\t\t\theight: 24,\n";
				$jw .= "\t\t\t\t\t\t\twidth: 800,\n";
				$jw .= "\t\t\t\t\t\t\t'controlbar': 'bottom'\n";
			}//END if an mp3
			else {
				$jw .= "\t\t\t\t\t\t\theight: 450,\n";
				$jw .= "\t\t\t\t\t\t\twidth: 800,\n";
			}//END if an MP4 or AVI file
			$jw .= "\t\t\t\t\t\t});\n";
		}//END fi a media file
		unset($fParts);
		//description
		$desc = printDescription($arrCfg['wowza_content_directory'], $p1);
		if ($desc != FALSE) {
			$output .= "\t\t\t\t\t<div class=\"desc detail\">" . $desc . "</div>\n";
		}
	}
	else {
		$errMsg = "Your request could not be fulfilled.";
	}
}//END if parameters were passed
else {//print base level directories
	$arrSubDir = scandir($arrCfg['wowza_content_directory']);
	$output .= "<ul>\n";
	$output .= printDirectory ($http . $_SERVER['HTTP_HOST'] . $arrCfg['web_root'], $arrCfg['wowza_content_directory'], $arrSubDir, 300, TRUE, FALSE);
	$output .= "<ul>\n";
}

//get header
require 'incs/header.php';

//style bread crumbs
if (isset($bCrumb)) {
	//echo "\t\t\t\t\t<div class=\"bCrumb\">" . $bCrumb . "</div>\n";
}

//print title
echo "\t\t\t\t\t<h1>" . $pgTitle . "</h1>\n";

//print error message
if (isset($errMsg) && !empty($errMsg)) {
	echo "\t\t\t\t\t<div id=\"error\">" . $errMsg . "</div>\n";
}
if (isset($jw) && !empty($jw)) {
	echo "\t\t\t\t\t<div id=\"mediaWrapper\" align=\"center\"><div id=\"media\"></div></div>\n";
	echo "\t\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t" . $jw . "\t\t\t\t\t</script>\n";
}
if (isset($output) && !empty($output)) {
	echo $output;
}
if (!isset($_GET['param1']) && !isset($_GET['param2']) && !isset($_GET['param3'])) {
}

//get footer
require 'incs/footer.php';

//FUNCTIONS
function printTitle($parentDir, $matchOn, $pretty = TRUE){
	//look in parent directory for a text file
	if (file_exists($parentDir . $matchOn . ".txt")) {
		$fContents = @file($parentDir . $matchOn . ".txt");
		$pgTitle = $fContents[0];
		unset($fContents);
	}//END if a text file
	elseif ($pretty == TRUE) {
		$parts = explode("_" , $matchOn);
		//$parts = array_reverse($parts);
		$pgTitle = "";
		foreach ($parts as $nPart) {
			$pgTitle .= ucfirst($nPart) . " ";
		}
		unset($parts, $nPart);
	}//END else no text file
	else {
		$pgTitle = $matchOn;
	}
	return $pgTitle;
}//END function printTitle

function printDescription($parentDir, $matchOn){
	if (file_exists($parentDir . $matchOn . ".txt")) {
		$fContents = @file($parentDir . $matchOn . ".txt");
		unset($fContents[0]);
		if (count($fContents) > 0) {
			$tmp = "";
			foreach($fContents as $content){
				$tmp .= nl2br(htmlspecialchars($content));
			}//END foreach line
			return $tmp;
		}
		unset($fContents);
	}//END if a text file
	return FALSE;
}//END function print description

function printDirectory($baseURI, $intDir, $contents, $short, $trailingSlash = TRUE, $directoriesOnly){
	$output = "";//init

	//remove . and .. from array
	$arrRemove = array(".", "..");
	$contents = array_diff($contents, $arrRemove);

	//loop through array and map in extra information if found
	$arrFileInfo = array();
	foreach ($contents as $file) {
		//sniff of text files
		if (strtolower(substr($file, -4)) == ".txt") {
			$fContents = @file($intDir . $file);
			$arrFileInfo[substr($file, 0, -4)]['title'] = $fContents[0];
			unset($fContents[0]);//remove title
			if (count($arrFileInfo) > 0) {
				$tmp = "";
				foreach($fContents as $content){
					$tmp .= nl2br(htmlspecialchars($content));
				}//END foreach line
				//shorten if configured
				if ($short != 0) {
					$chunked = wordwrap($tmp, $short, "||||", FALSE);
					$chunkedPieces = explode ("||||", $chunked);
					if ($chunkedPieces[0] != $tmp) {
						$tmp = $chunkedPieces[0] . "...";
					}
					unset($chuncked, $chunkedPieces);
				}
				$arrFileInfo[substr($file, 0, -4)]['desc'] = "<div class=\"item desc\">" . $tmp . "</div>\n";
				unset($content, $tmp);
			}//END if descriptive information was stored
		}//END if a txt file was found
	}//END foreach file
	unset($file);

	//print out listing
	reset($contents);
	foreach ($contents as $file) {
		//test if a directory
		$passDir = ($directoriesOnly == TRUE && !is_dir($intDir . $file)) ? FALSE : TRUE;
		//sniff of everything but text files
		if (strtolower(substr($file, -4)) != ".txt" && $passDir == TRUE) {
			$slash = $trailingSlash == TRUE ? "/" : "";
			$output .= "\t<li>\n\t\t<span class=\"item title\"><a href=\"" . $baseURI . $file . $slash. "\">";
			if (isset($arrFileInfo[$file], $arrFileInfo[$file]['title'])) {
				$output .= htmlspecialchars($arrFileInfo[$file]['title']);
			}
			else {
				$output .= htmlspecialchars($file);
			}
			$output .= "</a></span>\n";
			if (isset($arrFileInfo[$file], $arrFileInfo[$file]['desc'])) {
				$output .= $arrFileInfo[$file]['desc'];
			}
			$output .= "\t</li>\n";
		}//END if not a text file
	}//END foreach file
	unset($file);
	return $output;
}//END function printDirectory


?>
