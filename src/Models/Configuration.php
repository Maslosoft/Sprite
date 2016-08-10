<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Models;

use Maslosoft\Sprite\Generators\CheatSheetGenerator;
use Maslosoft\Sprite\Generators\ConstantsGenerator;
use Maslosoft\Sprite\Generators\CssGenerator;
use Maslosoft\Sprite\Generators\ImgGenerator;

/**
 * Configuration
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Configuration extends Package
{

	/**
	 *  Path for temporary files
	 *
	 * @var string
	 */
	public $runtimePath = 'runtime';

	/**
	 *  Path for result sprite files
	 *
	 * @var string
	 */
	public $generatedPath = 'generated';

	/**
	 * Base name for generated files
	 * For example value of `sprite` will result in generating files:
	 *
	 * * sprite.css
	 * * sprite.png
	 * * sprite.html
	 *
	 * @var string
	 */
	public $basename = 'sprite';

	/**
	 *  CSS class name prefix used for all icons.
	 * This should be something distinctive
	 * or might match many CSS elements.
	 *
	 * @var string
	 */
	public $iconCssClass = 'icon';

	/**
	 * optimizer: pngcrush {src} {dst}
	 * @var string
	 */
	public $optimizer = 'pngquant --ext .png --force {src}';

	/**
	 *  Generator classes used to generate files
	 *
	 * @var string[]
	 */
	public $generators = [
		CssGenerator::class,
		ImgGenerator::class,
		CheatSheetGenerator::class,
		ConstantsGenerator::class
	];

}
