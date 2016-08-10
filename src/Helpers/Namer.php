<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Maslosoft\Sprite\Models\SpriteImage;

/**
 * Namer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Namer
{

	public static function nameCssClass(SpritePackageInterface $package, SpriteImage $sprite)
	{
		$prefix = $package->getIconPrefix();
		if (!empty($prefix))
		{
			return sprintf('icon-%s-%s', $prefix, $sprite->name);
		}
		return sprintf('icon-%s', $sprite->name);
	}

}
