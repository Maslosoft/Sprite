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

namespace Maslosoft\Sprite\Interfaces;

use Maslosoft\Sprite\Models\Collection;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface CollectionAwareInterface
{

	public function setCollection(Collection $collection);
}
