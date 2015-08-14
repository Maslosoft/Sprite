<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
