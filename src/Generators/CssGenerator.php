<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Generators;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Interfaces\CssGeneratorInterface;
use Maslosoft\Sprite\Models\Collection;

/**
 * CssGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CssGenerator implements CssGeneratorInterface
{

	/**
	 * View instance
	 * @var MiniView
	 */
	private $mv = null;

	public function __construct()
	{
		$this->mv = new MiniView($this);
	}

	public function generate()
	{
		
	}

	public function setCollection(Collection $collection)
	{
		
	}

}
