<?php
/**
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2019, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
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

$parser_data['is_root']	= CAT_Users::is_root();

$parser_data['fakeIMG']	= CAT_Helper_Page::getInstance()->db()->query(
					"SELECT `image_id` FROM `:prefix:mod_cc_catgallery_images` " .
						"WHERE `picture` = '__fakeImage__'AND gallery_id = :galID",
				array(
					'galID'	=> $catGallery->getID()
				)
			)->fetchColumn();

$parser_data['content']	= stripslashes( CAT_Helper_Page::getInstance()->db()->query(
					'SELECT `content` ' . 
						'FROM `:prefix:mod_cc_catgallery_contents` ' .
						'WHERE image_id = :fakeIMG',
				array(
					'fakeIMG'	=> $parser_data['fakeIMG']
				)
			)->fetchColumn() );

# Remove fake image from parser_data to hide it from backend/frontend
unset($parser_data['images'][$parser_data['fakeIMG']]);

?>
