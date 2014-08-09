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

$PageHelper	= CAT_Helper_Page::getInstance();

$info			= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/cc_cat_gallery/' );

$folder_url		= CAT_URL . MEDIA_DIRECTORY . '/cc_cat_gallery/cc_cat_gallery_' . $section_id;
$folder_path	= CAT_PATH . MEDIA_DIRECTORY . '/cc_cat_gallery/cc_cat_gallery_' . $section_id;

$parser_data	= array(
	'folder_url'		=> $folder_url,
	'CAT_ADMIN_URL'		=> CAT_ADMIN_URL,
	'CAT_URL'			=> CAT_URL,
	'page_id'			=> $page_id,
	'section_id'		=> $section_id,
	'version'			=> CAT_Helper_Addons::getModuleVersion('cc_cat_gallery'),
	'module_variants'	=> $info['module_variants'],
	'easing_options'	=> array(
								'cube',
								'cubeRandom',
								'block',
								'cubeStop',
								'cubeHide',
								'cubeSize',
								'horizontal',
								'showBars',
								'showBarsRandom',
								'tube',
								'fade',
								'fadeFour',
								'paralell',
								'blind',
								'blindHeight',
								'blindWidth',
								'directionTop',
								'directionBottom',
								'directionRight',
								'directionLeft',
								'cubeStopRandom',
								'cubeSpread',
								'cubeJelly',
								'glassCube',
								'glassBlock',
								'circles',
								'circlesInside',
								'circlesRotate',
								'cubeShow',
								'upBars',
								'downBars',
								'hideBars',
								'swapBars',
								'swapBarsBack',
								'random',
								'randomSmart'
							)
	);

// Get page content
$values		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
		"SELECT * FROM %smod_%s WHERE %s = '%s'",
		CAT_TABLE_PREFIX,
		'cc_cat_gallery',
		'section_id',
		$section_id
	)
);

if ( isset($values) && $values->numRows() > 0 )
{
	while( !false == ( $row = $values->fetchRow( MYSQL_ASSOC ) ) )
	{
		$parser_data['variant']				= $row['variant'];
		$parser_data['effect']				= ( $row['effect'] != '' && $row['effect'] != '0' ) ? $row['effect'] : false;
		$parser_data['resize_x']			= ( $row['resize_x'] != '' && $row['resize_x'] != '0' ) ? $row['resize_x'] : false;
		$parser_data['resize_y']			= ( $row['resize_y'] != '' && $row['resize_y'] != '0' ) ? $row['resize_y'] : false;
		$parser_data['animSpeed']			= ( $row['animSpeed'] != '' && $row['animSpeed'] != '0' ) ? $row['animSpeed'] : false;
		$parser_data['pauseTime']			= ( $row['pauseTime'] != '' && $row['pauseTime'] != '0' ) ? $row['pauseTime'] : false;
		$parser_data['random']				= $row['random'];
	}
	$files		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
			"SELECT * FROM %smod_%s WHERE %s = '%s'",
			CAT_TABLE_PREFIX,
			'cc_cat_gallery_images',
			'section_id',
			$section_id
		)
	);
	if ( isset($files) && $files->numRows() > 0 )
	{
		while ( !false == ( $row = $files->fetchRow( MYSQL_ASSOC ) ) )
		{
			$parser_data['images'][]	= array(
										'image_id'			=> $row['image_id'],
										'picture'			=> $row['picture'],
										'alt'				=> $row['alt'],
										'image_content'		=> $row['image_content'],
										'contentname'		=> 'image_content_' . $row['image_id']
									);
		}
	}
}

$module_variant	= isset($info['module_variants'][$parser_data['variant']]) ?
	$info['module_variants'][$parser_data['variant']] : 
	'default';

$parser->setPath( dirname(__FILE__) . '/templates/' . $module_variant );
$parser->setFallbackPath( dirname( __FILE__ ) . '/templates/default' );

$parser->output(
	'modify',
	$parser_data
);

?>