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
 * Collection of image groups
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Collection
{

	/**
	 * Total width of all groups
	 * @var int
	 */
	public $width = 0;

	/**
	 * Total height of all groups
	 * @var int
	 */
	public $height = 0;
	private $sprites = [];

	/**
	 *
	 * @param SpriteImage[] $sprites
	 */
	public function __construct($sprites = [])
	{
		$this->sprites = $sprites;
	}

	public function getGroups()
	{
		
	}

}
