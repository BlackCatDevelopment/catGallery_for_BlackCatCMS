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

$module_description	  = 'Dieses Addon bietet eine einfache M&ouml;glichkeit einen Bildslider oder eine einfache Gallerie auf ihrer Internetseite einzubinden. F&uuml;r mehr Informationen lesen Sie <a href="https://github.com/BlackCatDevelopment/catGallery_for_BlackCatCMS" target="_blank">GitHub</a>.<br/><br/>Done by Matthias Glienke, <a class="icon-creativecat" href="http://creativecat.de"> creativecat</a>';

$LANG = array(
// --- view no image ---
    'No images were found'			=> 'Keine Bilder gefunden',
// --- modify ---				
	'Administration for catGallery'	=> 'Verwaltung von catGallery',
    'Options for frontend'			=> 'Optionen f&uuml;rs Frontend',
    'Kind of animation'				=> 'Art der Animation',
    'No effect selected...'			=> 'Kein Effekt ausgew&auml;lt',
    'Time until animation'			=> 'Zeit zwischen der Animation',
    'Time for animation'			=> 'Animationsgeschwindigkeit',
    'Width of label (Set to 0 for no labels)'
    								=> 'Breite des Labels (0 für keine Labels)',
    'Show images by chance'			=> 'Bilderreihenfolge zuf&auml;llig',
    'Upload/ Save'					=> 'Hochladen/Speichern',
    'Image option'					=> 'Bild Optionen',
    'Adjust horizontal'				=> 'Breite einstellen',
    'Adjust vertical'				=> 'H&ouml;he einstellen',
    'Upload new image'				=> 'Neues Bild hochladen',
    'Please notice, that loadingtime increases on more images'
    								=> 'Bitte beachten, bei mehreren Bildern erh&ouml;ht sich die Ladezeit',
    'Add another upload'			=> 'Ein weiteres Bild hinzuf&uuml;gen',
    'Cancel'						=> 'Abbrechen',
    'Current images'				=> 'Vorhandene Bilder',
    'Name of image'					=> 'Bildname',
    'Alternative text'				=> 'Alternativer Text',
    'Description for Image'			=> 'Bildbeschreibung',
    'No images available'			=> 'Keine Bilder vorhanden',
    'Width of gallery (0 for 100%)'	=> 'Breite der Galerie (0 für 100%)'
);