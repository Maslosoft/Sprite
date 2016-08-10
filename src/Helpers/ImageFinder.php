<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
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
