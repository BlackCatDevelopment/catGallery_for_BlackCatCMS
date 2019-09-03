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

if(defined('CAT_URL'))
{
	// Delete all tables if exists
#	CAT_Helper_Page::getInstance()->db()->query(
#		'DROP TABLE IF EXISTS'
#			. ' `:prefix:mod_cc_catgallery_options`,'
#			. ' `:prefix:mod_cc_catgallery_images_options`,'
#			. ' `:prefix:mod_cc_catgallery_contents`,'
#			. ' `:prefix:mod_cc_catgallery_images`,'
#			. ' `:prefix:mod_cc_catgallery`;'
#	);

	// CREATE TABLE IF NOT EXISTS for basic informations
	CAT_Helper_Page::getInstance()->db()->query(
		'CREATE TABLE IF NOT EXISTS `:prefix:mod_cc_catgallery`  ('
			. ' `gallery_id` INT NOT NULL AUTO_INCREMENT,'
			. ' `page_id` INT,'
			. ' `section_id` INT,'
			. ' PRIMARY KEY ( `gallery_id` ),'
			. ' CONSTRAINT `:prefix:cG_pages` FOREIGN KEY (`page_id`) REFERENCES `:prefix:pages`(`page_id`) ON DELETE CASCADE,'
			. ' CONSTRAINT `:prefix:cG_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE'
		. ' ) ENGINE=InnoDB'
	);

	// CREATE TABLE IF NOT EXISTS for options
	CAT_Helper_Page::getInstance()->db()->query(
		'CREATE TABLE IF NOT EXISTS `:prefix:mod_cc_catgallery_options`  ('
			. ' `gallery_id` INT NOT NULL DEFAULT 0,'
			. ' `name` VARCHAR(127) NOT NULL DEFAULT \'\','
			. ' `value` TEXT NOT NULL,'
			. ' PRIMARY KEY ( `gallery_id`, `name` ),'
			. ' CONSTRAINT `:prefix:cG_Options` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE'
		. ' ) ENGINE=InnoDB'
	);

	// CREATE TABLE IF NOT EXISTS for single pictures
	CAT_Helper_Page::getInstance()->db()->query(
		'CREATE TABLE IF NOT EXISTS `:prefix:mod_cc_catgallery_images`  ('
			. ' `image_id` INT NOT NULL AUTO_INCREMENT,'
			. ' `gallery_id` INT NULL DEFAULT NULL,'
			. ' `picture` VARCHAR(127) NOT NULL DEFAULT \'\','
			. ' `published` TINYINT(1) NOT NULL DEFAULT 0,'
			. ' `position` INT NOT NULL,'
			. ' PRIMARY KEY ( `image_id` ),'
			. ' CONSTRAINT `:prefix:cG_Images` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE'
		. ' ) ENGINE=InnoDB'
	);

	// CREATE TABLE IF NOT EXISTS for image options
	CAT_Helper_Page::getInstance()->db()->query(
		'CREATE TABLE IF NOT EXISTS `:prefix:mod_cc_catgallery_images_options`  ('
			. ' `image_id` INT NOT NULL DEFAULT 0,'
			. ' `gallery_id` INT NULL DEFAULT NULL,'
			. ' `name` VARCHAR(127) NOT NULL DEFAULT \'\','
			. ' `value` TEXT NOT NULL,'
			. ' PRIMARY KEY ( `image_id`, `name` ),'
			. ' CONSTRAINT `:prefix:cG_ImageOptionsImg` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images`(`image_id`) ON DELETE CASCADE,'
			. ' CONSTRAINT `:prefix:cG_ImageOptionsGal` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE'
		. ' ) ENGINE=InnoDB'
	);

	// CREATE TABLE IF NOT EXISTS for image contents
	CAT_Helper_Page::getInstance()->db()->query(
		'CREATE TABLE IF NOT EXISTS `:prefix:mod_cc_catgallery_contents`  ('
			. ' `image_id` INT NOT NULL DEFAULT 0,'
			. ' `content` TEXT NOT NULL,'
			. ' `text` TEXT NOT NULL,'
			. ' PRIMARY KEY ( `image_id` ),'
			. ' CONSTRAINT `:prefix:cG_ImageOptionsContent` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images`(`image_id`) ON DELETE CASCADE'
		. ' ) ENGINE=InnoDB'
	);

	$gallery_path	= CAT_PATH . MEDIA_DIRECTORY . '/cc_catgallery';
	if ( !file_exists($gallery_path) )
		CAT_Helper_Directory::getInstance()->createDirectory( $gallery_path . '/temp', NULL, true );

	// Activate search for image_contents
	$insert_search = CAT_Helper_Page::getInstance()->db()->query( sprintf(
			"SELECT * FROM `%ssearch`
				WHERE `value` = '%s'",
			CAT_TABLE_PREFIX,
			'cc_catgallery'
		)
	);

	if( $insert_search->numRows() == 0 )
	{
		// Insert info into the search table
		// Module query info
		$field_info = array(
			'page_id'			=> 'page_id',
			'title'				=> 'page_title',
			'link'				=> 'link',
			'description'		=> 'description',
			'modified_when'		=> 'modified_when',
			'modified_by'		=> 'modified_by'
		);

		$field_info = serialize($field_info);

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'module', 'cc_catgallery', '%s' )",
				CAT_TABLE_PREFIX,
				$field_info
			)
		);
		// Query start
		$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_cc_catgallery_contents, [TP]pages WHERE ";

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_start', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_start_code,
				'cc_catgallery'
			)
		);
		// Query body
		$query_body_code = " [TP]pages.page_id = [TP]mod_cc_catgallery_contents.page_id AND [TP]mod_cc_catgallery_contents.text [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_body', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_body_code,
				'mod_cc_catgallery_contents'
			)
		);

		// Query end
		$query_end_code = "";
		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_end', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_end_code,
				'mod_cc_catgallery_contents'
			)
		);

	}



	// add files to class_secure
	$addons_helper = new CAT_Helper_Addons();
	foreach(
		array(
			'save.php'
		)
		as $file
	) {
		if ( false === $addons_helper->sec_register_file( 'cc_catgallery', $file ) )
		{
			 error_log( "Unable to register file -$file-!" );
		}
	}
}

?>