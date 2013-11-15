<?php
/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_cat_gallery
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */

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

$module_description	  = 'Dieses Addon bietet eine einfache M&ouml;glichkeit einen Bildslider oder eine einfache Gallerie auf ihrer Internetseite einzubinden. F&uuml;r mehr Informationen lesen Sie <a href="https://github.com/BlackCatDevelopment/catGallery_for_BlackCatCMS" target="_blank">GitHub</a>.<br/><br/>Done by Matthias Glienke, <a class="icon-creativecat" href="http://creativecat.de"> creativecat</a>';

$LANG = array(
// --- view no image ---
    'No images were found' => 'Keine Bilder gefunden',
// --- modify ---
    'Options for frontend' => 'Optionen f&uuml;rs Frontend',
    'Kind of animation' => 'Art der Animation',
    'No effect selected...' => 'Kein Effekt ausgew&auml;lt',
    'Time until animation' => 'Zeit zwischen der Animation',
    'Time for animation' => 'Animationsgeschwindigkeit',
    'Show images by chance' => 'Bilderreihenfolge zuf&auml;llig',
    'Upload/ Save' => 'Hochladen/Speichern',
    'Image option' => 'Bild Optionen',
    'Adjust horizontal' => 'Breite einstellen',
    'Adjust vertical' => 'H&ouml;he einstellen',
    'Upload new image' => 'Neues Bild hochladen',
    'Please notice, that loadingtime increases on more images' => 'Bitte beachten, bei mehreren Bildern erh&ouml;ht sich die Ladezeit',
    'Add another upload' => 'Ein weiteres Bild hinzuf&uuml;gen',
    'Cancel' => 'Abbrechen',
    'Current images' => 'Vorhandene Bilder',
    'Name of image' => 'Bildname',
    'Alternative text' => 'Alternativer Text',
    'Description for Image' => 'Bildbeschreibung',
    'No images available' => 'Keine Bilder vorhanden',
);