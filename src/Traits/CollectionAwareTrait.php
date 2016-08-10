<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
