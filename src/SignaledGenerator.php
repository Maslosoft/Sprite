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

use Maslosoft\Signals\Signal;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Signals\SpritePackage;

/**
 * SignaledGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SignaledGenerator implements GeneratorInterface
{

	public function generate()
	{
		// Gather package signals
		$signals = (new Signal)->emit(new SpritePackage());

		$generator = new CompoundGenerator();

		// Add all packages
		foreach ($signals as $signal)
		{
			/* @var $signal SpritePackage */
			foreach ($signal->getPackages() as $package)
			{
				$generator->add($package);
			}
		}

		$generator->generate();
	}

}
