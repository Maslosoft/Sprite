<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
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
	 * @return ConstClass[]
	 */
	public static function create($sprites)
	{
		$classes = [];

		foreach ($sprites as $sprite)
		{
			/* @var $sprite SpriteImage */
			foreach ($sprite->packages as $package)
			{
				/* @var $package SpritePackageInterface */
				$className = $package->getConstantsClass();

				// Skip empty
				if (empty($className))
				{
					continue;
				}

				ConstantsFileCreator::generate($package);

				// NOTE: Skip if class exists checks,
				// as it will load class into memory too early!

				if (!array_key_exists($className, $classes))
				{
					$classes[$className] = new ConstClass($package);
				}
				$classes[$className]->add($sprite);
			}
		}
		return $classes;
	}

}
