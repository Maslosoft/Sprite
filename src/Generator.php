<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
