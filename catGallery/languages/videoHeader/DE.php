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
 *   @author			Matthias Glienke, letima development
 *   @copyright			2021, Black Cat Development
 *   @link				https://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

if (defined("CAT_PATH")) {
    include CAT_PATH . "/framework/class.secure.php";
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while ($level < 10 && !file_exists($root . "/framework/class.secure.php")) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root . "/framework/class.secure.php")) {
        include $root . "/framework/class.secure.php";
    } else {
        trigger_error(
            sprintf(
                "[ <b>%s</b> ] Can't include class.secure.php!",
                $_SERVER["SCRIPT_NAME"]
            ),
            E_USER_ERROR
        );
    }
}

// --- logos ---
$LANG = [
    "Dark video" => "Dunkles Video",
    "Button down" => "Button nach unten",
    "Over full browser height" => "Über volle Browserhöhe",
    "The video must be uploaded to the /media/video/folder in mp4, ogg and webm formats. The name (without file extension) must then be entered here." =>
        "Das Video muss in den Formaten mp4, ogg und webm in den Ordner /media/video/ hochgeladen werden. Der Name (ohne Dateiendung) muss dann hier angegeben werden.",
    "Video filename" => "Video Dateiname",
    "Show content above" => "Zeige Beschreibung oberhalb",
    "H1 heading" => "H1-Überschrift",
    "URL to video" => "URL zum Video",
];
