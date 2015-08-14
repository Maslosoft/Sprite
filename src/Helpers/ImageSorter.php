<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Models\SpriteImage;

/**
 * ImageSorter
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ImageSorter
{

	/**
	 * Sort SpriteImage array based on:
	 *   - Width
	 *   - Height
	 *   - File size
	 * @param SpriteImage[] $sprites Array of sprite images
	 */
	public static function sort(& $sprites)
	{
		$widths = [];
		$heights = [];
		$sizes = [];
		foreach ($sprites as $key => $image)
		{
			$widths[$key] = $image->width;
			$heights[$key] = $image->height;
			$sizes[$key] = $image->size;
		}

		array_multisort(
				$widths, SORT_ASC, SORT_NUMERIC, // Width
				$heights, SORT_ASC, SORT_NUMERIC, // Height
				$sizes, SORT_ASC, SORT_NUMERIC, // File Size
				$sprites
		);
	}

}
