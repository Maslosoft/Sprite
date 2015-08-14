<?php

namespace Maslosoft\Sprite;

use CLogger;
use Closure;
use Maslosoft\Sprite\Helpers\ImageSorter;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Models\SpriteImage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UnexpectedValueException;
use Yii;

/**
 * MSprite class file.
 *
 * @author Steven OBrien <steven.obrien@newicon.net>
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 * @link http://www.newicon.net/
 * @link http://maslosoft.com/sprite/ Maslosoft
 * @copyright Copyright &copy; 2008-2011 Newicon Ltd
 * @copyright 2013-2015 Maslosoft http://maslosoft.com
 * @license http://www.yiiframework.com/license/
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
 * @author Steven OBrien <steven.obrien@newicon.net>
 */
class Generator implements GeneratorInterface, LoggerAwareInterface
{

	/**
	 * Path where sprites will be saved
	 * @var string
	 */
	public $runtimePath = '';

	/**
	 * Path to IDE stub with. Generated CSS will be stored here as well.
	 * This allows css icon name autocomplete within IDE's like NetBeans or Eclipse.
	 * @var string
	 */
	public $ideStubPath = '';

	/**
	 * PSR compliant logger Logger. This can also be set by setLogger.
	 * @var LoggerInterface
	 */
	public $logger = null;

	/**
	 * class name of convienent icon class, works for the famfamfam and fugue icon sets
	 * easilly display an icon inline that is size 16x16
	 * @var type
	 */
	public $iconCssClass = 'icon';

	/**
	 * Stores the path to the folder where the individual images that
	 * will be included in the spite are kept.
	 * can be an array of imagefolder paths
	 * @property mixed
	 */
	public $iconPaths;

	/**
	 * Name of executable for png optimizer, if emty, no optimizer will be used
	 * @var string
	 */
	public $optimizer = 'pngcrush';

	/**
	 * array of image paths relative to the MSprite::$imageFolderPath to include in the sprite, without a preceeding slash
	 * this is automatically populated if empty, by MSprite::findFiles()
	 * @var SpriteImage[]
	 */
	private $_sprites = [];

	/**
	 * array of all image data
	 * @var array
	 */
	private $_images = [];

	public function __construct()
	{
		$this->logger = new NullLogger;
	}

	/**
	 * Generates the sprite.png and sprite.css files
	 */
	public function generate()
	{
		// Prepare folder
		if (!file_exists($this->getAssetFolder()))
		{
			mkdir($this->getAssetFolder());
		}

		$this->findFiles();
		$this->_generateImage();
		$this->_generateCss();
	}

	/**
	 * Set PSR compliant logger
	 * @param LoggerInterface $logger
	 * @return \Maslosoft\Sprite\Generator
	 */
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
		return $this;
	}

	/**
	 * Remove generated sprite and css file
	 */
	public function reset()
	{
		$folder = $this->getAssetFolder();
		@unlink(sprintf('%s/sprite.css', $folder));
		@unlink(sprintf('%s/sprite.png', $folder));
	}

	/**
	 * get the filepath to the components asset folder
	 *
	 * @return string
	 */
	private function getAssetFolder()
	{
		return $this->runtimePath . '/maslosoft-sprite';
	}

	/**
	 * Generates the sprite from all the items in the MSprite::image array
	 * and publishes the sprite to the published asset folder.
	 *
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
		imagedestroy($sprite);
		if ($this->optimizer)
		{
			if (!is_executable($this->optimizer))
			{
				return;
			}
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

		$sizes = [];
		foreach ($this->_sprites as $image)
		{
			$sizes[$image->width] = $image->width;
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
			$css .= sprintf($template, $this->iconCssClass, $size);
		}
		foreach ($dimensions['groups'] as $group)
		{
			$top = $group['height'];
			foreach ($group['images'] as $image)
			{
				$css .= '.' . $this->iconCssClass . '-' . $image->name . '{';
				$css .= 'background-position:' . -$group['offset'] . 'px ' . ($top - $group['height']) . 'px;';
				$css .= '}' . "\n";
				$top -= $image->height;
			}
		}
		$fp = $this->getAssetFolder() . DIRECTORY_SEPARATOR . 'sprite.css';
		file_put_contents($fp, $css);

		$pathForIDE = Yii::app()->basePath . '/../www/css/sprites-for-ide.css';
		if (YII_DEBUG)
		{
			if (is_writable($pathForIDE))
			{
				file_put_contents($pathForIDE, sprintf("/*THIS FILE IS ONLY FOR IDE AUTOCOMPLETE, GENERATED BY '%s'*/\n", __CLASS__) . $css);
			}
			else
			{
				Yii::log(sprintf("Helper sprite for IDE could not be generated, make sure path `%s` is writable", $pathForIDE), CLogger::LEVEL_WARNING);
			}
		}
	}

	/**
	 * Calculate the total size of the sprite image and group images in columns
	 *
	 * @return array
	 */
	private function _getDimensions()
	{
		$imagesCount = count($this->_sprites);
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
		foreach ($this->_sprites as $id => $image)
		{
			$counter++;
			$group['widths'][] = $image->width;
			$group['heights'][] = $image->height;
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
			if ($nextImage && round($nextImage['width'] / 10) > round($image->width / 10))
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
	 * returns the string file path to the icons folder that holds the individual images
	 * that may be used to generate the sprite.
	 *
	 * @return string
	 */
	public function getIconPath()
	{
		(array) $this->iconPaths;
		foreach ($this->iconPaths as & $path)
		{
			if ($path instanceof Closure)
			{
				$path = $path();
			}
			$path = (string) $path;
		}
		return $this->iconPaths;
	}

	/**
	 * Finds all the image files within the MSprite::$imageFolderPath
	 * and populates the sprites array
	 *
	 * @return void
	 */
	private function findFiles()
	{
		// Reset sprites
		$this->_sprites = [];

		// Image types
		$types = [
			'png',
			'gif',
			'jpeg',
			'jpg'
		];

		// Must be an array of folders, this is ensured in getIconPath function
		foreach ($this->getIconPath() as $path)
		{
			if (empty($path))
			{
				throw new UnexpectedValueException("Found empty path in");
			}
			if (!is_dir($path))
			{
				throw new RuntimeException("The folder path '$path' does not exist");
			}
			$finder = new Finder();
			foreach ($types as $ext)
			{
				$finder->name("*.$ext");
			}

			foreach ($finder->in($path) as $file)
			{
				/* @var $file SplFileInfo */
				$this->_sprites[] = new SpriteImage($path, $file);
			}
		}

		// Sort results
		ImageSorter::sort($this->_sprites);
	}

}
