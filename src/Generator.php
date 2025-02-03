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
use ReflectionObject;
use ReflectionProperty;

/**
 * Generator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Generator implements GeneratorInterface
{

	use VersionTrait;

	public function generate(): void
	{
		$package = new Package();

		$generator = new CompoundGenerator();

		// Copy config to package, as CompoundGenerator should be configured already via:
		// - sprite.yml
		// - any EmbeDi config source
		$info = new ReflectionObject($package);
		foreach ($info->getProperties(ReflectionProperty::IS_PUBLIC) as $property)
		{
			$name = $property->name;
			$package->$name = $generator->$name;
		}

		$generator->add($package);
		$generator->generate();
	}

}
