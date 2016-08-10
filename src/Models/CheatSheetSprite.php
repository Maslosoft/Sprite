<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Models;

use Maslosoft\Sprite\Helpers\Namer;

/**
 * CheatSheetSprite
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CheatSheetSprite
{

	/**
	 * Source image as base64 data URL
	 * @var string
	 */
	public $image = '';

	/**
	 * Any CSS class, usually first one
	 * @var string
	 */
	public $cssClass = '';

	/**
	 * All CSS classes at which icon is available
	 * @var string[]
	 */
	public $cssClasses = [];

	/**
	 * All class constants at which sprite is available
	 * @var string[]
	 */
	public $constants = [];

	public function __construct(SpriteImage $sprite)
	{
		foreach ($sprite->packages as $package)
		{
			$this->cssClasses[] = Namer::nameCssClass($package, $sprite);
		}
		$this->cssClass = $this->cssClasses[0];

		$this->image = file_get_contents($sprite->getFullPath());
	}

}
