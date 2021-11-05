-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

/*DROP TABLE IF EXISTS
	`:prefix:mod_catGallery_options`,
	`:prefix:mod_catGallery_images_options`,
	`:prefix:mod_catGallery_images`,
	`:prefix:mod_catGallery`;*/

CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery` (
	`gallery_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`section_id` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY ( `gallery_id` ),
	CONSTRAINT `:prefix:cCal_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE
) COMMENT='Main table for catGallery'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';

CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_options` (
	`gallery_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`value` TEXT,
	PRIMARY KEY ( `gallery_id`, `name` ),
	CONSTRAINT `:prefix:cG_Options` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_catGallery`(`gallery_id`) ON DELETE CASCADE
) COMMENT='Options for catGallery'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';


CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_images` (
	`image_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gallery_id` INT(11) UNSIGNED NULL DEFAULT NULL,
	`picture` VARCHAR(127) NOT NULL DEFAULT '',
	`published` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`position` INT(11) UNSIGNED NOT NULL,
	PRIMARY KEY ( `image_id` ),
	CONSTRAINT `:prefix:cG_Images` FOREIGN KEY (`gallery_id`) REFERENCES `:prefix:mod_catGallery`(`gallery_id`) ON DELETE CASCADE
) COMMENT='Image saved for catGallery'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';

CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_images_options` (
	`image_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`value` TEXT,
	`search` TEXT,
	PRIMARY KEY (`image_id`, `name` ),
	CONSTRAINT `:prefix:cG_ImageOptionsImg` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_catGallery_images`(`image_id`) ON DELETE CASCADE
) COMMENT='Image options'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';

CREATE TABLE IF NOT EXISTS `:prefix:mod_catGallery_contents`  (
	 `image_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
	 `content` TEXT,
	 `text` TEXT,
	 PRIMARY KEY ( `image_id` ),
	 CONSTRAINT `:prefix:cG_ImageOptionsContent` FOREIGN KEY (`image_id`) REFERENCES `:prefix:mod_catGallery_images`(`image_id`) ON DELETE CASCADE
) COMMENT='Individual content for images'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';

/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;