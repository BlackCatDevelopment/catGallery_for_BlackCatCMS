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
 *   @package			multiColumn
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
	$checkExists	= CAT_Helper_Page::getInstance()->db()->query(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS" .
			" WHERE table_name = ':prefix:mod_cc_catgallery_images'" .
				" AND column_name = 'published'");
	if( $checkExists && $checkExists->rowCount() == 0 )
	{
		CAT_Helper_Page::getInstance()->db()->query("ALTER TABLE :prefix:mod_cc_catgallery_images ADD `published` TINYINT(1) NOT NULL DEFAULT '0'");
		CAT_Helper_Page::getInstance()->db()->query('UPDATE :prefix:mod_cc_catgallery_images SET `published` = 1');
	}
}

?>