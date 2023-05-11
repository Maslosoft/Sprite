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
	public array $sprites;

	/**
	 * Total width of group of sprites
	 * @var int
	 */
	public int $width = 0;

	/**
	 * Total height of group of sprites
	 * @var int
	 */
	public int $height = 0;

	/**
	 * Offset from left side of image
	 * @var int
	 */
	public int $offset = 0;

}
