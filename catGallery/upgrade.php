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
 *   @copyright			2017, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catgallery
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {
	include(CAT_PATH.'/framework/class.secure.php');
} else {
	$root = "../";
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= "../";
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

if(!isset($module_version))
{
	$details		= CAT_Helper_Addons::getAddonDetails('cc_catgallery');
	$module_version	= $details['version'];
}

if ( CAT_Helper_Addons::versionCompare( $module_version, '2.1', '<' ) )
{
	$checkPosition	= CAT_Helper_Page::getInstance()->db()->query(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS" .
			" WHERE table_name = ':prefix:mod_cc_catgallery_images'" .
				" AND column_name = 'position'");

	# Add option to reorder contents
	if( $checkPosition && $checkPosition->rowCount() == 0 )
	{
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images ADD `position` INT NOT NULL DEFAULT '0'");
	}

	# Add option to publish/unpublish contents
	$checkPublish	= CAT_Helper_Page::getInstance()->db()->query(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS" .
			" WHERE table_name = ':prefix:mod_cc_catgallery_images'" .
				" AND column_name = 'published'");
	if( $checkPublish && $checkPublish->rowCount() == 0 )
	{
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images ADD `published` TINYINT(1)  NULL DEFAULT NULL");
		CAT_Helper_Page::getInstance()->db()->query("UPDATE :prefix:mod_cc_catgallery_images SET `published` = 1");
	}

	# Change to InnoDB
	foreach ( array(
		'mod_cc_catgallery',
		'mod_cc_catgallery_contents',
		'mod_cc_catgallery_images',
		'mod_cc_catgallery_images_options',
		'mod_cc_catgallery_options' ) as $table )
	{
		$getTable	= CAT_Helper_Page::getInstance()->db()->query("SELECT * FROM INFORMATION_SCHEMA.TABLES
 WHERE table_name = ':prefix:".$table."'");
		if( $getTable && $getTable->rowCount() > 0 && !false == ($row = $getTable->fetchRow() ) )
		{
			if($row['ENGINE'] != 'InnoDB' )
				CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:".$table."` ENGINE=InnoDB");
		}
	}

	# Remove page_id/section_id from database where not needed
	foreach ( array(
		'mod_cc_catgallery_contents',
		'mod_cc_catgallery_images',
		'mod_cc_catgallery_images_options',
		'mod_cc_catgallery_options' ) as $table )
	{
		$getTable	= CAT_Helper_Page::getInstance()->db()->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS
 WHERE table_name = ':prefix:".$table."'");
		$attr	= array();
		if( $getTable && $getTable->rowCount() > 0 )
		{
			while( !false == ($row = $getTable->fetchRow() ) )
			{
				$attr[]	= $row['COLUMN_NAME'];
			}
			if (in_array('page_id', $attr))
				CAT_Helper_Page::getInstance()->db()->query(
					"ALTER TABLE `:prefix:".$table."` DROP COLUMN `page_id`; " .
					"ALTER TABLE `:prefix:".$table."` DROP COLUMN `section_id`"
				);
			switch ($table)
			{
				case 'mod_cc_catgallery_contents':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery_contents` DROP COLUMN `gallery_id`;"
					);
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery_contents` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id` )"
					);
					break;
				case 'mod_cc_catgallery_images':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery_images` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id` )"
					);
					break;
				case 'mod_cc_catgallery_images_options':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery_images_options` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id`, `name` )"
					);
					break;
				case 'mod_cc_catgallery_options':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery_options` DROP PRIMARY KEY, ADD PRIMARY KEY ( `gallery_id`, `name` )"
					);
					break;
			}
		}
	}

	# Add Constraints
	$getConstraints	= CAT_Helper_Page::getInstance()->db()->query("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS");

	$constraints	= array();
	if( $getConstraints && $getConstraints->rowCount() > 0 )
	{
		while( !false == ($row = $getConstraints->fetchRow() ) )
		{
			$constraints[]	= $row['CONSTRAINT_NAME'];
		}
	}
	if( !in_array(CAT_TABLE_PREFIX.'cG_pages', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery ADD CONSTRAINT `:prefix:cG_pages` FOREIGN KEY (`page_id`) REFERENCES `:prefix:pages`(`page_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_sections', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery ADD CONSTRAINT `:prefix:cG_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_Options', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_options ADD CONSTRAINT `:prefix:cG_Options` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_Images', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images ADD CONSTRAINT `:prefix:cG_Images` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_ImageOptionsImg', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images_options ADD CONSTRAINT `:prefix:cG_ImageOptionsImg` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images`(`image_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_ImageOptionsGal', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images_options ADD CONSTRAINT `:prefix:cG_ImageOptionsGal` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery`(`gallery_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_ImageOptionsContent', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_contents ADD CONSTRAINT `:prefix:cG_ImageOptionsContent` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images`(`image_id`) ON DELETE CASCADE");

	$path	= CAT_PATH . '/modules/cc_catgallery/classes/';
	if (file_exists($path))
		CAT_Helper_Directory::getInstance()->removeDirectory( $path );

	# change save of variant to new automatic detected variants
	$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/cc_catgallery/' );

	$getVariant	= CAT_Helper_Page::getInstance()->db()->query("SELECT `gallery_id`, `value` FROM `:prefix:mod_cc_catgallery_options`
 WHERE `name` = 'variant'");
	if( $getVariant && $getVariant->rowCount() > 0 )
	{
		while( !false == ($row = $getVariant->fetchRow() ) )
		{
			if ($row['value'] == '' || $row['value'] == '0' )
				$variant	= 'default';
			else if (is_numeric($row['value']) && isset($getInfo['module_variants'][$row['value']]))
				$variant	= $getInfo['module_variants'][$row['value']];
			else if (is_numeric($row['value']))
				$variant	= 'default';
			else $variant	= $row['value'];
			CAT_Helper_Page::getInstance()->db()->query(
				"UPDATE `:prefix:mod_cc_catgallery_options` " .
					"SET `value` = :val " .
					"WHERE `gallery_id` = :galID AND `name` = 'variant'",
				array(
					'val'		=> $variant,
					'galID'		=> $row['gallery_id']
			));
		}
	}


}

?>