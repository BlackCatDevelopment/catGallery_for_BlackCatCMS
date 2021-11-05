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

// --- Slider-Pro ---
$LANG = [
    "Plugin for BC 1.3. (Slider-Pro by bqworks)" =>
        "Plugin f&uuml;r BC 1.3. (Slider-Pro by bqworks)",
    "Slider-Pro options" => "Slider-Pro Optionen",
    "Picture width" => "Bildbreite",
    "Picture height" => "Bildh&ouml;he",
    "Arrows" => "Pfeile",
    "Picture Caption" => "Bildunterschrift",
    "Alternative Text" => "Bildersatztext",
    "Text Layer Content" => "Textebene Inhalt",
    "Text Layer Color" => "Textebene Hintergrund",
    "white" => "Hell",
    "black" => "Dunkel",
    "Text Layer Rounded" => "Textebene abgerundet",
    "Text Layer Padding" => "Textebene Textabstand",
    "Text Layer Width" => "Textebene Breite",
    "Text Layer Height" => "Textebene H&ouml;he",

    "Text Layer Offset Horizontal" => "Abstand (horizontal) der Textebene",
    "Text Layer Offset Vertical" => "Abstand (vertikal) der Textebene",
    "Text Layer Position" => "Position der Textebene",
    "topLeft" => "Oben Links",
    "topCenter" => "Oben Mitte",
    "topRight" => "Oben Rechts",
    "centerLeft" => "Mitte Links",
    "centerCenter" => "Mitte Mitte",
    "centerRight" => "Mitte Rechts",
    "bottomLeft" => "Unten Links",
    "bottomCenter" => "Unten Mitte",
    "bottomRight" => "Unten Rechts",
    "Thumbnail" => "Vorschau Text",

    "Show button" => "Zeige Steuerung",
    "fadeArrows" => "Pfeile ausblenden",
    "centerSelectedSlide" => "Slide zentrieren",
    "rightToLeft" => "Von rechts nach links",
];
