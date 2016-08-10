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
use Symfony\Component\Finder\Finder;

/**
 * ImageFinder
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ImageFinder
{

	public function find($packages)
	{
		// Get icons
		$finder = new Finder();

		$finder->sortByChangedTime();
		$finder->sortByAccessedTime();
		$finder->name('/\.(png|jpg|gif)$/');
		$sprites = [];
		foreach ($packages as $package)
		{
			foreach ($package->getPaths() as $path)
			{
				foreach ($finder->in($path) as $fileInfo)
				{
					$sprite = new SpriteImage($path, $fileInfo);
					$sprite->packages[] = $package;
					$sprites[$sprite->hash] = $sprite;
				}
			}
		}
		return $sprites;
	}

}
