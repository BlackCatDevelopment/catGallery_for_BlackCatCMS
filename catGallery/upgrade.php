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
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_images` ADD `position` INT NOT NULL DEFAULT '0'");
	}

	# Add option to publish/unpublish contents
	$checkPublish	= CAT_Helper_Page::getInstance()->db()->query(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS" .
			" WHERE table_name = ':prefix:mod_cc_catgallery_images'" .
				" AND column_name = 'published'");
	if( $checkPublish && $checkPublish->rowCount() == 0 )
	{
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_images` ADD `published` TINYINT(1)  NULL DEFAULT NULL");
		CAT_Helper_Page::getInstance()->db()->query("UPDATE `:prefix:mod_cc_catgallery_images` SET `published` = 1");
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
 WHERE table_name = ':prefix:" . $table . "'");
		if( $getTable && $getTable->rowCount() > 0 && !false == ($row = $getTable->fetchRow() ) )
		{
			if($row['ENGINE'] != 'InnoDB' )
				CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:" . $table . "` ENGINE=InnoDB");
		}
	}
	
	# Change varchar(2047) to text
	foreach ( array(
		'mod_cc_catgallery_images_options',
		'mod_cc_catgallery_options' ) as $table )
	{
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:" . $table . "` MODIFY `value` TEXT");
	}

	CAT_Helper_Page::getInstance()->db()->query(
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP FOREIGN KEY `:prefix:cG_pages`; ".
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP INDEX `page_id`; " .
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP COLUMN `page_id`;"
	);
	CAT_Helper_Page::getInstance()->db()->query(
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP FOREIGN KEY `:prefix:cG_sections`; " .
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP INDEX `section_id`; " .
		"ALTER TABLE `:prefix:mod_cc_catgallery` DROP COLUMN `section_id`;"
	# Remove page_id/section_id from database where not needed
	foreach ( array(
		'mod_cc_catgallery_contents',
		'mod_cc_catgallery_images',
		'mod_cc_catgallery_images_options',
		'mod_cc_catgallery_options' ) as $table )
	{
		$getTable	= CAT_Helper_Page::getInstance()->db()->query(
			"SELECT * FROM INFORMATION_SCHEMA.COLUMNS " .
				"WHERE table_name = ':prefix:" . $table . "'");

		$attr	= array();
		if( $getTable && $getTable->rowCount() > 0 )
		{
			while( !false == ($row = $getTable->fetchRow() ) )
			{
				$attr[]	= $row['COLUMN_NAME'];
			}
			if (in_array('page_id', $attr))
				CAT_Helper_Page::getInstance()->db()->query(
					"ALTER TABLE `:prefix:" . $table . "` DROP COLUMN `page_id`; "
				);
			if (in_array('section_id', $attr))
				CAT_Helper_Page::getInstance()->db()->query(
					"ALTER TABLE `:prefix:" . $table . "` DROP COLUMN `section_id`"
				);

			switch ($table)
			{
				case 'mod_cc_catgallery_contents':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:" . $table . "` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id` )"
					);

					if (in_array('gallery_id', $attr))
						CAT_Helper_Page::getInstance()->db()->query(
							"ALTER TABLE `:prefix:" . $table . "` DROP COLUMN `gallery_id`"
						);
					break;
				case 'mod_cc_catgallery_images':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:" . $table . "` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id` )"
					);
					break;
				case 'mod_cc_catgallery_images_options':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:mod_cc_catgallery` DROP FOREIGN KEY `:prefix:cG_sections`; " .
						"ALTER TABLE `:prefix:mod_cc_catgallery` DROP INDEX `section_id`; " .
						"ALTER TABLE `:prefix:mod_cc_catgallery` DROP COLUMN `section_id`;"
						"ALTER TABLE `:prefix:" . $table . "` DROP PRIMARY KEY, ADD PRIMARY KEY ( `image_id`, `name` )"
					);

					if (in_array('gallery_id', $attr))
						CAT_Helper_Page::getInstance()->db()->query(
							"ALTER TABLE `:prefix:" . $table . "` DROP COLUMN `gallery_id`"
						);
					break;
				case 'mod_cc_catgallery_options':
					CAT_Helper_Page::getInstance()->db()->query(
						"ALTER TABLE `:prefix:" . $table . "` DROP PRIMARY KEY, ADD PRIMARY KEY ( `gallery_id`, `name` )"
					);
					break;
				default:
				break;
			}
		}
	}


	# Clean up database from non-linked values
	CAT_Helper_Page::getInstance()->db()->query(
		"DELETE FROM `:prefix:mod_cc_catgallery` WHERE `section_id` IN ( " .
			"SELECT temp.`section_id` FROM ( SELECT gal.`section_id` FROM `:prefix:mod_cc_catgallery` gal " .
				"LEFT JOIN `:prefix:sections` section ON gal.`section_id` = section.`section_id` " .
				"WHERE section.`section_id` IS NULL ) temp )");

	CAT_Helper_Page::getInstance()->db()->query(
		"DELETE FROM `:prefix:mod_cc_catgallery` WHERE `page_id` IN ( " .
			"SELECT temp.`page_id` FROM ( SELECT gal.`page_id` FROM `:prefix:mod_cc_catgallery` gal " .
				"LEFT JOIN `:prefix:pages` page ON gal.`page_id` = page.`page_id` " .
				"WHERE page.`page_id` IS NULL ) temp )");

	CAT_Helper_Page::getInstance()->db()->query(
		"DELETE FROM `:prefix:mod_cc_catgallery_images` WHERE `gallery_id` IN ( " .
			"SELECT temp.`gallery_id` FROM ( SELECT img.`gallery_id` FROM `:prefix:mod_cc_catgallery_images` img " .
				"LEFT JOIN `:prefix:mod_cc_catgallery` gal ON img.`gallery_id` = gal.`gallery_id` " .
				"WHERE gal.`gallery_id` IS NULL ) temp )");

	CAT_Helper_Page::getInstance()->db()->query(
		"DELETE FROM `:prefix:mod_cc_catgallery_contents` WHERE `image_id` IN ( " .
			"SELECT temp.`image_id` FROM ( SELECT content.`image_id` FROM `:prefix:mod_cc_catgallery_contents` content " .
				"LEFT JOIN `:prefix:mod_cc_catgallery_images` img ON content.`image_id` = img.`image_id` " .
				"WHERE img.`image_id` IS NULL ) temp )");

	CAT_Helper_Page::getInstance()->db()->query(
		"DELETE FROM `:prefix:mod_cc_catgallery_images_options` WHERE `image_id` IN ( " .
			"SELECT temp.`image_id` FROM ( SELECT opt.`image_id` FROM `:prefix:mod_cc_catgallery_images_options` opt " .
				"LEFT JOIN `:prefix:mod_cc_catgallery_images` img ON opt.`image_id` = img.`image_id` " .
				"WHERE img.`image_id` IS NULL ) temp )");



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
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery` ADD CONSTRAINT `:prefix:cG_pages` FOREIGN KEY (`page_id`) REFERENCES `:prefix:pages` (`page_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_sections', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery` ADD CONSTRAINT `:prefix:cG_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections` (`section_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_Options', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_options` ADD CONSTRAINT `:prefix:cG_Options` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery` (`gallery_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_Images', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_images` ADD CONSTRAINT `:prefix:cG_Images` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_cc_catgallery` (`gallery_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_ImageOptionsImg', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_images_options` ADD CONSTRAINT `:prefix:cG_ImageOptionsImg` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images` (`image_id`) ON DELETE CASCADE");

	if( !in_array(CAT_TABLE_PREFIX.'cG_ImageOptionsContent', $constraints) )
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE `:prefix:mod_cc_catgallery_contents` ADD CONSTRAINT `:prefix:cG_ImageOptionsContent` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_cc_catgallery_images` (`image_id`) ON DELETE CASCADE");

	$path	= CAT_PATH . '/modules/cc_catgallery/classes/';
	if (file_exists($path))
		CAT_Helper_Directory::getInstance()->removeDirectory( $path );

	# change save of variant to new automatic detected variants
	$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/cc_catgallery/' );

	$getVariant	= CAT_Helper_Page::getInstance()->db()->query(
		"SELECT `gallery_id`, `value` FROM `:prefix:mod_cc_catgallery_options` " .
			"WHERE `name` = 'variant'");
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

	// move images in new folders
	$baseURL	= CAT_PATH.MEDIA_DIRECTORY.'/cc_catgallery/';
	$dirs = glob($baseURL.'/*',GLOB_ONLYDIR);
	foreach($dirs as $dir )
	{
		if ( !file_exists($dir.'/originals/'))
			CAT_Helper_Directory::createDirectory( $dir.'/originals/', NULL, true );
		$files = glob($dir."/*.{jpeg,jpg,gif,png}", GLOB_BRACE);
		foreach($files as $file)
		{
			rename($file,$dir.'/originals/'.basename( $file ));
		}
	}

}

?>