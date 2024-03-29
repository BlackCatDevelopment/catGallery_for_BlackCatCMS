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

// include class.secure.php to protect this file and the whole CMS!
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
    if (file_exists($root . "framework/class.secure.php")) {
        include $root . "framework/class.secure.php";
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

include_once "inc/class.catgallery.php";

$catGallery = new catGallery();

$parser_data = [
    "folder_url" => $catGallery->getFolder(false),
    "CAT_ADMIN_URL" => CAT_ADMIN_URL,
    "CAT_URL" => CAT_URL,
    "page_id" => $page_id,
    "section_id" => $section_id,
    "gallery_id" => $catGallery->getID(),
    "version" => CAT_Helper_Addons::getModuleVersion("cc_catgallery"),
    "module_variants" => $catGallery->getAllVariants(),
    "options" => $catGallery->getOptions(null, true),
    "effects" => $catGallery->effects,
    "images" => $catGallery->getImage(null, true, true, true),
    "countImg" => $catGallery->countImg(),
    "imgURL" => $catGallery->getImageURL(),
    "page_link" => CAT_Helper_Page::getInstance()->properties($page_id, "link"),
    "section_name" => str_replace(
        ["ä", "ö", "ü", "ß"],
        ["ae", "oe", "ue", "ss"],
        strtolower($section["name"])
    ),
];

if ($parser_data["countImg"] > 0) {
    $template = "view";
} else {
    $template = "view_no_image";
}

$module_path = "/modules/cc_catgallery/";

$variant = $catGallery->getVariant();

if (file_exists(CAT_PATH . "/modules/lib_mdetect/mdetect/mdetect.php")) {
    require_once CAT_PATH . "/modules/lib_mdetect/mdetect/mdetect.php";
    $uagent_obj = new uagent_info();
    if ($uagent_obj->DetectMobileQuick()) {
        $parser_data["options"]["is_mobile"] = true;
    }
} else {
    $parser_data["options"]["is_mobile"] = null;
}

if (file_exists(CAT_PATH . $module_path . "view/" . $variant . "/view.php")) {
    include CAT_PATH . $module_path . "view/" . $variant . "/view.php";
} elseif (file_exists(CAT_PATH . $module_path . "view/default/view.php")) {
    include CAT_PATH . $module_path . "view/default/view.php";
}

$parser->setPath(dirname(__FILE__) . "/templates/" . $catGallery->getVariant());
$parser->setFallbackPath(dirname(__FILE__) . "/templates/default");

$parser->output($template, $parser_data);

?>
