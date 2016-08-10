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

/**
 * Normalize css/constants names
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Normalizer
{

	public static function camelize(SpritePackageInterface $package, SpriteImage $sprite)
	{
		$separator = '-';
		$input = $sprite->name;
		$input = str_replace($separator, ' ', $input);
		return str_replace(' ', '', ucwords($input));
	}

	public static function decamelize(SpritePackageInterface $package, SpriteImage $sprite)
	{
		$separator = '-';
		$input = $sprite->name;
		return preg_replace('~-+~', '-', ltrim(strtolower(preg_replace('/[A-Z]/', "$separator$0", $input)), $separator));
	}

}
