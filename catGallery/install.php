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
 *   @author			Matthias Glienke, letima
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
// end include class.secure.php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
require_once "inc/class.catgallery.php";

if (defined("CAT_URL")) {
    catGallery::install();
}
/*
if (defined("CAT_URL")) {
    // Delete all tables if exists
    #	CAT_Helper_Page::getInstance()->db()->query(
    #		'DROP TABLE IF EXISTS'
    #			. ' `:prefix:mod_catGallery_options`,'
    #			. ' `:prefix:mod_catGallery_images_options`,'
    #			. ' `:prefix:mod_catGallery_contents`,'
    #			. ' `:prefix:mod_catGallery_images`,'
    #			. ' `:prefix:mod_catGallery`;'
    #	);

    // CREATE TABLE IF NOT EXISTS for basic informations
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery`  (" .
                " `gallery_id` INT NOT NULL AUTO_INCREMENT," .
                " `page_id` INT," .
                " `section_id` INT," .
                " PRIMARY KEY ( `gallery_id` )," .
                " ," .
                " CONSTRAINT `:prefix:cG_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE" .
                " ) ENGINE=InnoDB"
        );

    // CREATE TABLE IF NOT EXISTS for options
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_options`  (" .
                " `gallery_id` INT NOT NULL DEFAULT 0," .
                ' `name` VARCHAR(127) NOT NULL DEFAULT \'\',' .
                " `value` TEXT NOT NULL," .
                " PRIMARY KEY ( `gallery_id`, `name` )," .
                " CONSTRAINT `:prefix:cG_Options` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_catGallery`(`gallery_id`) ON DELETE CASCADE" .
                " ) ENGINE=InnoDB"
        );

    // CREATE TABLE IF NOT EXISTS for single pictures
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_images`  (" .
                " `image_id` INT NOT NULL AUTO_INCREMENT," .
                " `gallery_id` INT NULL DEFAULT NULL," .
                ' `picture` VARCHAR(127) NOT NULL DEFAULT \'\',' .
                " `published` TINYINT(1) NOT NULL DEFAULT 0," .
                " `position` INT NOT NULL," .
                " PRIMARY KEY ( `image_id` )," .
                " CONSTRAINT `:prefix:cG_Images` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_catGallery`(`gallery_id`) ON DELETE CASCADE" .
                " ) ENGINE=InnoDB"
        );

    // CREATE TABLE IF NOT EXISTS for image options
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_images_options`  (" .
                " `image_id` INT NOT NULL DEFAULT 0," .
                " `gallery_id` INT NULL DEFAULT NULL," .
                ' `name` VARCHAR(127) NOT NULL DEFAULT \'\',' .
                " `value` TEXT NOT NULL," .
                " PRIMARY KEY (  )," .
                " " .
                " ) ENGINE=InnoDB"
        );

    // CREATE TABLE IF NOT EXISTS for image contents
    CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            "CREATE TABLE IF NOT EXISTS `:prefix:`  (" .
                " `image_id` INT NOT NULL DEFAULT 0," .
                " `content` TEXT NOT NULL," .
                " `text` TEXT NOT NULL," .
                " PRIMARY KEY ( `image_id` )," .
                " CONSTRAINT `:prefix:cG_ImageOptionsContent` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_catGallery_images`(`image_id`) ON DELETE CASCADE" .
                " ) ENGINE=InnoDB"
        );

    

    // Activate search for image_contents
    $insert_search = CAT_Helper_Page::getInstance()
        ->db()
        ->query(
            sprintf(
                "SELECT * FROM `%ssearch`
				WHERE `value` = '%s'",
                CAT_TABLE_PREFIX,
                "catGallery"
            )
        );

    if ($insert_search->numRows() == 0) {
        // Insert info into the search table
        // Module query info
        $field_info = [
            "page_id" => "page_id",
            "title" => "page_title",
            "link" => "link",
            "description" => "description",
            "modified_when" => "modified_when",
            "modified_by" => "modified_by",
        ];

        $field_info = serialize($field_info);

        CAT_Helper_Page::getInstance()
            ->db()
            ->query(
                sprintf(
                    "INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'module', 'catGallery', '%s' )",
                    CAT_TABLE_PREFIX,
                    $field_info
                )
            );
        // Query start
        $query_start_code =
            "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_catGallery_contents, [TP]pages WHERE ";

        CAT_Helper_Page::getInstance()
            ->db()
            ->query(
                sprintf(
                    "INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_start', '%s', '%s' )",
                    CAT_TABLE_PREFIX,
                    $query_start_code,
                    "catGallery"
                )
            );
        // Query body
        $query_body_code =
            " [TP]pages.page_id = [TP]mod_catGallery_contents.page_id AND [TP]mod_catGallery_contents.text [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";

        CAT_Helper_Page::getInstance()
            ->db()
            ->query(
                sprintf(
                    "INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_body', '%s', '%s' )",
                    CAT_TABLE_PREFIX,
                    $query_body_code,
                    "mod_catGallery_contents"
                )
            );

        // Query end
        $query_end_code = "";
        CAT_Helper_Page::getInstance()
            ->db()
            ->query(
                sprintf(
                    "INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_end', '%s', '%s' )",
                    CAT_TABLE_PREFIX,
                    $query_end_code,
                    "mod_catGallery_contents"
                )
            );
    }

    // add files to class_secure
    $addons_helper = new CAT_Helper_Addons();
    foreach (["save.php"] as $file) {
        if (false === $addons_helper->sec_register_file("catGallery", $file)) {
            error_log("Unable to register file -$file-!");
        }
    }
}
*/
?>
