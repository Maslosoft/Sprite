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

namespace Maslosoft\Sprite\Interfaces;

use Maslosoft\Sprite\Models\Collection;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface CssGeneratorInterface extends GeneratorInterface
{

	public function setCollection(Collection $collection);
}
