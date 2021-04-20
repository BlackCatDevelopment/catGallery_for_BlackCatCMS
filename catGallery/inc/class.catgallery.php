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

if (!class_exists("catGallery", false)) {
    class catGallery
    {
        private static $instance;
        protected static $gallery_id = null;
        protected static $section_id = null;
        protected static $galleryFolder = "";
        protected static $allowed_file_types = ["png", "jpg", "jpeg", "gif"];
        protected static $gallery_root = "";
        protected static $thumb_x = 300;
        protected static $thumb_y = 200;
        private static $respSize = [320, 480, 768, 1080, 1280, 1920];
        protected $imagePATH = null;
        protected $imageURL = null;
        protected $galleryPATH = "";
        protected $galleryURL = "";

        public $contents = [];
        public $options = [];

        public $variant = "default";
        public static $directory = "cc_catgallery";
        protected static $orignalFolder = "/originals/";
        public static $allVariants = [];

        public $effects = [
            "cube",
            "cubeRandom",
            "block",
            "cubeStop",
            "cubeHide",
            "cubeSize",
            "horizontal",
            "showBars",
            "showBarsRandom",
            "tube",
            "fade",
            "fadeFour",
            "paralell",
            "blind",
            "blindHeight",
            "blindWidth",
            "directionTop",
            "directionBottom",
            "directionRight",
            "directionLeft",
            "cubeStopRandom",
            "cubeSpread",
            "cubeJelly",
            "glassCube",
            "glassBlock",
            "circles",
            "circlesInside",
            "circlesRotate",
            "cubeShow",
            "upBars",
            "downBars",
            "hideBars",
            "swapBars",
            "swapBarsBack",
            "random",
            "randomSmart",
        ];

        protected static $initOptions = [
            "variant" => "default",
            "effect" => "random",
            "random" => "0",
            "animSpeed" => "500",
            "pauseTime" => "4000",
            "label" => "1",
            "resize_x" => "800",
            "resize_y" => "600",
            "auto_play" => "1",
        ];

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct($gallery_id = null, $is_header = false)
        {
            if ($gallery_id && is_numeric($gallery_id) && !$is_header) {
                self::setGalleryID($gallery_id);
            } elseif ($gallery_id && is_numeric($gallery_id) && $is_header) {
                self::setSectionID($gallery_id);
                self::setGalleryID();
            } elseif ($gallery_id === true) {
                global $section_id;
                self::setSectionID($section_id);
                self::initAdd();
                self::setGalleryID();
            } else {
                global $section_id;
                self::setSectionID($section_id);
                self::setGalleryID();
            }
            require_once CAT_PATH . "/framework/functions.php";
            /*			if ( $is_header || ( !$is_header && !is_array($gallery_id)) )
			{
				global $section_id;
			}
			

			// This is a workaround for headers.inc.php as there is no $section_id defined yet
			if ( !isset($section_id) || $is_header )
			{
				$section_id	= is_numeric($gallery_id) ? $gallery_id : intval($gallery_id['section_id']);
			}

#			$this->setSectionID($section_id);

#			if ( $gallery_id === true )
#			{
#				$this->initAdd();
#			}
#			elseif ( is_numeric($gallery_id) && !$is_header )
#			{
#				self::$gallery_id	= intval($gallery_id);
#			}
#			elseif ( is_array($gallery_id) && !$is_header )
#			{
#				self::$gallery_id	= intval($gallery_id['gallery_id']);
#			}
#			elseif ( is_numeric($section_id) && $section_id > 0 )
#			{
#				$this->setGalleryID();
#			}
#			else return false;*/
        }

        /**
         * set the $section_id by self:$gallery_id
         *
         * @access public
         * @return integer
         *
         **/
        private function setSectionID($sectionID = null)
        {
            if ($sectionID) {
                self::$section_id = intval($sectionID);
            } else {
                // Get columns in this section
                $sectionID = CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "SELECT `section_id` " .
                            "FROM `:prefix:mod_cc_catgallery` " .
                            "WHERE `gallery_id` = :galID",
                        [
                            "galID" => self::$gallery_id,
                        ]
                    )
                    ->fetchColumn();

                self::$section_id = intval($sectionID);
            }
            self::setGalleryFolder();
            return $this;
        } // end setGalleryID()

        /**
         * set the $gallery_root, galleryPATH and galleryURL if section_id is changed
         */
        private function setGalleryFolder()
        {
            self::$gallery_root =
                CAT_PATH . MEDIA_DIRECTORY . "/cc_catgallery/";
            $this->galleryPATH =
                self::$gallery_root .
                "cc_catgallery_" .
                self::$section_id .
                "/";
            $this->galleryURL =
                CAT_URL .
                MEDIA_DIRECTORY .
                "/cc_catgallery/cc_catgallery_" .
                self::$section_id .
                "/";
            return $this;
        }

        /**
         * set the $gallery_id by self:$sectionid
         *
         * @access public
         * @return integer
         *
         **/
        private function setGalleryID($galleryID = null)
        {
            if ($galleryID) {
                self::$gallery_id = intval($galleryID);
                self::setSectionID();
            } else {
                // Get columns in this section
                $gallery_id = CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "SELECT `gallery_id` " .
                            "FROM `:prefix:mod_cc_catgallery` " .
                            "WHERE `section_id` = :section_id",
                        [
                            "section_id" => self::$section_id,
                        ]
                    )
                    ->fetchColumn();
                self::$gallery_id = intval($gallery_id);
            }
            self::setGalleryFolder();
            return $this;
        } // end setGalleryID()

        /**
         * set the $gallery_id by self:$sectionid
         *
         * @access public
         * @return integer
         *
         **/
        public function getGalleryID()
        {
            if (!self::$gallery_id) {
                $this->setGalleryID();
            }
            return self::$gallery_id;
        } // end getGalleryID()

        public function __destruct()
        {
        }

        /**
         * return, if in a current object all important values are existing (section_id, gallery_id)
         *
         * @access public
         * @param  integer  $image_id - optional check for $image_id to be numeric
         * @return boolean true/false
         *
         **/
        private function checkIDs($image_id = null)
        {
            if (
                !self::$section_id ||
                !self::$gallery_id ||
                ($image_id && !is_numeric($image_id))
            ) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * add new catGallery
         *
         * @access public
         * @return integer
         *
         **/
        private function initAdd()
        {
            if (!self::$section_id) {
                return false;
            }

            if (!file_exists(self::$gallery_root)) {
                CAT_Helper_Directory::getInstance()->createDirectory(
                    self::$gallery_root,
                    null,
                    true
                );
                CAT_Helper_Directory::getInstance()->createDirectory(
                    self::$gallery_root . "/temp/",
                    null,
                    true
                );
            }
            // Add a new catGallery
            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "INSERT INTO `:prefix:mod_cc_catgallery` " .
                            "( `section_id` ) VALUES " .
                            "( :section_id )",
                        [
                            "section_id" => self::$section_id,
                        ]
                    )
            ) {
                $return = true;
                $this->setGalleryID();

                // Add initial options for gallery
                foreach (self::$initOptions as $name => $val) {
                    if (!$this->saveOptions($name, $val)) {
                        $return = false;
                    }
                }
                if (
                    $return &&
                    CAT_Helper_Directory::getInstance()->createDirectory(
                        $this->getFolder(),
                        null,
                        true
                    ) &&
                    CAT_Helper_Directory::getInstance()->createDirectory(
                        $this->getOriginalFolder(),
                        null,
                        true
                    )
                ) {
                    return self::$gallery_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } // initAdd()

        /**
         * delete a catGallery
         *
         * @access public
         * @return integer
         *
         **/
        public function deleteGallery()
        {
            if (!$this->checkIDs()) {
                return false;
            }

            $return = true;

            // Delete complete record from the database
            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "DELETE FROM `:prefix:mod_cc_catgallery` " .
                            "WHERE `section_id` = :section_id AND " .
                            "`gallery_id` = :gallery_id",
                        [
                            "section_id" => self::$section_id,
                            "gallery_id" => self::$gallery_id,
                        ]
                    ) &&
                CAT_Helper_Directory::getInstance()->removeDirectory(
                    $this->getFolder()
                )
            ) {
                return true;
            }
            return false;
        }

        /**
         * add new image
         *
         * @access public
         * @param  string  $file_extension - Extension of file that is added
         * @return array
         *
         **/
        public function addImg($file_extension = null)
        {
            if (!$this->checkIDs() || !$file_extension) {
                return false;
            }

            $getPos = CAT_Helper_Page::getInstance()
                ->db()
                ->query(
                    "SELECT MAX(position) AS pos FROM `:prefix:mod_cc_catgallery_images` " .
                        "WHERE `gallery_id` = :gallery_id",
                    [
                        "gallery_id" => self::$gallery_id,
                    ]
                );
            if ($getPos && $getPos->rowCount() > 0) {
                if (!false == ($pos = $getPos->fetch())) {
                    $position = $pos["pos"] + 1;
                }
            }

            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "INSERT INTO `:prefix:mod_cc_catgallery_images` " .
                            "( `gallery_id`, `position` ) VALUES " .
                            "( :gallery_id, :position )",
                        [
                            "gallery_id" => self::$gallery_id,
                            "position" => $position,
                        ]
                    )
            ) {
                $newID = CAT_Helper_Page::getInstance()
                    ->db()
                    ->lastInsertId();
                $picture = sprintf(
                    "image_%s_%s.%s",
                    self::$section_id,
                    $newID,
                    $file_extension
                );

                if (
                    CAT_Helper_Page::getInstance()
                        ->db()
                        ->query(
                            "UPDATE `:prefix:mod_cc_catgallery_images` " .
                                "SET `picture` = :picture " .
                                "WHERE `image_id` = :image_id AND " .
                                "`gallery_id` = :gallery_id",
                            [
                                "picture" => $picture,
                                "image_id" => $newID,
                                "gallery_id" => self::$gallery_id,
                            ]
                        ) &&
                    $this->saveContent($newID, "")
                ) {
                    return [
                        "image_id" => $newID,
                        "picture" => $picture,
                        "position" => $position,
                        "check" => $getPos,
                    ];
                }
            } else {
                return false;
            }
        }

        /**
         * remove image
         *
         * @access public
         * @param  string  $image_id - ID of image that should be removed
         * @return boolean
         *
         **/
        public function removeImage($image_id = null)
        {
            if (!$this->checkIDs($image_id)) {
                return false;
            }

            if (!isset($this->images[$image_id])) {
                $this->getImage($image_id);
            }

            $return = true;
            // Delete complete record from the database
            if (
                !CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        'DELETE FROM `:prefix:mod_cc_catgallery_images`
					WHERE `image_id` = :image_id AND
						`gallery_id` = :gallery_id',
                        [
                            "image_id" => $image_id,
                            "gallery_id" => self::$gallery_id,
                        ]
                    )
            ) {
                $return = false;
            }

            // Delete folder
            if ($return && $this->images[$image_id]["picture"] != "") {
                $checkFiles = CAT_Helper_Directory::getInstance()->scanDirectory(
                    $this->getFolder(),
                    true,
                    true,
                    null,
                    [],
                    [],
                    ["index.php"]
                );
                foreach ($checkFiles as $path) {
                    $arr = explode("/", $path);
                    if (
                        array_pop($arr) ==
                            $this->images[$image_id]["picture"] &&
                        !unlink($path)
                    ) {
                        $return = false;
                    }
                }
                return $return;
            } else {
                return false;
            }
            return true;
        }

        /**
         * get all images from database
         *
         * @access public
         * @param  integer  $image_id	- optional id of single image
         * @param  boolean  $addOptions	- optional add options of an image
         * @param  boolean  $addContent	- optional add content of an image
         * @return array()
         *
         **/
        public function getImage(
            $image_id = null,
            $addOptions = true,
            $addContent = true
        ) {
            if (!$this->checkIDs()) {
                return false;
            }

            // Get images from database
            $images =
                $image_id && is_numeric($image_id)
                    ? CAT_Helper_Page::getInstance()
                        ->db()
                        ->query(
                            "SELECT * FROM `:prefix:mod_cc_catgallery_images` " .
                                "WHERE `gallery_id` = :gallery_id AND " .
                                "`image_id` = :image_id",
                            [
                                "gallery_id" => self::$gallery_id,
                                "image_id" => $image_id,
                            ]
                        )
                    : CAT_Helper_Page::getInstance()
                        ->db()
                        ->query(
                            "SELECT * FROM `:prefix:mod_cc_catgallery_images` " .
                                "WHERE `gallery_id` = :gallery_id " .
                                "ORDER BY `position`",
                            [
                                "gallery_id" => self::$gallery_id,
                            ]
                        );

            $tmp_path = sprintf(
                "%sthumbs_%s_%s/",
                $this->getFolder(),
                $this->getOptions("resize_x"),
                $this->getOptions("resize_y")
            );
            $thumb_path = sprintf(
                "%sthumbs_%s_%s/",
                $this->getFolder(),
                self::$thumb_x,
                self::$thumb_y
            );
            $thumb_url = sprintf(
                "%sthumbs_%s_%s/",
                $this->getFolder(false),
                self::$thumb_x,
                self::$thumb_y
            );

            if ($images && $images->rowCount() > 0) {
                while (!false == ($row = $images->fetch())) {
                    $this->images[$row["image_id"]] = [
                        "image_id" => $row["image_id"],
                        "position" => $row["position"],
                        "published" => $row["published"],
                        "picture" => $row["picture"],
                        "original" =>
                            $this->getOriginalFolder(false) . $row["picture"],
                        "options" => $addOptions
                            ? $this->getImgOptions($row["image_id"])
                            : null,
                        "image_content" => $addContent
                            ? $this->getImgContent($row["image_id"])
                            : null,
                        "contentname" => "image_content_" . $row["image_id"],
                        "thumb" => $thumb_url . $row["picture"],
                    ];

                    foreach (self::$respSize as $size) {
                        $ratio = round(
                            $this->getOptions("resize_x") /
                                $this->getOptions("resize_y")
                        );
                        $respY = $size / $ratio;
                        $this->images[$row["image_id"]]["rd_" . $size] =
                            $this->galleryURL .
                            "/thumbs_" .
                            $size .
                            "_" .
                            $respY .
                            "/";
                    }
                    $method = $this->getOptions("imageMethod")
                        ? $this->getOptions("imageMethod")
                        : "crop";
                    if (!file_exists($tmp_path . $row["picture"])) {
                        $this->createImg($row["image_id"], null, null, $method);
                    }
                    if (!file_exists($thumb_path . $row["picture"])) {
                        $this->createImg(
                            $row["image_id"],
                            self::$thumb_x,
                            self::$thumb_y
                        );
                    }
                }
            } else {
                return false;
            }

            if ($image_id && is_numeric($image_id)) {
                return $this->images[$image_id];
            } else {
                if ($this->getOptions("random") == 1) {
                    shuffle($this->images);
                }
                return $this->images;
            }
        } // end getImage()

        /**
         * get option of an image
         *
         * @access public
         * @param  integer  $image_id - optional id of an image
         * @return array()
         *
         **/
        private function getImgOptions($image_id = null)
        {
            if (!$this->checkIDs()) {
                return false;
            }

            $select = "";

            if ($image_id && isset($this->images[$image_id]["options"])) {
                return $this->images[$image_id]["options"];
            }

            if (!$image_id && count($this->images) > 0) {
                foreach (array_keys($this->images) as $id) {
                    $select .= " OR `image_id` = '" . intval($id) . "'";
                }
                $select = "AND (" . substr($select, 3) . ")";
            } elseif ($image_id) {
                $select = "AND `image_id` = '" . intval($image_id) . "'";
            } else {
                return false;
            }

            $opts = CAT_Helper_Page::getInstance()
                ->db()
                ->query(
                    sprintf(
                        "SELECT * FROM `:prefix:mod_cc_catgallery_images_options` " .
                            "WHERE `image_id` IN " .
                            "(SELECT `image_id` FROM `:prefix:mod_cc_catgallery_images` WHERE `gallery_id` = :gallery_id) " .
                            "%s",
                        $select
                    ),
                    [
                        "gallery_id" => self::$gallery_id,
                    ]
                );

            $options = [];
            if ($image_id) {
                $this->images[$image_id]["options"] = [];
            }

            if ($opts && $opts->rowCount() > 0) {
                while (!false == ($row = $opts->fetch())) {
                    $options[$row["image_id"]][$row["name"]] = $row["value"];

                    if (isset($this->images[$row["image_id"]]["options"])) {
                        $this->images[$row["image_id"]][
                            "options"
                        ] = array_merge(
                            $this->images[$row["image_id"]]["options"],
                            [
                                $row["name"] => $row["value"],
                            ]
                        );
                    } else {
                        $this->images[$row["image_id"]]["options"] = [
                            $row["name"] => $row["value"],
                        ];
                    }
                }
            }
            if ($image_id) {
                return $this->images[$image_id]["options"];
            } else {
                return $options;
            }
        } // end getImgOptions()

        /**
         * get content of an image
         *
         * @access public
         * @param  string  $image_id - optional id of an image
         * @return array()
         *
         **/
        private function getImgContent($image_id = null)
        {
            if (!$this->checkIDs($image_id)) {
                return false;
            }

            $select = "";

            if (!$image_id && count($this->images) > 0) {
                foreach (array_keys($this->images) as $id) {
                    $select .= " OR `image_id` = '" . intval($id) . "'";
                }
                $select = "(" . substr($select, 3) . ")";
            } elseif ($image_id) {
                $select = "`image_id` = '" . intval($image_id) . "'";
            } else {
                return false;
            }

            $conts = CAT_Helper_Page::getInstance()
                ->db()
                ->query(
                    'SELECT `content`, `image_id` FROM `:prefix:mod_cc_catgallery_contents`
						WHERE ' . $select
                );

            $contents = [];

            if ($conts && $conts->rowCount() > 0) {
                while (!false == ($row = $conts->fetch())) {
                    $contents[$row["image_id"]]["content"] = stripcslashes(
                        $row["content"]
                    );
                    $this->images[$row["image_id"]]["content"] = stripcslashes(
                        $row["content"]
                    );
                }
            }
            if ($image_id) {
                return $this->images[$image_id]["content"];
            } else {
                return $contents;
            }
        } // end getImgContent()

        /**
         * save images
         *
         * @access public
         * @param  integer  $counter - counter of images to be saved
         * @param  array  $tmpFiles - images in an array
         * @return boolean true/false
         *
         **/
        public function saveImages($tmpFiles = null)
        {
            if (!$this->checkIDs()) {
                return false;
            }

            $field_name = "new_image";

            if (
                isset($tmpFiles[$field_name]["name"]) &&
                $tmpFiles[$field_name]["name"] != ""
            ) {
                // ===========================================
                // ! Get file extension of the uploaded file
                // ===========================================
                $file_extension =
                    strtolower(
                        pathinfo(
                            $tmpFiles[$field_name]["name"],
                            PATHINFO_EXTENSION
                        )
                    ) == ""
                        ? false
                        : strtolower(
                            pathinfo(
                                $tmpFiles[$field_name]["name"],
                                PATHINFO_EXTENSION
                            )
                        );

                if (strtolower($file_extension) == "jpeg") {
                    $file_extension = "jpg";
                }

                // ======================================
                // ! Check if file extension is allowed
                // ======================================

                if (
                    isset($file_extension) &&
                    in_array($file_extension, $this->getAllowed())
                ) {
                    if (!is_array($tmpFiles) || !count($tmpFiles)) {
                        $return = false;
                        echo CAT_Backend::getInstance("Pages", "pages_modify")
                            ->lang()
                            ->translate("No files!");
                    } else {
                        $current = CAT_Helper_Upload::getInstance(
                            $tmpFiles[$field_name]
                        );
                        if ($current->uploaded) {
                            $current->file_overwrite = false;

                            if (!file_exists($this->getOriginalFolder())) {
                                CAT_Helper_Directory::getInstance()->createDirectory(
                                    $this->getOriginalFolder(),
                                    null,
                                    true
                                );
                            }

                            $current->process($this->getOriginalFolder());

                            if ($current->processed) {
                                $addImg = $this->addImg($file_extension);

                                rename(
                                    $this->getOriginalFolder() .
                                        $current->file_dst_name,
                                    $this->getOriginalFolder() .
                                        $addImg["picture"]
                                );
                                $method = $this->getOptions("imageMethod")
                                    ? $this->getOptions("imageMethod")
                                    : "crop";
                                if (
                                    !CAT_Helper_Image::getInstance()->make_thumb(
                                        $this->getOriginalFolder() .
                                            $addImg["picture"],
                                        $this->getFolder() . $addImg["picture"],
                                        1600, //$resize_y,
                                        1600, //$resize_x,
                                        $method
                                    )
                                ) {
                                    $return = false;
                                }

                                $this->createImg(
                                    $addImg["image_id"],
                                    self::$thumb_x,
                                    self::$thumb_y
                                );

                                $addImg["thumb"] =
                                    sprintf(
                                        "%sthumbs_%s_%s/",
                                        $this->getFolder(false),
                                        self::$thumb_x,
                                        self::$thumb_y
                                    ) . $addImg["picture"];

                                /*unlink(self::$gallery_root . '/temp/' . $current->file_dst_name);*/

                                // =================================
                                // ! Clean the upload class $files
                                // =================================
                                $current->clean();
                                return $addImg;
                            } else {
                                $return = false;
                                echo CAT_Backend::getInstance(
                                    "Pages",
                                    "pages_modify"
                                )
                                    ->lang()
                                    ->translate(
                                        "File upload error: {{error}}",
                                        ["error" => $current->error]
                                    );
                            }
                        } else {
                            $return = false;
                            echo CAT_Backend::getInstance(
                                "Pages",
                                "pages_modify"
                            )
                                ->lang()
                                ->translate("File upload error: {{error}}", [
                                    "error" => $current->error,
                                ]);
                        }
                    }
                }
            }
        } // end saveImages()

        /**
         * save content for single image
         *
         * @access public
         * @param  integer		$image_id - id of image
         * @param  integer		$resize_x - optional size for resizing x
         * @param  integer		$resize_y - optional size for resizing y
         * @return bool true/false
         *
         **/
        public function createImg(
            $image_id = null,
            $resize_x = null,
            $resize_y = null,
            $method = "crop"
        ) {
            if (!$this->checkIDs($image_id)) {
                return false;
            }

            $tmp_path =
                $resize_x &&
                $resize_y &&
                (is_numeric($resize_x) && is_numeric($resize_y))
                    ? CAT_Helper_Directory::getInstance()->sanitizePath(
                        sprintf(
                            "%sthumbs_%s_%s/",
                            $this->getFolder(),
                            $resize_x,
                            $resize_y
                        )
                    )
                    : $this->getImageURL(true);

            if (!file_exists($tmp_path)) {
                CAT_Helper_Directory::getInstance()->createDirectory(
                    $tmp_path,
                    null,
                    true
                );
            }

            if (!isset($this->images[$image_id])) {
                $this->getImage($image_id);
            }

            $image = $this->images[$image_id]["picture"];
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $ext = strtolower($ext) == "jpeg" ? "" : $ext;

            $resize_x = isset($resize_x)
                ? $resize_x
                : $this->getOptions("resize_x");
            $resize_y = isset($resize_y)
                ? $resize_y
                : $this->getOptions("resize_y");

            if (file_exists($this->getOriginalFolder() . $image)) {
                CAT_Helper_Image::getInstance()->make_thumb(
                    $this->getOriginalFolder() . $image,
                    $tmp_path . "/" . $image,
                    $resize_y,
                    $resize_x,
                    $method,
                    $ext
                );

                #doppelte Größe
                foreach (self::$respSize as $size) {
                    $ratio = round($resize_x / $resize_y);
                    $respY = $size / $ratio;

                    $this->images[$image_id]["rd_" . $size] =
                        $this->galleryURL .
                        "/thumbs_" .
                        $size .
                        "_" .
                        $respY .
                        "/";

                    $respPath = CAT_Helper_Directory::getInstance()->sanitizePath(
                        sprintf(
                            "%s/thumbs_%s_%s/",
                            $this->galleryPATH,
                            $size,
                            $respY
                        )
                    );

                    if (!file_exists($respPath)) {
                        CAT_Helper_Directory::getInstance()->createDirectory(
                            $respPath,
                            null,
                            true
                        );
                    }

                    // Create responsive images
                    CAT_Helper_Image::getInstance()->make_thumb(
                        $this->getFolder() . "/originals/" . $image,
                        $respPath . "/" . $image,
                        $respY,
                        $size,
                        "crop",
                        $ext
                    );
                }
            }
            return [
                "path" => $tmp_path . "/" . $image,
                "url" =>
                    str_replace(CAT_PATH, CAT_URL, $tmp_path) . "/" . $image,
            ];
        } // createImg()

        /**
         * save content for single image
         *
         * @access public
         * @param  integer		$image_id - id of image
         * @param  string		$content - content to save
         * @return bool true/false
         *
         **/
        public function saveContent($image_id = null, $content = "")
        {
            if (!$this->checkIDs($image_id)) {
                return false;
            }

            // use HTMLPurifier to clean up the contents if enabled
            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->get_one(
                        "SELECT `value` FROM `:prefix:settings` " .
                            "WHERE `name` = 'enable_htmlpurifier' AND `value` = 'true'"
                    )
            ) {
                $content = CAT_Helper_Protect::getInstance()->purify($content, [
                    "Core.CollectErrors" => true,
                ]);
            }

            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "REPLACE INTO `:prefix:mod_cc_catgallery_contents` " .
                            "SET `image_id`		= :image_id, " .
                            "`content`		= :content, " .
                            "`text`			= :text",
                        [
                            "image_id" => $image_id,
                            "content" => $content,
                            "text" => umlauts_to_entities(
                                strip_tags($content),
                                strtoupper(DEFAULT_CHARSET),
                                0
                            ),
                        ]
                    )
            ) {
                return true;
            } else {
                return false;
            }
        } // end saveContent()

        /**
         * (un)publish single image
         *
         * @access public
         * @param  integer		$image_id - id of image
         * @return bool true/false
         *
         **/
        public function publishImg($image_id = null)
        {
            if (!$this->checkIDs($image_id)) {
                return false;
            }

            CAT_Helper_Page::getInstance()
                ->db()
                ->query(
                    "UPDATE `:prefix:mod_cc_catgallery_images` " .
                        "SET `published` = 1 - `published` " .
                        "WHERE `gallery_id`		= :gallery_id " .
                        "AND `image_id`	= :image_id",
                    [
                        "gallery_id" => self::$gallery_id,
                        "image_id" => $image_id,
                    ]
                );
            return CAT_Helper_Page::getInstance()
                ->db()
                ->query(
                    "SELECT `published` FROM `:prefix:mod_cc_catgallery_images` " .
                        "WHERE `gallery_id`		= :gallery_id " .
                        "AND `image_id`	= :image_id",
                    [
                        "gallery_id" => self::$gallery_id,
                        "image_id" => $image_id,
                    ]
                )
                ->fetchColumn();
        } // end publishImg()

        /**
         * save options for single image to database
         *
         * @access public
         * @param  string/array		$image_id - id of image
         * @param  string			$name - name for option
         * @param  string			$value - value for option
         * @return bool true/false
         *
         **/
        public function saveImgOptions(
            $image_id = null,
            $name = null,
            $value = ""
        ) {
            if (!$this->checkIDs($image_id) || !$name) {
                return false;
            }

            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "REPLACE INTO `:prefix:mod_cc_catgallery_images_options` " .
                            "SET `gallery_id`	= :gallery_id, " .
                            "`image_id`		= :image_id, " .
                            "`name`			= :name, " .
                            "`value`		= :value",
                        [
                            "gallery_id" => self::$gallery_id,
                            "image_id" => $image_id,
                            "name" => $name,
                            "value" => is_null($value) ? "" : $value,
                        ]
                    )
            ) {
                return true;
            } else {
                return false;
            }
        } // end saveContentOptions()

        /**
         * get options for catGallery
         *
         * @access public
         * @param  string			$name - name for option
         * @param  string			$value - value for option
         * @return array()
         *
         **/
        public function getOptions($name = null)
        {
            if (!$this->checkIDs()) {
                return false;
            }

            if ($name && isset($this->options[$name])) {
                return $this->options[$name];
            }

            $getOptions = $name
                ? CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "SELECT * FROM `:prefix:mod_cc_catgallery_options` " .
                            "WHERE `gallery_id` = :gallery_id AND " .
                            "`name` = :name",
                        [
                            "gallery_id" => self::$gallery_id,
                            "name" => $name,
                        ]
                    )
                : CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "SELECT * FROM `:prefix:mod_cc_catgallery_options` " .
                            "WHERE `gallery_id` = :gallery_id",
                        [
                            "gallery_id" => self::$gallery_id,
                        ]
                    );

            if (isset($getOptions) && $getOptions->numRows() > 0) {
                while (!false == ($row = $getOptions->fetchRow())) {
                    $this->options[$row["name"]] = $row["value"];
                }
            }
            if ($name) {
                if (isset($this->options[$name])) {
                    return $this->options[$name];
                } else {
                    return null;
                }
            }
            return $this->options;
        } // end getOptions()

        /**
         * save options for catGallery
         *
         * @access public
         * @param  string			$name - name for option
         * @param  string			$value - value for option
         * @return bool true/false
         *
         **/
        public function saveOptions($name = null, $value = "")
        {
            if (!$this->checkIDs() || !$name) {
                return false;
            }

            if (
                CAT_Helper_Page::getInstance()
                    ->db()
                    ->query(
                        "REPLACE INTO `:prefix:mod_cc_catgallery_options` " .
                            "SET `gallery_id`	= :gallery_id, " .
                            "`name`			= :name, " .
                            "`value`		= :value",
                        [
                            "gallery_id" => self::$gallery_id,
                            "name" => $name,
                            "value" => is_null($value) ? "" : $value,
                        ]
                    )
            ) {
                return true;
            } else {
                return false;
            }
        } // end saveOptions()

        /**
         * reorder images
         *
         * @access public
         * @param  array			$imgIDs - Strings from jQuery sortable()
         * @return bool true/false
         *
         **/
        public function reorderImg($imgIDs = [])
        {
            if (
                !$this->checkIDs() ||
                !is_array($imgIDs) ||
                count($imgIDs) == 0
            ) {
                return false;
            }

            $return = true;

            foreach ($imgIDs as $index => $imgStr) {
                $imgID = explode("_", $imgStr);

                if (
                    !CAT_Helper_Page::getInstance()
                        ->db()
                        ->query(
                            "UPDATE `:prefix:mod_cc_catgallery_images` " .
                                "SET `position` = :position " .
                                "WHERE `gallery_id`		= :gallery_id " .
                                "AND `image_id`		= :image_id",
                            [
                                "position" => $index,
                                "gallery_id" => self::$gallery_id,
                                "image_id" => $imgID[count($imgID) - 1],
                            ]
                        )
                ) {
                    $return = false;
                }
            }
            return $return;
        } // end reorderImg()

        /**
         * get ID of object gallery
         *
         * @access public
         * @return integer
         *
         **/
        public function getID()
        {
            return self::$gallery_id;
        } // getID()

        /**
         * get variant of gallery
         *
         * @access public
         * @return string
         *
         **/
        public function getVariant()
        {
            if (isset($this->options["_variant"])) {
                return $this->options["_variant"];
            }

            $this->getOptions("variant");

            $this->options["_variant"] =
                isset($this->options["variant"]) &&
                $this->options["variant"] != ""
                    ? $this->options["variant"]
                    : "default";

            return $this->options["_variant"];
        } // getVariant()

        /**
         * Get all available variants of an addon by checking the templates-folder
         */
        public static function getAllVariants()
        {
            if (count(self::$allVariants) > 0) {
                return self::$allVariants;
            }
            foreach (
                CAT_Helper_Directory::getInstance()
                    ->setRecursion(false)
                    ->scanDirectory(
                        CAT_PATH .
                            "/modules/" .
                            static::$directory .
                            "/templates/"
                    )
                as $path
            ) {
                self::$allVariants[] = basename($path);
            }
            return self::$allVariants;
        }

        /**
         * get all possible variants for gallery
         *
         * @access public
         * @return array
         *
         **/
        public function countImg($pubishedOnly = true)
        {
            if (isset($this->images) && count($this->images) > 0) {
                $count = 0;
                if ($pubishedOnly) {
                    foreach ($this->images as $pub) {
                        $count = $count + $pub["published"];
                    }
                } else {
                    $count = count($this->images);
                }
                return $count;
            } else {
                return 0;
            }
        } // countImg()

        /**
         * get folder path/url for gallery
         *
         * @access public
         * @param  boolean	$path - true (default) for getting folder path/ false for getting url
         * @return string
         *
         **/
        public function getFolder($path = true)
        {
            if ($path) {
                return $this->galleryPATH;
            } else {
                return $this->galleryURL;
            }
        } // getFolder()

        /**
         * get folder path/url for gallery
         *
         * @access public
         * @param  boolean	$path - true (default) for getting folder path/ false for getting url
         * @return string
         *
         **/
        public function getOriginalFolder($path = true)
        {
            if ($path) {
                return $this->galleryPATH . self::$orignalFolder;
            } else {
                return $this->galleryURL . self::$orignalFolder;
            }
        } // getOriginalFolder()

        /**
         * get folder path/url for gallery
         *
         * @access public
         * @param  boolean	$path - true (default) for getting folder path/ false for getting url
         * @return string
         *
         **/
        public function getImageURL($path = false)
        {
            if ($path) {
                if (!$this->imagePATH || $this->imagePATH == "") {
                    $this->imagePATH = CAT_Helper_Directory::getInstance()->sanitizePath(
                        sprintf(
                            "%sthumbs_%s_%s/",
                            $this->getFolder(),
                            $this->getOptions("resize_x"),
                            $this->getOptions("resize_y")
                        )
                    );
                }
                return $this->imagePATH;
            } elseif (!$this->imageURL || $this->imageURL == "") {
                $this->imageURL = sprintf(
                    "%sthumbs_%s_%s/",
                    $this->getFolder(false),
                    $this->getOptions("resize_x"),
                    $this->getOptions("resize_y")
                );
            }
            return $this->imageURL;
        } // getImageURL()

        /**
         * get allowed file types
         *
         * @access public
         * @return array
         *
         **/
        public function getAllowed()
        {
            return self::$allowed_file_types;
        } // getAllowed()

        /**
         * sanitize Url
         *
         * @access public
         * @param  string	$url - string to be modified
         * @return string
         *
         **/
        public function sanitizeURL($url = null)
        {
            if (!$url) {
                return false;
            }
            $parts = array_filter(explode("/", $url));
            return implode("/", $parts);
        } // sanitizeURL()
    }
}

?>
