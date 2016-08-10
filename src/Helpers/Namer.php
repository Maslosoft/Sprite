<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Maslosoft\Sprite\Models\SpriteImage;
use RuntimeException;

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
		$converter = $package->getCssClassNameConverter();
		if (!empty($converter))
		{
			if (!is_callable($converter, true))
			{
				throw new RuntimeException('Variable of type `%s` is not callable', get_type($converter));
			}
			$params = [
				$package,
				$sprite
			];
			$name = call_user_func_array($converter, $params);
		}
		else
		{
			$name = $sprite->name;
		}
		if (!empty($prefix))
		{
			return sprintf('icon-%s-%s', $prefix, $name);
		}
		return sprintf('icon-%s', $name);
	}

}
