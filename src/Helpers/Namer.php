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

	public static function nameCssClass(SpritePackageInterface $package, SpriteImage $sprite): string
	{
		$prefix = $package->getIconPrefix();
		$converter = $package->getCssClassNameConverter();
		if (!empty($converter))
		{
			if (!is_callable($converter, true))
			{
				throw new RuntimeException('Variable of type `%s` is not callable', get_debug_type($converter));
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

	public static function nameConstant(SpritePackageInterface $package, SpriteImage $sprite)
	{
		$converter = $package->getConstantsConverter();
		if (!empty($converter))
		{
			if (!is_callable($converter, true))
			{
				throw new RuntimeException('Variable of type `%s` is not callable', get_debug_type($converter));
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
		// Last resort replacements
		$name = preg_replace('~^[0-9]+~', '', $name);
		return str_replace('-', '_', $name);
	}

}
