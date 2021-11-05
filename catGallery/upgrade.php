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
 *   @package			cc_catgallery
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined("CAT_PATH")) {
    include CAT_PATH . "/framework/class.secure.php";
} else {
    $root = "../";
    $level = 1;
    while ($level < 10 && !file_exists($root . "/framework/class.secure.php")) {
        $root .= "../";
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
// end include class.secure.php

if (!isset($module_version)) {
    $directory = "catGallery";
    $details = CAT_Helper_Addons::getAddonDetails($directory);
    if (!$details) {
        $directory = "cc_catgallery";
        $details = CAT_Helper_Addons::getAddonDetails($directory);
    }
    $module_version = $details["version"];
}

// The update.php is not possible
if (CAT_Helper_Addons::versionCompare($module_version, "3.0", "<")) {
    /*
    // rename folders
    $basePath = CAT_Helper_Directory::getInstance()->sanitizePath(
        CAT_PATH . MEDIA_DIRECTORY . "/cc_catgallery/"
    );
    if (file_exists($basePath)) {
        $dirs = glob($basePath . "/*", GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            if (!file_exists($dir) && strpos($dir, "_")) {
                $newDir = explode("_", $dir);
                if (count($newDir) == 2) {
                    echo $dir;
                    echo $basePath . "catGallery_" . $newDir[1];
                    rename($dir, $basePath . "catGallery_" . $newDir[1]);
                }
            }
        }
        rename(
            $basePath,
            CAT_Helper_Directory::getInstance()->sanitizePath(
                CAT_PATH . MEDIA_DIRECTORY . "catCallery"
            )
        );
    }

    // Move all variants from old to new folder
    $modulePath = CAT_Helper_Directory::getInstance()->sanitizePath(
        CAT_PATH . "modules/cc_catgallery/"
    );
    $newPath = CAT_Helper_Directory::getInstance()->sanitizePath(
        CAT_PATH . "modules/catGallery/"
    );
    $checkVariants = [
        "css",
        "js",
        "templates",
        "modify",
        "view",
        "save",
        "headers_inc",
    ];
    if (file_exists($modulePath)) {
        foreach ($checkVariants as $ceckV) {
            $dirs = glob($modulePath . "/" . $ceckV . "/*", GLOB_ONLYDIR);
            foreach ($dirs as $dir) {
                $trail = explode("/", $dir);
                if (!file_exists($newPath . "/" . $ceckV . "/" . end($dir))) {
                    rename($dir, $newPath . "/" . $ceckV . "/" . end($dir));
                }
            }
        }
    }

    // Update addons table
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "UPDATE `:prefix:addons` SET `upgraded`=:time, `version`=:ver, `directory`=:dirNew " .
                "WHERE `directory`=:dirOld",
            [
                "time" => time(),
                "ver" => $details["module_version"],
                "dirNew" => "catGallery",
                "dirOld" => "cc_catgallery",
            ]
        );
    // Update class_secure table
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "UPDATE `:prefix:class_secure` SET `filepath`=:pathNew " .
                "WHERE `module`=:addon AND `filepath` =:pathOld",
            [
                "pathNew" => "/modules/catGallery/save.php",
                "addon" => $details["addon_id"],
                "pathOld" => "/modules/cc_catgallery/save.php",
            ]
        );
    // Update class_secure table
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "UPDATE `:prefix:sections` SET `module`=:pathNew " .
                "WHERE `module`=:pathOld",
            [
                "pathNew" => "catGallery",
                "pathOld" => "cc_catgallery",
            ]
        );

    // ToDo!s => Search anpassen!
    */
}

?>
