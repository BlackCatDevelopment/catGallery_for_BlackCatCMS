<?php
/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_header_slider
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

// Delete record from the database
$header_slider_id	= CAT_Helper_Page::getInstance()->db()->get_one("SELECT header_slider_id FROM " . CAT_TABLE_PREFIX . "mod_cc_header_slider WHERE section_id = '$section_id'");

CAT_Helper_Page::getInstance()->db()->query("DELETE FROM " . CAT_TABLE_PREFIX . "mod_cc_header_slider WHERE section_id = '$section_id'");
CAT_Helper_Page::getInstance()->db()->query("DELETE FROM " . CAT_TABLE_PREFIX . "mod_cc_header_slider_images WHERE header_slider_id = '$header_slider_id'");

// Set path to folder
$folder		= CAT_PATH . MEDIA_DIRECTORY . '/cc_header_slider/cc_header_slider_' . $section_id;

// Delete folder
CAT_Helper_Directory::removeDirectory( $folder );

?>