<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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


		$generator = new Generator();

		foreach ($signals as $signal)
		{
			foreach ($signal->paths as $path)
			{
				$generator->iconPaths[] = realpath($path);
			}
		}
		$generator->iconPaths = array_unique($generator->iconPaths);

		$generator->generate();
	}

}
