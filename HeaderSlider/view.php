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

$folder_url		= CAT_URL . MEDIA_DIRECTORY . '/cc_header_slider/cc_header_slider_' . $section_id;
$folder_path	= CAT_PATH . MEDIA_DIRECTORY . '/cc_header_slider/cc_header_slider_' . $section_id;

$template		= 'view_no_image';

$parser_data	= array(
	'page_id'		=> $page_id,
	'section_id'	=> $section_id,
	'folder_url'	=> $folder_url
);
$info						= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/cc_header_slider/' );

$parser_data['page_link']	= CAT_Helper_Page::getInstance()->properties( $page_id, 'link' );


$result		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
		"SELECT * FROM %smod_%s WHERE %s = '%s'",
		CAT_TABLE_PREFIX,
		'cc_header_slider',
		'section_id',
		$section_id
	)
);

if ( isset($result) && $result->numRows() > 0)
{
	while( !false == ($row = $result->fetchRow( MYSQL_ASSOC ) ) )
	{
		$header_slider_id					= $row['header_slider_id'];
		$parser_data['variant']				= $row['variant'];
		$parser_data['header_slider_id']	= $header_slider_id;
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
								'header_slider_images',
								'header_slider_id',
								$header_slider_id
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
					CAT_Helper_Image::getInstance()->make_thumb(
									$folder_path . '/' . $row['picture'],
									$tmp_path . $row['picture'] ,
									$parser_data['resize_y'],
									$parser_data['resize_x'],
									'crop'
								);
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

$module_variant	= isset($info['module_variants'][$parser_data['variant']]) ?
	$info['module_variants'][$parser_data['variant']] : 
	'default';

$parser->setPath( dirname(__FILE__) . '/templates/' . $module_variant );
$parser->setFallbackPath( dirname( __FILE__ ) . '/templates/default' );

$parser->output(
	$template,
	$parser_data
);

?>
