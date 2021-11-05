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

$module_description =
    'Dieses Addon bietet eine einfache M&ouml;glichkeit einen Bildslider oder eine einfache Gallerie auf ihrer Internetseite einzubinden. F&uuml;r mehr Informationen lesen Sie <a href="https://github.com/BlackCatDevelopment/catGallery_for_BlackCatCMS" target="_blank">GitHub</a>.<br/><br/>Done by Matthias Glienke, <a class="icon-creativecat" href="http://creativecat.de"> creativecat</a>';

$LANG = [
    "Image Title" => "Bildtitel",
    "Set skin" => "Variante setzen",
    "Save skin &amp; reload" => "Speichern &amp; Neuladen",
    // --- view no image ---
    "No images were found" => "Keine Bilder gefunden",
    "Drag &amp; drop" => "Drag &amp; drop",
    "your images here or click to upload" =>
        "Ziehe deine Bilder hierher oder klicke um Bilder hochzuladen",
    // --- modify ---
    "Options for frontend" => "Optionen f&uuml;rs Frontend",
    "Kind of animation" => "Art der Animation",
    "No effect selected..." => "Kein Effekt ausgew&auml;lt",
    "Time until animation" => "Zeit zwischen der Animation",
    "Animation speed" => "Animationsgeschwindigkeit",
    "Width of label (Set to 0 for no labels)" =>
        "Breite des Labels (0 für keine Labels)",
    "Show pictures randomly" => "Bilderreihenfolge zuf&auml;llig",
    "Image option" => "Bildoptionen",
    "Adjust horizontal" => "Breite einstellen",
    "Adjust vertical" => "H&ouml;he einstellen",
    "Upload new images" => "Neue Bilder hochladen",
    "Please notice, that loadingtime increases on more images" =>
        "Bitte beachten, bei mehreren Bildern erh&ouml;ht sich die Ladezeit",
    "Add another upload" => "Ein weiteres Bild hinzuf&uuml;gen",
    "Cancel" => "Abbrechen",
    "Existing images" => "Vorhandene Bilder",
    "Replace image" => "Bild ersetzen",
    "Delete this image" => "Dieses Bild löschen",
    "Name image" => "Bildname",
    "Alternative text" => "Bildersatztext",
    "Description for Image" => "Bildbeschreibung",
    "No images available" => "Keine Bilder vorhanden",
    "Width of gallery (0 for 100%)" => "Breite der Galerie (0 für 100%)",
    "Delete this image during the next save" =>
        "Dieses Bild beim n&auml;chsten Speichern l&ouml;schen",
    // --- save ---
    "Save image" => "Bild speichern",
    "Modify description" => "Beschreibung",
    "Close without saving" => "Ohne Speichern schließen",
    "Reorder image" => "Bilder umsortieren",
    "Image reordered successfully" => "Bilder erfolgreich umsortiert",
    "Reorder failed" => "Umsortieren fehlgeschlagen",
    "Delete this image" => "Dieses Bild l&ouml;schen",
    "Keep this image" => "Bild behalten",
    "Confirm delete" => "Endgültig löschen",
    "No images to upload" => "Keine Bilder zum Upload vorhanden",
    "Image uploaded successfully!" => "Bild erfolgreich hochgeladen",
    "Image deleted successfully!" => "Bild erfolgreich gel&ouml;scht",
    "Image saved successfully" => "Bild erfolgreich gespeichert",
    "An error occoured!" => "Es ist ein Fehler aufgetraten",
    "Content loaded" => "Inhalt geladen",
    "Content saved successfully" => "Inhalt erfolgreich gespeichert",
    "Options saved successfully!" => "Optionen erfolgreich gespeichert",
    "Variant saved successfully!" => "Variante erfolgreich gespeichert",
    "You sent an invalid ID" => "Es wurde keine gültige ID übermittelt.",
    "Publish this image" => "Dieses Bild freigeben",

    // --- Frontend ---
    "No images are uploaded or published!" =>
        "Es wurden noch keine Bilder hochgeladen oder freigegeben!",

    // --- Default - Skitter ---
    "Options for skitter" => "Optionen für Skitter",
    "Progressbar" => "Fortschrittsbalken",
    "Label display" => "Bildbeschreibung",
    "Velocity" => "Geschwindigkeit",
    "Autoplay" => "Autostart",
    "Stop Over" => "Stop bei Mouseover",
    "Numbers" => "Navigation mit Nummern",
    "Dots" => "Navigation mit Punkte",
    "Preview with dots" => "Vorschaubilder mit Punkten",
    "Controls" => "Steuerung anzeigen",
    "Focus" => "Fokus aktivieren",
    "Thumbs" => "Vorschaubilder",
    "Plugin for BC 1.3 (skitter by thiagosf)" =>
        "Plugin f&uuml;r BC 1.3 (skitter by thiagosf)",
];

// --- Include optional language files for variants ---
require_once CAT_PATH . "/modules/catGallery/inc/class.catgallery.php";

$catGallery = new catGallery();
$path = CAT_Helper_Directory::sanitizePath(
    CAT_PATH .
        "/modules/" .
        $catGallery::$directory .
        "/languages/" .
        $catGallery->getVariant()
);

if (file_exists($path)) {
    CAT_Helper_Page::getInstance()
        ->lang()
        ->addFile(LANGUAGE . ".php", $path);
}

?>
