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

namespace Maslosoft\Sprite\Models;

/**
 * Collection
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Collection
{

	public $width = 0;
	public $height = 0;
	private $sprites = [];

	public function __construct($sprites = [])
	{
		$this->sprites = $sprites;
	}

	public function getGroups()
	{

	}

}
