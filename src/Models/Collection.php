<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/sprite
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @copyright Copyright (c) Others as mentioned in code
 * @link http://maslosoft.com/sprite/
 */

namespace Maslosoft\Sprite\Models;

use Maslosoft\Sprite\Helpers\ImageSorter;

/**
 * Collection of image groups
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Collection
{

	/**
	 * Total width of all groups
	 * @var int
	 */
	public $width = 0;

	/**
	 * Total height of all groups
	 * @var int
	 */
	public $height = 0;
	private $sprites = [];

	/**
	 * Image groups
	 * @var Group[]
	 */
	private $groups = [];

	/**
	 *
	 * @param SpriteImage[] $sprites
	 */
	public function __construct($sprites = [])
	{
		ImageSorter::sort($sprites);
		$this->sprites = $sprites;
	}

	/**
	 * Get groups
	 * @return Group[]
	 */
	public function getGroups()
	{
		if (empty($this->groups))
		{
			$this->createGroups();
		}
		return $this->groups;
	}

	/**
	 * Get all sprites
	 * @return SpriteImage[]
	 */
	public function getSprites()
	{
		return $this->sprites;
	}

	private function createGroups()
	{
		$imagesCount = count($this->sprites);
		$splitFactor = floor(sqrt($imagesCount));
		$split = ceil($imagesCount / $splitFactor);
		$m = 0;
		$i = 1;
		$totalHeight = 0;
		$totalWidth = 0;
		$height = 0;
		$doSplit = false;
		$counter = 0;
		$column = [];
		$columns = [];
		$groups = [];
		// Integer indexed sprites
		$images = array_values($this->sprites);
		foreach ($this->sprites as $id => $image)
		{
			/* @var $image SpriteImage */
			/* @var $nextImage SpriteImage */
			$counter++;
			$column['widths'][] = $image->width;
			$column['heights'][] = $image->height;
			$column['images'][] = $image;

			$column['width'] = max($column['widths']);
			$column['height'] = array_sum($column['heights']);
			if (isset($images[$id + 1]))
			{
				$nextImage = $images[$id + 1];
			}
			else
			{
				$nextImage = [];
			}

			// Split because it's lat image
			if ($counter == $imagesCount)
			{
				$doSplit = true;
			}

			// Split because image number is above split treshold
			if ($i > $split)
			{
				$doSplit = true;
			}

			// Ignore small image width differences
			if ($nextImage && round($nextImage->width / 10) > round($image->width / 10))
			{
				$doSplit = true;
			}

			// Split because height is different
			if ($height && $column['height'] >= $height)
			{
				$doSplit = true;
			}

			// Do split (create new column of images) if nessesary
			if ($doSplit)
			{
				// Ignore first small images if there are not enough of them
				if (count($column['heights']) > $split || $height)
				{
					$height = max($height, $column['height']);
				}
				unset($column['widths']);
				unset($column['heights']);
				$group = new Group();
				$group->sprites = $column['images'];
				$group->width = (int) $column['width'];
				$group->height = (int) $column['height'];
				$groups[$m] = $group;
				$columns[$m] = $column;
				$i = 0;
				$m++;
				$column = [];
				$doSplit = false;
			}
			$i++;
		}
		foreach ($columns as $key => $dimensions)
		{
			$groups[$key]->offset = $totalWidth;
			$totalWidth += $dimensions['width'];
			if ($dimensions['height'] > $totalHeight)
			{
				$totalHeight = $dimensions['height'];
			}
		}
		$this->height = $totalHeight;
		$this->width = $totalWidth;
		$this->groups = $groups;
	}

}
