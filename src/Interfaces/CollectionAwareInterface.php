<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Maslosoft\Sprite\Models\Collection;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface CollectionAwareInterface
{

	public function setCollection(Collection $collection);
}
