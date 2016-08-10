<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Models\ConstClass;
use Maslosoft\Sprite\Models\SpriteImage;

/**
 * ConstantsFactory
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ConstantsFactory
{

	/**
	 * Create class constant models out of sprites array
	 * @param SpriteImage[] $sprites
	 * @return \Maslosoft\Sprite\Helpers\ConstClass[]
	 */
	public static function create($sprites)
	{
		$classes = [];
		foreach ($sprites as $image)
		{
			foreach ($image->packages as $package)
			{
				$className = $package->getConstantsClass();

				// Skip empty
				if (empty($className))
				{
					continue;
				}

				// Skip if class not found
				if (!class_exists($className))
				{
					continue;
				}
				if (empty($classes[$className]))
				{
					$classes[$className] = new ConstClass($package);
				}
			}
			if (!empty($classes[$className]))
			{
				$classes[$className]->add($image);
			}
		}
		return $classes;
	}

}
