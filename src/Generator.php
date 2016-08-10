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

namespace Maslosoft\Sprite;

use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Models\Package;
use Maslosoft\Sprite\Traits\VersionTrait;

/**
 * Generator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Generator implements GeneratorInterface
{

	use VersionTrait;

	public function generate()
	{
		$package = new Package();
		$package->paths[] = 'assets';
		$generator = new CompoundGenerator();
		$generator->add($package);
		$generator->generate();
	}

}
