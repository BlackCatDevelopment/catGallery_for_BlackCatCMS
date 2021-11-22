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

$mod_headers = [
    "backend" => [
        "css" => [
            [
                "media" => "all",
                "file" => "modules/cc_catgallery/css/default/backend.css",
            ],
        ],
        "js" => [
            "/modules/cc_catgallery/js/default/dropzone.min.js",
            "/modules/cc_catgallery/js/default/backend.js",
        ],
        "jquery" => [
            [
                "core" => true,
            ],
        ],
    ],
    "frontend" => [
        "css" => [
            [
                "media"	=> "all",
                "file"	=> "modules/cc_catgallery/css/bs_Gallery/frontend.css",
			],
			[
				"media"	=> "all",
				"file"	=> "modules/lib_bootstrap_4/vendor/icons/font/bootstrap-icons.css",
			]
		],
		"js" => [
				"/modules/lib_bootstrap_4/vendor/js/bootstrap.min.js",
		],
		"jquery" => [
			[
				"core"	=> true,
            ],
        ],
    ],
];

?>