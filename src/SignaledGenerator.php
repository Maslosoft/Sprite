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

	private $verbose = false;

	public function generate($verbose = false)
	{
		$this->verbose = $verbose;
		// Gather package signals
		$signals = (new Signal)->emit(new SpritePackage());

		$generator = new CompoundGenerator();

		// Add all packages
		foreach ($signals as $signal)
		{
			/* @var $signal SpritePackage */
			$this->out(sprintf('SIG: %s', get_class($signal->getSlot())));
			foreach ($signal->getPackages() as $package)
			{
				$this->out(sprintf('PKG: %s', get_class($package)));
				$num = count((new Helpers\ImageFinder)->find([$package]));
				$data = [
					'CLS: ' . $package->getConstantsClass(),
					'NUM: ' . $num,
					'DIR: ' . PHP_EOL . implode(PHP_EOL, $package->getPaths()),
				];
				$this->out(implode(PHP_EOL, $data));
				$this->out('');
				$generator->add($package);
			}
		}

		$generator->generate();
	}

	private function out($msg)
	{
		if (!$this->verbose)
		{
			return;
		}
		echo $msg . PHP_EOL;
	}

}
