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

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Models\SpriteImage;
use UnexpectedValueException;

/**
 * ImageSorter
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ImageSorter
{

	const SortWidth = 1;
	const SortHeight = 2;
	const SortSize = 4;

	/**
	 * Sort SpriteImage array based on:
	 *   - Width
	 *   - Height
	 *   - File size
	 * >> NOTE: It seems that best results are from sorting just by width
	 * @param SpriteImage[] $sprites Array of sprite images
	 */
	public static function sort(& $sprites, $mode = self::SortWidth)
	{
		$widths = [];
		$heights = [];
		$sizes = [];
		foreach ($sprites as $key => $image)
		{
			if (!$image instanceof SpriteImage)
			{
				throw new UnexpectedValueException('Expected `%s` got `%s`', SpriteImage::class, is_object($image) ? get_class($image) : gettype($image));
			}
			/* @var $image SpriteImage */
			$widths[$key] = $image->width;
			$heights[$key] = $image->height;
			$sizes[$key] = $image->size;
		}

		$params = [];

		// Setup sort modes based on flags
		if ($mode & self::SortWidth)
		{
			array_push($params, $widths, SORT_ASC, SORT_NUMERIC);
		}
		if ($mode & self::SortHeight)
		{
			array_push($params, $heights, SORT_ASC, SORT_NUMERIC);
		}
		if ($mode & self::SortSize)
		{
			array_push($params, $sizes, SORT_ASC, SORT_NUMERIC);
		}

		// Finally push sprites array
		$params[] = & $sprites;

		call_user_func_array('array_multisort', $params);
	}

}
