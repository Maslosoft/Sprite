<?php

namespace Maslosoft\Sprite;

use CApplicationComponent;
use CException;
use CFileHelper;
use Closure;
use Yii;

/**
 * MSprite class file.
 *
 * @author Steven OBrien <steven.obrien@newicon.net>
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 * @link http://www.newicon.net/
 * @link http://maslosoft.com Maslosoft
 * @copyright Copyright &copy; 2008-2011 Newicon Ltd
 * @copyright 2013 Maslosoft http://maslosoft.com
 * @license http://www.yiiframework.com/license/
 * @version 2.0.0
 */

/**
 * generate a sprite from the icon set
 * Principles of operation: (or... how to use it)
 * So you have lots of icons and images floating around. 
 * - famfamfam (http://famfamfam.com)
 * - fugue (http://p.yusukekamiyamane.com/) (https://github.com/yusukekamiyamane/fugue-icons)
 * 
 * famfamfam icon set is great and ubiquitous on the web, and comes with a few thousand 
 * icons then there is the fugue icon set which is excellent as well, this has even more.
 * I typically use a few of these icons in all my projects but usually only a handful.
 * So...
 * 
 * Goals of this class.
 * - I specify which out of a bunch of icons I use in my application
 * - This class generates a nice sprite.png file with all the images together
 * - This class generates a nice sprite.css file with all the necessary classes
 *   following the convention: .icon .name-of-icon 
 *   some notes on naming. All underscores in image names are converted to "-" 
 *   for the css classes, (can't stand "_" in css class names, is this just me?)
 *   the extension is removed. if the file is in a folder heirachy 
 *   then this is reflected in the naming, for example .icon .folder-icon-name
 * - it then, like a true gentleman, publishes them for me, using the yii asset manager
 * - if you ad more images simple delete the asset folder and next page refrsh 
 *   a new sprite will spawn into existence
 * - Bob is now your uncle.
 * 
 * @property $cssParentClass
 * @property $sprites populated automatically if empty
 * @property mixed $imageFolderPath
 * @author Steven OBrien <steven.obrien@newicon.net>
 * @package nii
 */
class Generator extends CApplicationComponent
{

	/**
	 * This defines the parent class to use on all elements that use the icon sprite
	 * for example defining an icon to apear on an element you would write the
	 * following: class="icon name-of-icon"
	 *
	 * @property string
	 */
	public $cssSpriteClass = 'sprite';

	/**
	 * class name of convienent icon class, works for the famfamfam and fugue icon sets
	 * easilly display an icon inline that is size 16x16
	 * @var type 
	 */
	public $cssIconClass = 'icon';
	public $cssIconPrefix = '';

	/**
	 * array of image paths relative to the MSprite::$imageFolderPath to include in the sprite, without a preceeding slash
	 * this is automatically populated if empty, by MSprite::findFiles()
	 * @property array 
	 */
	public $sprites = array();

	/**
	 * Stores the path to the folder where the individual images that
	 * will be included in the spite are kept.
	 * can be an array of imagefolder paths
	 * @property mixed
	 */
	public $imageFolderPath;

	/**
	 * Name of executable for png optimizer, if emty, no optimizer will be used
	 * @var string
	 */
	public $optimizer = 'pngcrush';

	/**
	 * array of all image data
	 * @var array
	 */
	private $_images = array();

	/**
	 * get the filepath to the components asset folder
	 * 
	 * @return string
	 */
	public function getAssetFolder()
	{
		return Yii::app()->getRuntimePath() . '/MSprite';
	}

	/**
	 * get the url path to the sprite.css file
	 * 
	 * @return string 
	 */
	public function getSpriteCssFile()
	{
		return $this->getAssetsUrl() . '/sprite.css';
	}

	/**
	 * gets the url to the components published assets folder
	 * if the assets folder does not exist it wil re generate the sprite
	 * and publish the assets folder
	 * 
	 * @return string 
	 */
	public function getAssetsUrl()
	{
// check if we need to generate the sprite
// if the asset folder exists we will assume we do not
// want to regenerate the sprite
		if (!file_exists($this->getAssetFolder()) || !file_exists($this->getPublishedAssetsPath() . '/sprite.png'))
		{
			$this->generate();
		}
		return Yii::app()->getAssetManager()->publish($this->getAssetFolder(), null, null, null);
	}

	/**
	 * uses CClientScript to register the sprite css script
	 */
	public function registerSpriteCss()
	{
//		$this->getAssetsUrl();
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/sprite.css');
	}

	public function reset()
	{
		$folder = $this->getAssetFolder();
		@unlink(sprintf('%s/sprite.css', $folder));
		@unlink(sprintf('%s/sprite.png', $folder));
	}

	/**
	 * returns the file path to the published asset folder, 
	 * - if $publish is false it will not publish the asset folder
	 *   and will return the correct file path
	 * - if $publish is true then it will publish the folder
	 * 
	 * @param boolean $publish default true
	 * @return string the published asset folder file path
	 */
	public function getPublishedAssetsPath()
	{
		$a = Yii::app()->getAssetManager();
		return $a->getPublishedPath($this->getAssetFolder());
	}

	/**
	 * Generates the sprite.png and sprite.css files and publishes
	 * them to theappropriate published assets folder
	 * 
	 * @return void
	 */
	public function generate()
	{
// publish the path
		if (empty($this->sprites))
			$this->findFiles();
		if (!file_exists($this->getAssetFolder()))
		{
			mkdir($this->getAssetFolder());
		}
		$this->_generateImageData();
		$this->_generateImage();
		$this->_generateCss();
	}

	/**
	 * Generates the sprite from all the items in the MSprite::image array
	 * and publishes the sprite to the published asset folder.
	 *
	 * @return void
	 */
	private function _generateImage()
	{
		$dimensions = $this->_getDimensions();

		$sprite = imagecreatetruecolor($dimensions['width'], $dimensions['height']);
		imagesavealpha($sprite, true);
		$transparent = imagecolorallocatealpha($sprite, 0, 0, 0, 127); //127 not 100
		imagefill($sprite, 0, 0, $transparent);
		foreach ($dimensions['groups'] as $group)
		{
			$top = 0;
			foreach ($group['images'] as $image)
			{
				switch ($image['type'])
				{
					case 'png':
						$img = imagecreatefrompng($image['path']);
						break;
					case 'jpg':
						$img = imagecreatefromjpeg($image['path']);
						break;
					case 'gif':
						$img = imagecreatefromgif($image['path']);
						break;
					default:
						continue;
						break;
				}
				if (!$img)
				{
					continue;
				}
				imagecopy($sprite, $img, $group['offset'], $top, 0, 0, $image['width'], $image['height']);
				$top += $image['height'];
			}
		}
		$fp = $this->getAssetFolder() . DIRECTORY_SEPARATOR . 'sprite.png';
		imagepng($sprite, $fp);
		ImageDestroy($sprite);
		if ($this->optimizer)
		{
			if (exec($this->optimizer))
			{
				$src = $fp . '.tmp';
				rename($fp, $src);
				exec(sprintf('%s %s %s', $this->optimizer, $src, $fp));
			}
		}
	}

	/**
	 * generates css code for all the items in the MSprite::_images array
	 * and publishes the sprite.css file into the published assets folder
	 *
	 * @return void
	 */
	private function _generateCss()
	{
		$dimensions = $this->_getDimensions();

		$sizes = array();
		foreach ($this->_images as $image)
		{
			$sizes[$image['width']] = $image['width'];
		}
		$css = '';
//		$css .= sprintf("[class^='%1\$s-']{background-image:url('sprite.png') !important;}\n", $this->cssIconClass);
// for 16x16 icons
		$template = '[class^="%1$s-%2$d"], [class*=" %1$s-%2$d"] {
			display:inline-block;
			overflow:hidden;
			vertical-align: text-top;
			line-height:%2$dpx;
			width:%2$dpx;
			height:%2$dpx;
			background-repeat:no-repeat;' .
//			'}' .
				'background-image:url(sprite.png) !important;}' .
				"\n";
		foreach ($sizes as $size)
		{
			$css .= sprintf($template, $this->cssIconClass, $size);
		}
		foreach ($dimensions['groups'] as $group)
		{
			$top = $group['height'];
			foreach ($group['images'] as $image)
			{
				$css .= '.' . $this->cssIconClass . '-' . $image['name'] . '{';
				$css .= 'background-position:' . -$group['offset'] . 'px ' . ($top - $group['height']) . 'px;';
				$css .= '}' . "\n";
				$top -= $image['height'];
			}
		}
		$fp = $this->getAssetFolder() . DIRECTORY_SEPARATOR . 'sprite.css';
		file_put_contents($fp, $css);

		$pathForIDE = Yii::app()->basePath . '/../www/css/sprites-for-ide.css';
		if (YII_DEBUG && is_writable($pathForIDE))
		{
			file_put_contents($pathForIDE, sprintf("/*THIS FILE IS ONLY FOR IDE AUTOCOMPLETE, GENERATED BY '%s'*/\n", __CLASS__) . $css);
		}
	}

	/**
	 * Calculate the total size of the sprite image and group images in columns
	 *
	 * @return array
	 */
	private function _getDimensions()
	{
		$imagesCount = count($this->_images);
		$splitFactor = floor(sqrt($imagesCount));
		$split = ceil($imagesCount / $splitFactor);
		$m = 0;
		$i = 1;
		$groups = [];
		$totalHeight = 0;
		$totalWidth = 0;
		$height = 0;
		$width = 0;
		$doSplit = false;
		$counter = 0;
		foreach ($this->_images as $id => $image)
		{
			$counter++;
			$group['widths'][] = $image['width'];
			$group['heights'][] = $image['height'];
			$group['images'][] = $image;

			$group['width'] = max($group['widths']);
			$group['height'] = array_sum($group['heights']);
			if (isset($this->_images[$id + 1]))
			{
				$nextImage = $this->_images[$id + 1];
			}
			else
			{
				$nextImage = [];
			}
			if ($counter == $imagesCount)
			{
//				var_dump("SPLIT: last");
				$doSplit = true;
			}
			if ($i > $split)
			{
//				var_dump("SPLIT: treshhold");
				$doSplit = true;
			}
			// Ignore small image width differences
			if ($nextImage && round($nextImage['width'] / 10) > round($image['width'] / 10))
			{
//				var_dump("SPLIT: width diff: {$nextImage['width']} > {$image['width']}");
				$doSplit = true;
			}
			if ($height && $group['height'] >= $height)
			{
//				var_dump("SPLIT: height diff: {$group['height']} >= $height");
				$doSplit = true;
			}
			if ($doSplit)
			{
				$width = 0;
// Ignore first small images if there are not enough of them
				if (count($group['heights']) > $split || $height)
				{
					$height = max($height, $group['height']);
				}
				unset($group['widths']);
				unset($group['heights']);
				$groups[$m] = $group;
				$i = 0;
				$m++;
				$group = [];
				$doSplit = false;
			}
			$i++;
		}
		foreach ($groups as $key => $dimensions)
		{
			$groups[$key]['offset'] = $totalWidth;
			$totalWidth += $dimensions['width'];
			if ($dimensions['height'] > $totalHeight)
			{
				$totalHeight = $dimensions['height'];
			}
		}
		return [
			'groups' => $groups,
			'width' => $totalWidth,
			'height' => $totalHeight
		];
	}

	/**
	 * create an array with specific individual image information in
	 * populates @see MSprite::_images
	 * 
	 * @return void
	 */
	private function _generateImageData()
	{
		foreach ($this->sprites as $i => $s)
		{
			$imgPath = $s['imageFolder'] . '/' . $s['path'];
			if (!file_exists($imgPath))
				throw new CException("The image file's path '$imgPath' does not exist.");
			$info = getimagesize($imgPath);
			if (!is_array($info))
				throw new CException("The image '$imgPath' is not a correct image format.");
			$this->_images[$i]['size'] = filesize($imgPath);
			$this->_images[$i]['path'] = $imgPath;
			$this->_images[$i]['width'] = $info[0];
			$this->_images[$i]['height'] = $info[1];
			$this->_images[$i]['mime'] = $info['mime'];
			$type = explode('/', $info['mime']);
			$this->_images[$i]['type'] = $type[1];
			// convert the relative path into the class name
			// replace slashes with dashes and remove extension from file name
			$p = pathinfo($imgPath);
			$name = str_replace(array('/', '\\', '_'), '-', $s['path']);
			$this->_images[$i]['name'] = strtolower(str_replace(array($p['extension'], '.'), '', $name));
		}

		$widths = [];
		$heights = [];
		$sizes = [];
		foreach ($this->_images as $key => $image)
		{
			$widths[$key] = (int) $image['width'];
			$heights[$key] = (int) $image['height'];
			$sizes[$key] = (int) $image['size'];
		}

		array_multisort(
				$this->_images, SORT_ASC, SORT_NUMERIC, $widths, SORT_ASC, SORT_NUMERIC, $heights, SORT_ASC, SORT_NUMERIC, $sizes, SORT_ASC, SORT_NUMERIC
		);
	}

	/**
	 * returns the string file path to the icons folder that holds the individual images
	 * that may be used to generate the sprite.
	 *
	 * @return string
	 */
	public function getIconPath()
	{
		(array) $this->imageFolderPath;
		foreach ($this->imageFolderPath as & $path)
		{
			if ($path instanceof Closure)
			{
				$path = $path();
			}
			$path = (string) $path;
		}
		return $this->imageFolderPath;
	}

	/**
	 * Finds all the image files within the MSprite::$imageFolderPath
	 * and populates the sprites array
	 *
	 * @see MSprite::$sprites
	 * @return void
	 */
	public function findFiles()
	{
		$options = array('fileTypes' => array('png', 'gif', 'jpeg', 'jpg'));
		// must be an array of folders, this is ensured in getIconPath function
		foreach ($this->getIconPath() as $iFolder)
		{
			if (!is_dir($iFolder))
				throw new CException("The folder path '$iFolder' does not exist.");
			$files = CFileHelper::findFiles($iFolder, $options);
			foreach ($files as $p)
			{
				$this->sprites[] = array(
					'imageFolder' => $iFolder,
					'path' => trim(str_replace(realpath($iFolder), '', $p), DIRECTORY_SEPARATOR)
				);
			}
		}
	}

}
