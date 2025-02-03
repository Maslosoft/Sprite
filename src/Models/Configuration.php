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
	public string $runtimePath = 'runtime';

	/**
	 *  Path for result sprite files
	 *
	 * @var string
	 */
	public string $generatedPath = 'generated';

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
	public string $basename = 'sprite';

	/**
	 *  CSS class name prefix used for all icons.
	 * This should be something distinctive
	 * or might match many CSS elements.
	 *
	 * @var string
	 */
	public string $iconCssClass = 'icon';

	/**
	 * optimizer: pngcrush {src} {dst}
	 * @var string
	 */
	public string $optimizer = 'pngquant --ext .png --force {src}';

	/**
	 *  Generator classes used to generate files
	 *
	 * @var string[]
	 */
	public array $generators = [
		CssGenerator::class,
		ImgGenerator::class,
		CheatSheetGenerator::class,
		ConstantsGenerator::class
	];

}
