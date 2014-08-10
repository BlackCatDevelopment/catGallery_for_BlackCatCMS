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


if ( isset($result) && $result->numRows() > 0)
{
	while( !false == ($row = $result->fetchRow( MYSQL_ASSOC ) ) )
	{

		$parser_data['resize_x']			= $row['resize_x'];
		$parser_data['resize_y']			= $row['resize_y'];
		$parser_data['effect']				= ( $row['effect'] != '' && $row['effect'] != '0' ) ? $row['effect'] : false;
		$parser_data['pauseTime']			= ( $row['pauseTime'] != '' && $row['pauseTime'] != '0' ) ? $row['pauseTime'] : false;
		$random								= $row['random'];
		$parser_data['label']				= floor( $row['resize_x'] * 0.382 );
		$parser_data['count_img']			= false;

		$tmp_path	= sprintf( '%s/thumbs_%s_%s/',
						$folder_path, $parser_data['resize_x'], $parser_data['resize_y'] );
		$tmp_url	= sprintf( '%s/thumbs_%s_%s/',
						$folder_url, $parser_data['resize_x'], $parser_data['resize_y'] );

		if ( !file_exists( $tmp_path ) ) 
			CAT_Helper_Directory::getInstance()->createDirectory( $tmp_path, OCTAL_DIR_MODE, true );

		$parser_data['tmp_url']				= $tmp_url;
		$parser_data['tmp_path']			= $tmp_path;


		$files	= CAT_Helper_Page::getInstance()->db()->query(
						sprintf(
							'SELECT * FROM `%smod_cc_%s` WHERE `%s` = \'%s\'',
								CAT_TABLE_PREFIX,
								'cat_gallery_images',
								'section_id',
								$section_id
						)
					);

		if ( isset($files) && $files->numRows() > 0 )
		{
			while ( !false == ( $row = $files->fetchRow( MYSQL_ASSOC ) ) )
			{
				CAT_Helper_Page::preprocess( $row['image_content'] );
				$parser_data['images'][]	= array(
											'image_id'			=> $row['image_id'],
											'picture'			=> $row['picture'],
											'alt'				=> $row['alt'],
											'image_content'		=> $row['image_content']
										);
				if ( !file_exists( $tmp_path . $row['picture'] ) )
				{

				}

			}
			if ( $random == 1 )
			{
				shuffle( $parser_data['images'] );
			}
			$template		= 'view';
			$parser_data['count_img']		= count( $parser_data['images'] );
		}
	}
}


?>
