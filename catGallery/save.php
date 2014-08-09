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

if (defined('CAT_PATH')) {	
	if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
	include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
	$subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));	$dir = $_SERVER['DOCUMENT_ROOT'];
	$inc = false;
	foreach ($subs as $sub) {
		if (empty($sub)) continue; $dir .= '/'.$sub;
		if (file_exists($dir.'/framework/class.secure.php')) {
			include($dir.'/framework/class.secure.php'); $inc = true;	break;
	}
	}
	if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

$val		= CAT_Helper_Validate::getInstance();
$backend	= CAT_Backend::getInstance('Pages', 'pages_modify');

// ===============
// ! Get page id
// ===============
$page_id	= $val->get('_REQUEST','page_id','numeric');
$section_id	= $val->get('_REQUEST','section_id','numeric');

$update_when_modified		= true; // Tells script to update when this page was last updated

$folder_url					= CAT_URL . MEDIA_DIRECTORY . '/cc_cat_gallery/cc_cat_gallery_' . $section_id;
$folder_path				= CAT_PATH . MEDIA_DIRECTORY . '/cc_cat_gallery/cc_cat_gallery_' . $section_id;

if ( $val->get('_REQUEST','speichern') != '' )
{
	// Ausgabeoptionen abfragen
	$effect		= $val->sanitizePost( 'effect' );
	$animSpeed	= $val->get('_REQUEST','animSpeed','numeric');
	$pauseTime	= $val->get('_REQUEST','pauseTime','numeric');
	$variant	= $val->get('_REQUEST','variant','numeric');
	$random		= $val->sanitizePost( 'random' ) == '' ? 0 : 1;
	
	// Bildoptionen abfragen
	$resize_x			= $val->get('_REQUEST','resize_x','numeric');
	$resize_y			= $val->get('_REQUEST','resize_y','numeric');
		
	// Daten für Gallery in Datenbank speichern
	if ( $pauseTime != '' || 
			$effect != '' ||
			$resize_x != '' ||
			$resize_y != '' ||
			$animSpeed != '' ||
			$variant != '' )
	{
		$query = "UPDATE " . CAT_TABLE_PREFIX . "mod_cc_cat_gallery SET
			pauseTime	= '$pauseTime',
			effect		= '$effect',
			resize_x	= '$resize_x',
			resize_y	= '$resize_y',
			animSpeed	= '$animSpeed',
			random		= '$random',
			variant		= '$variant'
			WHERE section_id = '$section_id'";

		$backend->db()->query($query);
	}

	// Bilder hochladen und speichern
	if ( isset( $_FILES['new_image_1']['name'] ) && $_FILES['new_image_1']['name'] != '' )
	{
		echo '<h3>Bilder werden bearbeitet</h3>';

		$allowed_file_types		= array( 'png', 'jpg', 'jpeg', 'gif' );
		$upload_counter			= $val->get('_REQUEST','upload_counter','numeric');
		for ( $file_id = 1; $file_id <= $upload_counter; $file_id++  )
		{
			$field_name	= 'new_image_' . $file_id;

			if ( isset( $_FILES[$field_name]['name'] ) && $_FILES[$field_name]['name'] != '' )
			{
				// =========================================== 
				// ! Get file extension of the uploaded file   
				// =========================================== 
				$file_extension	= (strtolower( pathinfo( $_FILES[$field_name]['name'], PATHINFO_EXTENSION ) ) == '')
							? false
							: strtolower( pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION))
							;
				// ====================================== 
				// ! Check if file extension is allowed   
				// ====================================== 
				if ( isset( $file_extension ) && in_array( $file_extension, $allowed_file_types ) )
				{
					if ( ! is_array($_FILES) || ! count($_FILES) )
					{
						echo $backend->lang()->translate('No files!');
					}
					else
					{
						$current = CAT_Helper_Upload::getInstance( $_FILES[$field_name] );
						if ( $current->uploaded )
						{
							$current->file_overwrite		= false;
							$current->process(  $folder_path . '/' );
				
							if ( $current->processed )
							{
								$backend->db()->query( sprintf(
										'INSERT INTO %smod_%s (%s) VALUES (%s)',
										CAT_TABLE_PREFIX,
										'cc_cat_gallery_images',
										'`section_id`, `page_id`',
										'\'' . $section_id . '\', \'' . $page_id . '\''
									)
								);


								$newId	= $backend->db()->get_one( 'SELECT LAST_INSERT_ID()' );

								$picture	= sprintf(
										'image_%s_%s.%s',
										$section_id,
										$newId,
										$file_extension
								);

								$backend->db()->query( sprintf(
										'UPDATE `%smod_%s` SET %s WHERE %s',
										CAT_TABLE_PREFIX,
										'cc_cat_gallery_images',
										'`picture` = ' . '\'' . $picture . '\'',
										'`image_id` = ' . '\'' .  $newId . '\''
									)
								);

								CAT_Helper_Image::getInstance()->make_thumb(
									$folder_path . '/' . $current->file_dst_name,
									$folder_path . '/' . $picture,
									1600,//$resize_y,
									1600,//$resize_x,
									'fit'
								);

								unlink($folder_path . '/' . $current->file_dst_name);
								$success	= true;

								echo $picture . $backend->lang()->translate('File uploaded') . '<br/>';
								// =================================
								// ! Clean the upload class $files
								// =================================
								$current->clean();
							}
							else
							{
								echo $backend->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
							}
						}
						else
						{
							echo $backend->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
						}
					}
				}
			}
		}
	}

	// Bildoptionen abfragen
	$images_values		= array();
	if ( $all_ids	= $val->get('_REQUEST','image_id','array') )
	{
		echo $val->sanitizePost( 'delete_1' );
		foreach ( $all_ids as $value )
		{
			$images_values[]		= array(
				'image_id'			=> $value,
				'image_content'		=> $val->sanitizePost( 'image_content_' . $value ),
				'alt'				=> $val->sanitizePost( 'alt_' . $value ),
				'picture'			=> $val->sanitizePost( 'picture_' . $value ),
				'delete'			=> $val->sanitizePost( 'delete_' . $value )
			);
		}
	}
	// Daten für einzelne Bilder in Datenbank speichern
	$deleted			= false;

	foreach ( $images_values as $values )
	{
		$image_id		= $values['image_id'];
		if ( $values['delete'] != '' )
		{
			if ( file_exists($folder_path . '/' . $values['picture']) ) unlink( $folder_path . '/' . $values['picture'] );
			$backend->db()->query("DELETE FROM " . CAT_TABLE_PREFIX . "mod_cc_cat_gallery_images WHERE image_id = '$image_id'");
			$deleted	= true;
		}
		else
		{
			$alt			= $values['alt'];
			$image_content	= $values['image_content'];
			$backend->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_cc_cat_gallery_images SET alt = '$alt', image_content = '$image_content' WHERE image_id = '$image_id'");
		}
	}
	if ( $deleted ) $backend->db()->query("OPTIMIZE TABLE `" . CAT_TABLE_PREFIX . "mod_cc_cat_gallery_images`");
}
// Check, ob ein Fehler aufgetreten ist
if ( $backend->db()->is_error() )
{
	$backend->print_error($backend->db()->get_error());
}
else
{
	$update_when_modified = true;
	CAT_Backend::getInstance()->updateWhenModified();

	$backend->print_success('Seite erfolgreich gespeichert', CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
}

// Print admin footer
$backend->print_footer();

?>