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

namespace Maslosoft\Sprite\Traits;

use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Models\Collection;

/**
 * Basic implementation of Collection Aware inteface
 *
 * @see CollectionAwareInterface
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
trait CollectionAwareTrait
{

	/**
	 * Collection of sprite groups
	 * @var Collection
	 */
	private $collection = null;

	/**
	 * Get collection
	 * @return Collection
	 */
	public function getCollection()
	{
		return $this->collection;
	}

	/**
	 * Set collection
	 * @param Collection $collection
	 * @return $this
	 */
	public function setCollection(Collection $collection)
	{
		$this->collection = $collection;
		return $this;
	}

}
