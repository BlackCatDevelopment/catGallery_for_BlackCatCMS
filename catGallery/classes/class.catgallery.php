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
		private static $instance;
		protected static $gallery_id			= NULL;
		protected static $page_id				= NULL;
		protected static $section_id			= NULL;
		protected static $galleryFolder			= '';
		protected static $allowed_file_types	= array( 'png', 'jpg', 'jpeg', 'gif' );
		protected static $gallery_root			= '';
		protected static $thumb_x				= 300;
		protected static $thumb_y				= 200;
		protected $imagePATH			= NULL;
		protected $imageURL				= NULL;
		protected $galleryPATH			= '';
		protected $galleryURL			= '';

		public $contents			= array();
		public $options				= array();
		public $module_variants		= array();

		public $effects	= array(
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
			'variant'		=> '0',
			'effect'		=> 'random',
			'random'		=> '0',
			'animSpeed'		=> '500',
			'pauseTime'		=> '4000',
			'label'			=> '0',
			'resize_x'		=> '781',
			'resize_y'		=> '350'
		);

		public static function getInstance()
		{
			if (!self::$instance)
				self::$instance	= new self();
			return self::$instance;
		}

		public function __construct( $gallery_id = NULL, $is_header = false )
		{
			global $page_id, $section_id;
			require_once(CAT_PATH . '/framework/functions.php');
			// This is a workaround for headers.inc.php as there is no $section_id defined yet
			if ( !isset($section_id) || $is_header )
			{
				$section_id	= is_numeric($gallery_id) ? $gallery_id : $gallery_id['section_id'];
			}

			$this->setPageID( intval($page_id) );
			$this->setSectionID( intval($section_id) );

			if ( $gallery_id === true )
			{
				$this->initAdd();
			}
			elseif ( is_numeric($gallery_id) && !$is_header )
			{
				self::$gallery_id	= $gallery_id;
			}
			elseif ( is_numeric($section_id) && $section_id > 0 )
			{
				$this->setGalleryID();
			}
			else return false;
		}


		/**
		 * set the $page_id
		 */
		public function setPageID( $page_id )
		{
			self::$page_id		= intval($page_id);
			$this->setGalleryFolder();
			return $this;
		}
		
		/**
		 * set the $section_id
		 */
		public function setSectionID( $section_id )
		{
			self::$section_id	= intval($section_id);
			$this->setGalleryFolder();
			return $this;
		}

		/**
		 * set the $gallery_root, galleryPATH and galleryURL if section_id or page_id is changed
		 */
		private function setGalleryFolder()
		{
			self::$gallery_root	= CAT_PATH . MEDIA_DIRECTORY . '/cc_catgallery/';
			$this->galleryPATH	= self::$gallery_root . 'cc_catgallery_' . self::$section_id;
			$this->galleryURL	= CAT_URL . MEDIA_DIRECTORY . '/cc_catgallery/cc_catgallery_' . self::$section_id;
			return $this;
		}

		/**
		 * set the $gallery_id by self:$sectionid
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		public function setGalleryID()
		{
			// Get columns in this section
			$gallery_id	= CAT_Helper_Page::getInstance()->db()->query(
					'SELECT `gallery_id`
						FROM `:prefix:mod_cc_catgallery`
						WHERE `page_id` = :page_id AND
							`section_id` = :section_id',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id
				)
			)->fetchColumn();

			self::$gallery_id	= $gallery_id;
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
			if ( !self::$gallery_id )
				$this->setGalleryID();
			return self::$gallery_id;
		} // end getGalleryID()

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
				( $image_id && !is_numeric( $image_id ) )
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

			if( !file_exists( self::$gallery_root ) )
			{
				CAT_Helper_Directory::getInstance()->createDirectory( self::$gallery_root, NULL, true );
				CAT_Helper_Directory::getInstance()->createDirectory( self::$gallery_root . '/temp/', NULL, true );				
			}
			// Add a new catGallery
			if ( CAT_Helper_Page::getInstance()->db()->query(
					'INSERT INTO `:prefix:mod_cc_catgallery`
						( `page_id`, `section_id` ) VALUES
						( :page_id, :section_id )',
					array(
						'page_id'		=> self::$page_id,
						'section_id'	=> self::$section_id
					)
				)
			) {
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
						'DELETE FROM `:prefix:mod_cc_%s`
							WHERE `section_id` = :section_id AND
								`gallery_id` = :gallery_id',
						$table
					),
					array(
						'section_id'	=> self::$section_id,
						'gallery_id'	=> self::$gallery_id
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
			
			$getPos	= CAT_Helper_Page::getInstance()->db()->query(
				'SELECT MAX(position) AS pos FROM `:prefix:mod_cc_catgallery_images`
					WHERE `page_id` = :page_id
						AND `section_id` = :section_id
						AND `gallery_id` = :gallery_id',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'gallery_id'	=> self::$gallery_id
				)
			);
			if ( $getPos && $getPos->rowCount() > 0 )
			{
				if( !false == ( $pos = $getPos->fetch() ) )
				{
					$position	= $pos['pos'] + 1;
				}
			}


			if( CAT_Helper_Page::getInstance()->db()->query(
					'INSERT INTO `:prefix:mod_cc_catgallery_images`
						( `page_id`, `section_id`, `gallery_id`, `position` ) VALUES
						( :page_id, :section_id, :gallery_id, :position )',
					array(
						'page_id'		=> self::$page_id,
						'section_id'	=> self::$section_id,
						'gallery_id'	=> self::$gallery_id,
						'position'		=> $position
					)
				)
			) {
				$newID		= CAT_Helper_Page::getInstance()->db()->lastInsertId();
				$picture	= sprintf( 'image_%s_%s.%s', self::$section_id, $newID, $file_extension );

				if ( CAT_Helper_Page::getInstance()->db()->query(
							'UPDATE `:prefix:mod_cc_catgallery_images`
								SET `picture` = :picture
								WHERE `image_id` = :image_id AND
									`gallery_id` = :gallery_id',
							array(
								'picture'		=> $picture,
								'image_id'		=> $newID,
								'gallery_id'	=> self::$gallery_id
							)
						)
					&& $this->saveContent( $newID, '' )
				) return array(
					'image_id'	=> $newID,
					'picture'	=> $picture,
					'position'	=> $position,
					'check'		=> $getPos
				);
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

			if( !isset($this->images[$image_id]) )
				$this->getImage($image_id);

			$return	= true;

			foreach(
				array( 'catgallery_images', 'catgallery_images_options', 'catgallery_contents' )
				as $table )
			{
				// Delete complete record from the database
				if( !CAT_Helper_Page::getInstance()->db()->query( sprintf(
						'DELETE FROM `:prefix:mod_cc_%s`
							WHERE `image_id` = :image_id AND
								`section_id` = :section_id AND
								`gallery_id` = :gallery_id',
							$table
						),
						array(
							'image_id'		=> $image_id,
							'section_id'	=> self::$section_id,
							'gallery_id'	=> self::$gallery_id
						)
					)
				) $return = false;
			}

			// Delete folder
			if ( $return
				&& $this->images[$image_id]['picture'] != '' )
			{
				$checkFiles	= CAT_Helper_Directory::getInstance()->scanDirectory(
					$this->getFolder(),
					true,
					true,
					NULL,
					array(),
					array(),
					array( 'index.php' )
				);
				foreach( $checkFiles as $path )
				{
					$arr	= explode('/', $path);
					if( array_pop($arr) == $this->images[$image_id]['picture']
						&& !unlink( $path ) )
						$return = false;
				}
				return $return;
			}
			else return false;
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
		public function getImage( $image_id = NULL, $addOptions = true, $addContent = true )
		{
			if ( !$this->checkIDs() ) return false;

			// Get images from database
			$images		= $image_id && is_numeric($image_id) ?
			CAT_Helper_Page::getInstance()->db()->query(
				'SELECT * FROM `:prefix:mod_cc_catgallery_images`
					WHERE `gallery_id` = :gallery_id AND
						`section_id` = :section_id AND
						`image_id` = :image_id',
				array(
					'gallery_id'	=> self::$gallery_id,
					'section_id'	=> self::$section_id,
					'image_id'		=> $image_id
				)
			)
			: CAT_Helper_Page::getInstance()->db()->query(
				'SELECT * FROM `:prefix:mod_cc_catgallery_images`
					WHERE `gallery_id` = :gallery_id AND
						`section_id` = :section_id
						ORDER BY `position`',
				array(
					'gallery_id'	=> self::$gallery_id,
					'section_id'	=> self::$section_id
				)
			);

			$tmp_path	= sprintf( '%s/thumbs_%s_%s/',
						$this->getFolder(), $this->getOptions('resize_x'), $this->getOptions('resize_y') );
			$thumb_path	= sprintf( '%s/thumbs_%s_%s/',
						$this->getFolder(), self::$thumb_x, self::$thumb_y );
			$thumb_url	= sprintf( '%s/thumbs_%s_%s/',
						$this->getFolder(false), self::$thumb_x, self::$thumb_y );


			if ( $images && $images->rowCount() > 0 )
			{
				while( !false == ( $row = $images->fetch() ) )
				{
					$this->images[$row['image_id']]	= array(
						'image_id'			=> $row['image_id'],
						'position'			=> $row['position'],
						'picture'			=> $row['picture'],
						'options'			=> $addOptions ? $this->getImgOptions( $row['image_id'] ) : NULL,
						'image_content'		=> $addContent ? $this->getImgContent( $row['image_id'] ) : NULL,
						'contentname'		=> 'image_content_' . $row['image_id'],
						'thumb'				=> $thumb_url . $row['picture']
					);
					
					if( !file_exists( $tmp_path . $row['picture'] ) )
						$this->createImg( $row['image_id'] );
					if( !file_exists( $thumb_path . $row['picture'] ) )
						$this->createImg( $row['image_id'], self::$thumb_x, self::$thumb_y );
				}
			} else return false;

			if ($image_id && is_numeric($image_id))
				return $this->images[$image_id];
			else {
				if ( $this->getOptions( 'random' ) == 1 )
					shuffle( $this->images );
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
		private function getImgOptions( $image_id = NULL )
		{
			if ( !$this->checkIDs() ) return false;

			$select	= '';

			if ( $image_id
				&& isset($this->images[$image_id]['options']))
					return $this->images[$image_id]['options'];


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
					'SELECT * FROM `:prefix:mod_cc_catgallery_images_options`
							WHERE `section_id` = :section_id %s',
					$select
				),
				array(
					'section_id'	=> self::$section_id
				)
			);

			$options							= array();
			if ( $image_id )
				$this->images[$image_id]['options']	= array();

			if ( $opts && $opts->rowCount() > 0)
			{
				while( !false == ($row = $opts->fetch() ) )
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
					'SELECT `content`, `image_id` FROM `:prefix:mod_cc_catgallery_contents`
						WHERE `section_id` = :section_id AND
							`gallery_id` = :gallery_id %s',
					$select
				),
				array(
					'section_id'		=> self::$section_id,
					'gallery_id'	=> self::$gallery_id
				)
			);

			$contents	= array();

			if ( $conts && $conts->rowCount() > 0)
			{
				while( !false == ($row = $conts->fetch() ) )
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
		public function saveImages( $tmpFiles = NULL )
		{
			if ( !$this->checkIDs() ) return false;

				$field_name	= 'new_image';

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
				if ( isset( $file_extension ) && in_array( $file_extension, $this->getAllowed() ) )
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

								$this->createImg( $addImg['image_id'], self::$thumb_x, self::$thumb_y );

								$addImg['thumb']	= sprintf( '%s/thumbs_%s_%s/',
									$this->galleryURL,
									self::$thumb_x,
									self::$thumb_y ) . $addImg['picture'];

								unlink(self::$gallery_root . '/temp/' . $current->file_dst_name);

								// =================================
								// ! Clean the upload class $files
								// =================================
								$current->clean();
								return $addImg;
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
		public function createImg( $image_id = NULL, $resize_x = NULL, $resize_y = NULL )
		{
			if ( !$this->checkIDs($image_id) ) return false;

			$tmp_path	= ($resize_x && $resize_y) && ( is_numeric($resize_x) && is_numeric($resize_y) )
				? CAT_Helper_Directory::getInstance()->sanitizePath(
					sprintf( '%s/thumbs_%s_%s/',
						$this->galleryPATH, $resize_x, $resize_y
					)
				) : $this->getImageURL( true );

			if ( !file_exists($tmp_path) )
				CAT_Helper_Directory::getInstance()->createDirectory( $tmp_path, NULL, true );
				
			if ( !isset( $this->images[$image_id] ) )
				$this->getImage( $image_id );

			$image		= $this->images[$image_id]['picture'];

			$resize_x	= isset($resize_x) ? $resize_x : $this->getOptions('resize_x');
			$resize_y	= isset($resize_y) ? $resize_y : $this->getOptions('resize_y');

			CAT_Helper_Image::getInstance()->make_thumb(
				$this->getFolder() . '/' . $image,
				$tmp_path . '/' . $image,
				$resize_y,
				$resize_x,
				'crop'
			);
			return array(
				'path'	=> $tmp_path . '/' . $image,
				'url'	=> str_replace( CAT_PATH, CAT_URL, $tmp_path ) . '/' . $image,
			);
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
		public function saveContent( $image_id = NULL, $content = '' )
		{
			if ( !$this->checkIDs( $image_id ) ) return false;

			if ( CAT_Helper_Page::getInstance()->db()->query(
				'REPLACE INTO `:prefix:mod_cc_catgallery_contents`
					SET `gallery_id`	= :gallery_id,
						`page_id`		= :page_id,
						`section_id`	= :section_id,
						`image_id`		= :image_id,
						`content`		= :content,
						`text`			= :text',
				array(
					'gallery_id'	=> self::$gallery_id,
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'image_id'		=> $image_id,
					'content'		=> $content,
					'text'			=> umlauts_to_entities( strip_tags( $content ), strtoupper(DEFAULT_CHARSET), 0),
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

			if ( CAT_Helper_Page::getInstance()->db()->query(
				'REPLACE INTO `:prefix:mod_cc_catgallery_images_options`
					SET `section_id`	= :section_id,
						`gallery_id`	= :gallery_id,
						`image_id`		= :image_id,
						`name`			= :name,
						`value`			= :value',
				array(
					'section_id'	=> self::$section_id,
					'gallery_id'	=> self::$gallery_id,
					'image_id'		=> $image_id,
					'name'			=> $name,
					'value'			=> $value
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

			$getOptions		= $name ? 
				CAT_Helper_Page::getInstance()->db()->query(
					'SELECT * FROM `:prefix:mod_cc_catgallery_options`
						WHERE `section_id` = :section_id AND
							`gallery_id` = :gallery_id AND
							`name` = :name',
					array(
						'section_id'	=> self::$section_id,
						'gallery_id'	=> self::$gallery_id,
						'name'			=> $name
					)
				) : 
				CAT_Helper_Page::getInstance()->db()->query(
					'SELECT * FROM `:prefix:mod_cc_catgallery_options`
						WHERE `section_id` = :section_id AND
							`gallery_id` = :gallery_id',
					array(
						'section_id'	=> self::$section_id,
						'gallery_id'	=> self::$gallery_id
					)
			);

			if ( $getOptions && $getOptions->rowCount() > 0)
			{
				while( !false == ($row = $getOptions->fetch() ) )
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

			if ( CAT_Helper_Page::getInstance()->db()->query(
				'REPLACE INTO `:prefix:mod_cc_catgallery_options`
					SET `gallery_id`	= :gallery_id,
						`page_id`		= :page_id,
						`section_id`	= :section_id,
						`name`			= :name,
						`value`			= :value',
				array(
					'gallery_id'	=> self::$gallery_id,
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'name'			=> $name,
					'value'			=> is_null($value) ? '' : $value
				)
			) ) return true;
			else return false;
		} // end saveOptions()

		/**
		 * reorder images
		 *
		 * @access public
		 * @param  array			$imgIDs - Strings from jQuery sortable()
		 * @return bool true/false
		 *
		 **/
		public function reorderImg( $imgIDs = array() )
		{
			if ( !$this->checkIDs()
				|| !is_array($imgIDs)
				|| count($imgIDs) == 0
			) return false;

			$return	= true;

			foreach( $imgIDs as $index => $imgStr )
			{
				$imgID	= explode('_', $imgStr);

				if( !CAT_Helper_Page::getInstance()->db()->query(
					'UPDATE `:prefix:mod_cc_catgallery_images`
						SET `position` = :position
						WHERE `gallery_id`		= :gallery_id
							AND `page_id`		= :page_id
							AND `section_id`	= :section_id
							AND `image_id`		= :image_id',
					array(
						'position'		=> $index,
						'gallery_id'	=> self::$gallery_id,
						'page_id'		=> self::$page_id,
						'section_id'	=> self::$section_id,
						'image_id'		=> $imgID[count($imgID)-1]
					)
				) ) $return = false;
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
		 * get all possible variants for gallery
		 *
		 * @access public
		 * @return array
		 *
		 **/
		public function countImg()
		{
			if ( isset( $this->images ) ) return count($this->images);
			else return 0;
		} // countImg()


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
				return $this->galleryPATH;
			else
				return $this->galleryURL;
		} // getFolder()

		/**
		 * get folder path/url for gallery
		 *
		 * @access public
		 * @param  boolean	$path - true (default) for getting folder path/ false for getting url
		 * @return string
		 *
		 **/
		public function getImageURL( $path = false )
		{
			if ( $path )
			{
				if ( !$this->imagePATH || $this->imagePATH == '' )
					$this->imagePATH	= CAT_Helper_Directory::getInstance()->sanitizePath(
						sprintf( '%s/thumbs_%s_%s/',
							$this->galleryPATH, $this->getOptions('resize_x'), $this->getOptions('resize_y')
						)
					);
				return $this->imagePATH;
			}
			else
				if ( !$this->imageURL || $this->imageURL == '' )
					$this->imageURL	= sprintf( '%s/thumbs_%s_%s/',
						$this->galleryURL, $this->getOptions('resize_x'), $this->getOptions('resize_y') );
				return $this->imageURL;
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