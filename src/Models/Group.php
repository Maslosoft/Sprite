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
 * Images group/column
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Group
{

	/**
	 * Images
	 * @var SpriteImage[]
	 */
	public $sprites;

	/**
	 * Total width of group of sprites
	 * @var int
	 */
	public $width = 0;

	/**
	 * Total height of group of sprites
	 * @var int
	 */
	public $height = 0;

	/**
	 * Offset from left side of image
	 * @var int
	 */
	public $offset = 0;

}
