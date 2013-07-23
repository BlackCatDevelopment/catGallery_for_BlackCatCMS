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

global $section_id, $page_id;

// Insert an extra row into the database
CAT_Helper_Page::getInstance()->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_cc_header_slider
		(page_id, section_id, effect, animSpeed, pauseTime, resize_x, resize_y, opacity) VALUES
		('$page_id', '$section_id', 'random', '500', '4000', '781','350','0.8')");

$folder		= CAT_PATH . MEDIA_DIRECTORY . '/cc_header_slider/cc_header_slider_' . $section_id;

CAT_Helper_Directory::createDirectory( $folder, NULL, true );

?>