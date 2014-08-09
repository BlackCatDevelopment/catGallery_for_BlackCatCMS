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
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
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

if(defined('CAT_URL'))
{
	// Create table for galleries
	$database->query('DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'mod_cc_cat_gallery`');
	$mod_slider = 'CREATE TABLE  `' . TABLE_PREFIX . 'mod_cc_cat_gallery` ('
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `position` INT NOT NULL DEFAULT \'0\','
		. ' `effect` TEXT NOT NULL,'
		. ' `resize_x` SMALLINT NOT NULL DEFAULT \'0\','
		. ' `resize_y` SMALLINT NOT NULL DEFAULT \'0\','
		. ' `animSpeed` MEDIUMINT(9) NOT NULL DEFAULT \'0\','
		. ' `pauseTime` MEDIUMINT(9) NOT NULL DEFAULT \'0\','
		. ' `opacity` VARCHAR(3) NOT NULL DEFAULT \'1\','
		. ' `random` TINYINT(1) NOT NULL DEFAULT \'0\','
		. ' `variant` TINYINT(1) NOT NULL DEFAULT \'0\','
		. ' PRIMARY KEY ( `section_id` )'
		. ' )';
	$database->query( $mod_slider );

	// Create table for single pictures
	$database->query("DROP TABLE IF EXISTS `" . TABLE_PREFIX . "mod_cc_cat_gallery_images`");
	$mod_slider = 'CREATE TABLE  `' . TABLE_PREFIX . 'mod_cc_cat_gallery_images` ('
		 . '`image_id` INT NOT NULL AUTO_INCREMENT,'
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `picture` VARCHAR(256) NOT NULL DEFAULT \'0\','
		. ' `alt` VARCHAR(256) NOT NULL,'
		. ' `page_link` INT NOT NULL,'
		. ' `image_content` TEXT NOT NULL,'
		. ' PRIMARY KEY ( `image_id` )'
		. ' )';
	$database->query( $mod_slider );
	// add files to class_secure
	$addons_helper = new CAT_Helper_Addons();
	foreach(
		array(
			'save.php'
		)
		as $file
	) {
		if ( false === $addons_helper->sec_register_file( 'cc_cat_gallery', $file ) )
		{
			 error_log( "Unable to register file -$file-!" );
		}
	}
}

?>