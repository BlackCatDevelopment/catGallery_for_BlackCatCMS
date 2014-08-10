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
 *   @author			Matthias Glienke
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

if ( ! class_exists( 'catGallery', false ) ) {
	class catGallery
	{
		protected static $gallery_id			= NULL;
		protected static $page_id				= NULL;
		protected static $section_id			= NULL;
		protected static $galleryFolder			= '';
		protected static $allowed_file_types	= array( 'png', 'jpg', 'jpeg', 'gif' );
		protected static $gallery_root			= '';
		protected static $galleryPATH			= '';
		protected static $galleryURL			= '';

		public $contents			= array();
		public $options				= array();
		public $module_variants		= array();

		public $easing	= array(
			'cube',
			'cubeRandom',
			'block',
			'cubeStop',
			'cubeHide',
			'cubeSize',
			'horizontal',
			'showBars',
			'showBarsRandom',
			'tube',
			'fade',
			'fadeFour',
			'paralell',
			'blind',
			'blindHeight',
			'blindWidth',
			'directionTop',
			'directionBottom',
			'directionRight',
			'directionLeft',
			'cubeStopRandom',
			'cubeSpread',
			'cubeJelly',
			'glassCube',
			'glassBlock',
			'circles',
			'circlesInside',
			'circlesRotate',
			'cubeShow',
			'upBars',
			'downBars',
			'hideBars',
			'swapBars',
			'swapBarsBack',
			'random',
			'randomSmart'
		);

		protected static $initOptions		= array(
			'variant'		=> 'default',
			'effect'		=> 'random',
			'animSpeed'		=> '500',
			'pauseTime'		=> '4000',
			'resize_x'		=> '781',
			'resize_y'		=> '350',
			'opacity'		=> '0.8'
		);

		public static function getInstance()
		{
			if (!self::$instance)
				self::$instance = new self();
			else
				self::reset();
			return self::$instance;
		}

		public function __construct( $gallery_id	= NULL )
		{
			global $page_id, $section_id;

			// This is a workaround for headers.inc.php as there is no $section_id defined yet
			if ( !isset($section_id) )
			{
				$section_id	= $gallery_id['section_id'];
			}

			self::$section_id	= intval($section_id);
			self::$page_id		= intval($page_id);

			if ( $gallery_id === true )
			{
				return $this->initAdd();
			}
			elseif ( is_numeric($gallery_id) )
			{
				self::$gallery_id	= $gallery_id;
			}
			elseif ( is_numeric($section_id) && $section_id > 0 )
			{
				$this->setGalleryID();
			}
			else return false;


			self::$gallery_root	= CAT_PATH . MEDIA_DIRECTORY . '/cc_catgallery/';
			self::$galleryPATH	= self::$gallery_root . 'cc_catgallery_' . self::$section_id;
			self::$galleryURL	= self::$gallery_root . 'cc_catgallery_' . self::$section_id;
		}

		public function __destruct() {}

		/**
		 * return, if in a current object all important values are existing (page_id, section_id, gallery_id)
		 *
		 * @access public
		 * @param  integer  $image_id - optional check for $image_id to be numeric
		 * @return boolean true/false
		 *
		 **/
		private function checkIDs( $image_id = NULL )
		{
			if ( !self::$section_id ||
				!self::$page_id ||
				!self::$gallery_id ||
				( $image_id && is_numeric( $image_id ) )
			) return false;
			else return true;
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
			if ( !self::$section_id || !self::$page_id ) return false;
			// Add a new catGallery
			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"INSERT INTO `%smod_cc_catgallery`
						( `page_id`, `section_id` ) VALUES
						( '%s', '%s' )",
					CAT_TABLE_PREFIX,
					intval(self::$page_id),
					intval(self::$section_id)
				)
			) )
			{
				$return	= true;
				$this->setGalleryID();

				// Add initial options for gallery
				foreach( self::$initOptions as $name => $val )
				{
					if( !$this->saveOptions( $name, $val ) )
						$return	= false;
				}

				if ( $return &&
					CAT_Helper_Directory::getInstance()->createDirectory( $this->getFolder(), NULL, true ) )
					return self::$gallery_id;
				else
					return false;
			}
			else return false;
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
			if( !$this->checkIDs() ) return false;

			$return	= true;

			foreach(
				array( 'catgallery', 'catgallery_options', 'catgallery_images', 'catgallery_images_options', 'catgallery_contents' )
				as $table )
			{
				// Delete complete record from the database
				if( !CAT_Helper_Page::getInstance()->db()->query( sprintf(
						"DELETE FROM `%smod_cc_%s`
							WHERE `section_id` = '%s' AND
								`gallery_id` = '%s'",
						CAT_TABLE_PREFIX,
						$table,
						self::$section_id,
						self::$gallery_id
					)
				) ) $return = false;
			}
			// Delete folder
			if ( $return )
				if( CAT_Helper_Directory::getInstance()->removeDirectory( $this->getFolder() ) );
					else return true;
				else return false;
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
		private function addImg( $file_extension = NULL)
		{
			if ( !$this->checkIDs() ||
				!$file_extension ) return false;

			if( CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"INSERT INTO `%smod_cc_%s`
						( `page_id`, `section_id`, `gallery_id` ) VALUES
						( '%s', '%s', '%s' )",
					CAT_TABLE_PREFIX,
					'catgallery_image',
					self::$page_id,
					self::$section_id,
					self::$gallery_id
				)
			) )
			{
				$newID		= CAT_Helper_Page::getInstance()->db()->get_one( 'SELECT LAST_INSERT_ID()' );
				$picture	= sprintf( 'image_%s_%s.%s', self::$section_id, $newId, $file_extension );

				if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
							"UPDATE `%smod_cc_%s`
								SET `picture` = '%s'
								WHERE `image_id` = '%s' AND
									`gallery_id` = '%s'",
							CAT_TABLE_PREFIX,
							'catgallery_image',
							$picture,
							$newId,
							self::$gallery_id
						)
					)
				) return array( 'image_id' => $newID, 'picture' => $picture );
			}
			else return false;
		}



		/**
		 * remove image
		 *
		 * @access public
		 * @param  string  $image_id - ID of image that should be removed
		 * @return boolean
		 *
		 **/
		public function removeImage( $image_id = NULL )
		{
			if ( !$this->checkIDs( $image_id ) ) return false;

			foreach(
				array( 'catgallery_images', 'catgallery_images_options', 'catgallery_contents' )
				as $table )
			{
				// Delete complete record from the database
				if( !CAT_Helper_Page::getInstance()->db()->query( sprintf(
						"DELETE FROM `%smod_cc_%s`
							WHERE `image_id` = '%s' AND
								`section_id` = '%s' AND
								`gallery_id` = '%s'",
						CAT_TABLE_PREFIX,
						$table,
						$image_id,
						self::$section_id,
						self::$gallery_id
					)
				) ) $return = false;
			}

			// Delete folder
			if ( $return )
			{
				if( file_exists( $this->getFolder() . '/' . $image_id ) )
					unlink( $this->getFolder() . '/' . $image_id );
				return true;
			}
			else return false;
		}

		/**
		 * set the $gallery_id by self:$sectionid
		 *
		 * @access private
		 * @return integer
		 *
		 **/
		private function setGalleryID()
		{
			// Get columns in this section
			self::$gallery_id		= CAT_Helper_Page::getInstance()->db()->get_one( sprintf(
					"SELECT `gallery_id`
						FROM `%smod_cc_catgallery`
						WHERE `section_id` = '%s'",
					CAT_TABLE_PREFIX,
					self::$section_id
				)
			);
			return self::$gallery_id;
		} // end setGalleryID()


		/**
		 * get all images from database
		 *
		 * @access public
		 * @param  boolean  $addOptions - add options of an image
		 * @param  boolean  $addContent - add content of an image
		 * @return array()
		 *
		 **/
		public function getImages( $addOptions = true, $addContent = true )
		{
			if ( !$this->checkIDs() ) return false;

			// Get images from database
			$images		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"SELECT * FROM %smod_%s
						WHERE `section_id` = '%s'",
					CAT_TABLE_PREFIX,
					'cc_catgallery_images',
					self::$section_id
				)
			);

			if ( isset($images) && $images->numRows() > 0 )
			{
				while( !false == ( $row = $images->fetchRow( MYSQL_ASSOC ) ) )
				{
					$this->images[$row['image_id']]	= array(
						'image_id'			=> $row['image_id'],
						'picture'			=> $row['picture'],
						'options'			=> $addOptions ? $this->getImgOptions( $row['image_id'] ) : NULL,
						'image_content'		=> $addContent ? $this->getImgContent( $row['image_id'] ) : NULL,
						'contentname'		=> 'image_content_' . $row['image_id']
					);
				}
			} else return false;
			return $this->images;
		} // end getContents()


		/**
		 * get option of an image
		 *
		 * @access public
		 * @param  string  $image_id - optional id of an image
		 * @return array()
		 *
		 **/
		private function getImgOptions( $image_id = NULL )
		{
			if ( !self::$section_id ) return false;

			$select	= '';

			if ( !$image_id && count( $this->images ) > 0 )
			{
				foreach ( array_keys( $this->images ) as $id )
				{
					$select	.= " OR `image_id` = '" . intval( $id ) . "'";
				}
				$select		= "AND (" . substr( $select, 3 ) . ")";
			}
			elseif ( $image_id )
			{
				$select		= "AND `image_id` = '" . intval( $image_id ) . "'";
			}
			else return false;

			$opts	= CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"SELECT * FROM `%smod_%s`
						WHERE `section_id` = '%s'%s",
					CAT_TABLE_PREFIX,
					'cc_catgallery_images_options',
					self::$section_id,
					$select
				)
			);

			$options	= array();

			if ( isset($opts) && $opts->numRows() > 0)
			{
				while( !false == ($row = $opts->fetchRow( MYSQL_ASSOC ) ) )
				{
					$options[$row['image_id']][$row['name']]		= $row['value'];

					if ( isset($this->images[$row['image_id']]['options']) )
						$this->images[$row['image_id']]['options']	= array_merge(
							$this->images[$row['image_id']]['options'],
							array(
								$row['name']		=> $row['value']
							)
						);
					else $this->images[$row['image_id']]['options']	= array(
							$row['name']	=> $row['value']
						);

				}
			}
			if ( $image_id )
				return $this->images[$image_id]['options'];
			else
				return $options;
		} // end getImgOptions()

		/**
		 * get content of an image
		 *
		 * @access public
		 * @param  string  $image_id - optional id of an image
		 * @return array()
		 *
		 **/
		private function getImgContent( $image_id = NULL )
		{
			if ( !$this->checkIDs( $image_id ) ) return false;

			$select	= '';

			if ( !$image_id && count( $this->images ) > 0 )
			{
				foreach ( array_keys( $this->images ) as $id )
				{
					$select	.= " OR `image_id` = '" . intval( $id ) . "'";
				}
				$select		= "AND (" . substr( $select, 3 ) . ")";
			}
			elseif ( $image_id )
			{
				$select		= "AND `image_id` = '" . intval( $image_id ) . "'";
			}
			else return false;

			$conts	= CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"SELECT `content` FROM `%smod_%s`
						WHERE `section_id` = '%s' AND
							`gallery_id` = '%s'%s",
					CAT_TABLE_PREFIX,
					'mod_cc_catgallery_contents',
					self::$section_id,
					self::$gallery_id,
					$select
				)
			);

			$contents	= array();

			if ( isset($conts) && $conts->numRows() > 0)
			{
				while( !false == ($row = $conts->fetchRow( MYSQL_ASSOC ) ) )
				{
					$contents[$row['image_id']]['content']		= $row['content'];
					$this->images[$row['image_id']]['content']	= $row['content'];
				}
			}
			if ( $image_id )
				return $this->images[$image_id]['content'];
			else
				return $contents;
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
		public function saveImages( $counter = NULL, $tmpFiles )
		{
			if ( !$this->checkIDs( $counter ) ) return false;

			$return	= true;

			for ( $file_id = 1; $file_id <= $counter; $file_id++  )
			{
				$field_name	= 'new_image_' . $file_id;
			
				if ( isset( $tmpFiles[$field_name]['name'] ) && $tmpFiles[$field_name]['name'] != '' )
				{
					// =========================================== 
					// ! Get file extension of the uploaded file   
					// =========================================== 
					$file_extension	= (strtolower( pathinfo( $tmpFiles[$field_name]['name'], PATHINFO_EXTENSION ) ) == '')
								? false
								: strtolower( pathinfo($tmpFiles[$field_name]['name'], PATHINFO_EXTENSION))
								;
					// ====================================== 
					// ! Check if file extension is allowed   
					// ====================================== 
					if ( isset( $file_extension ) && in_array( $file_extension, $allowed_file_types ) )
					{
						if ( ! is_array($tmpFiles) || ! count($tmpFiles) )
						{
							echo CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('No files!');
						}
						else
						{
							$current = CAT_Helper_Upload::getInstance( $tmpFiles[$field_name] );
							if ( $current->uploaded )
							{
								$current->file_overwrite		= false;
								$current->process( self::$gallery_root . '/temp/' );
					
								if ( $current->processed )
								{
									$addImg	= $this->addImg( $file_extension );

									if ( !CAT_Helper_Image::getInstance()->make_thumb(
										self::$gallery_root . '/temp/' . $current->file_dst_name,
										$this->getFolder() . '/' . $addImg['picture'],
										1600,//$resize_y,
										1600,//$resize_x,
										'fit'
									) ) $return	= false;

									unlink(self::$gallery_root . '/temp/' . $current->file_dst_name);

									// =================================
									// ! Clean the upload class $files
									// =================================
									$current->clean();

								}
								else
								{
									$return	= false;
									echo CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
								}
							}
							else
							{
								$return	= false;
								echo CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
							}
						}
					}
				}
			}
		} // end saveImages()

		/**
		 * get content of an image
		 *
		 * @access public
		 * @param  string  $image_id - optional id of an image
		 * @return array()
		 *
		 **/
		private function saveImage( $counter = NULL, $tmpFiles )
		{
			
		} // saveImage()

		/**
		 * save content for single image
		 *
		 * @access public
		 * @param  string		$image_id - id of image
		 * @param  string		$content - content to save
		 * @return bool true/false
		 *
		 **/
		public function saveContent( $image_id = NULL, $content = '' )
		{
			if ( !$this->checkIDs( $image_id ) ) return false;

			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"UPDATE `%smod_cc_%s`
						SET `content` = '%s',
							`text` = '%s'
						WHERE `gallery_id` = '%s' AND
							`image_id` = '%s'",
					CAT_TABLE_PREFIX,
					'catgallery_contents',
					$this->toSQL( $content ),
					umlauts_to_entities( strip_tags( $content ), strtoupper(DEFAULT_CHARSET), 0),
					self::$gallery_id,
					$image_id
				)
			) ) return true;
			else return false;

		} // end saveContent()

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
		public function saveImgOptions( $image_id = NULL, $name = NULL, $value = '' )
		{
			if( !$this->checkIDs( $image_id ) ||
					!$name ) return false;
			
			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"REPLACE INTO `%smod_cc_%s`
						SET `page_id`		= '%s',
							`section_id`	= '%s',
							`column_id`		= '%s',
							`name`			= '%s',
							`value`			= '%s'",
					CAT_TABLE_PREFIX,
					'mod_cc_catgallery_images_options',
					self::$page_id,
					self::$section_id,
					intval( $image_id ),
					$this->toSQL( $name ),
					$this->toSQL( $value )
				)
			) ) return true;
			else return false;

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
		public function getOptions( $name = NULL )
		{
			if ( !$this->checkIDs() ) return false;
			if ( $name && isset($this->options[$name]) ) return $this->options[$name];

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"SELECT * FROM `%smod_cc_%s`
						WHERE `section_id` = '%s' AND
							`gallery_id` = '%s'%s",
					CAT_TABLE_PREFIX,
					'catgallery_options',
					self::$section_id,
					self::$gallery_id,
					$name ? " AND `name` = '" . $this->toSQL( $name ) . "'" : ""
				)
			);

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow( MYSQL_ASSOC ) ) )
				{
					$this->options[$row['name']]	= $row['value'];
				}
			}
			if ( $name )
			{
				if ( isset( $this->options[$name] ) )
					return $this->options[$name];
				else
					return NULL;
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
		public function saveOptions( $name = NULL, $value = '' )
		{
			if ( !$this->checkIDs() ||
				!$name
			) return false;

			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"REPLACE INTO `%smod_%s` SET
						`page_id`		= '%s',
						`section_id`	= '%s',
						`gallery_id`	= '%s',
						`name`			= '%s',
						`value`			= '%s'",
					CAT_TABLE_PREFIX,
					'cc_catgallery_options',
					self::$page_id,
					self::$section_id,
					self::$gallery_id,
					$this->toSQL( $name ),
					$this->toSQL( $value )
				)
			) ) return true;
			else return false;
		} // end saveOptions()




		/**
		 *
		 * @access public
		 * @return
		 * NEEDS TO BE REWORKED TO BE COMPATIBLE TO PHP 5.5!!!
		 **/
		private function toSQL( $value )
		{
			if ( !is_string( $value ) ) return $value;

			if ( get_magic_quotes_gpc() == 1 )
				return mysql_real_escape_string( stripslashes( $value ) );
			else {
				return mysql_real_escape_string( $value );
			}

			return NULL;
		}   // end function toSQL()


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
			if ( isset( $this->options['_variant'] ) )
				return $this->options['_variant'];

			$this->getModuleVariants();
			$this->getOptions('variant');

			$variant	= $this->options['variant'] != ''
				&& isset($this->module_variants[$this->options['variant']]) ?
						$this->module_variants[$this->options['variant']] : 
						'default';

			$this->options['_variant']	= $variant;

			return $this->options['_variant'];
		} // getVariant()


		/**
		 * get all possible variants for gallery
		 *
		 * @access public
		 * @return array
		 *
		 **/
		public function getModuleVariants()
		{
			if ( count($this->module_variants) > 0 ) return $this->module_variants;
			$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/cc_catgallery/' );

			$this->module_variants	= $getInfo['module_variants'];

			return $this->module_variants;
		} // getModuleVariants()


		/**
		 * get folder path/url for gallery
		 *
		 * @access public
		 * @param  boolean	$path - true (default) for getting folder path/ false for getting url
		 * @return string
		 *
		 **/
		public function getFolder( $path = true )
		{
			if ( $path )
				return self::$galleryPATH;
			else
				return self::$galleryURL;
		} // getFolder()

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
		public function sanitizeURL( $url = NULL )
		{
			if ( !$url ) return false;
			$parts	= array_filter( explode( '/', $url ) );
			return	implode('/', $parts);
		} // sanitizeURL()

	}
}

?>