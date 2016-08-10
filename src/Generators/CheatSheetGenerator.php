<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Generators;

use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;

/**
 * Generate HTML cheat sheet with all of the icons
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CheatSheetGenerator implements GeneratorInterface, CollectionAwareInterface
{

	use CollectionAwareTrait;

	public function generate()
	{

	}

}
