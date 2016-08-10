<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/sprite
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Sprite;

use Maslosoft\Signals\Signal;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Signals\Sprite;

/**
 * SignaledGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SignaledGenerator implements GeneratorInterface
{

	public function generate()
	{
		// Gather paths
		$signals = (new Signal)->emit(new Sprite);


		$generator = new CompoundGenerator();

		foreach ($signals as $signal)
		{
			$generator->add($signal);
		}

		$generator->generate();
	}

}
