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
 *   @author			Dirk Grebe
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
    while ($level < 10 && !file_exists($root . "framework/class.secure.php")) {
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

// --- bs_Carousel ---
$LANG = [
    "Options for carousel" => "Optionen f&uuml;rs Carousel",
    "Bootstrap 4 variant for BC 1.3." =>
        "Bootstrap 4 Variante f&uuml;r BC 1.3.",
    "Section Header Text Pos." => "Bereich Text Position",
    "Default" => "Standard",
    "Align Centered" => "Zentriert",
    "Align Right" => "Rechts",
    "Section Headline" => "Bereich Kopfzeile",
    "Headline" => "&Uuml;berschrift",
    "Size" => "Gr&ouml;&szlig;e",
    "Style" => "Textart",
    "Uppercase" => "Gro&szlig;buchstaben",
    "Divider" => "Trennlinie",
    "Divider Icon" => "Trennzeichen",
    "Divider Color" => "Trennlinienfarbe",
    "White" => "Wei&szlig;",
    "Primary" => "Prim&auml;r",
    "Secondary" => "Sekund&auml;r",
    "Success" => "Erfolgreich",
    "Danger" => "Gef&auml;hrlich",
    "Warning" => "Warnung",
    "Info" => "Info",
    "Light" => "Hell",
    "Dark" => "Dunkel",
    "Section Lead Text" => "Bereich Haupttext",
    "Activate fade" => "Bilder ein-/ausblenden",
    "Show indicators" => "Positionsanzeiger anzeigen",
    "Show image title" => "Bild Titel anzeigen",
    "Show image description" => "Bild Beschreibung anzeigen",
    "Image title" => "Bild Titel",
    "You need to install lib_bootstrap_4 for this variant." =>
        "F&uuml;r diese Variante muss lib_bootstrap_4 installiert sein.",
];
