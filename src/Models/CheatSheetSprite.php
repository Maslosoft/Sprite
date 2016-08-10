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

use Maslosoft\Sprite\Helpers\ConstantsFactory;
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

	/**
	 * All class constants at which sprite is available - short notation
	 * @var string[]
	 */
	public $shortConstants = [];

	/**
	 * Whether has constants
	 * @var bool
	 */
	public $hasConstants = false;

	public function __construct(SpriteImage $sprite)
	{
		foreach ($sprite->packages as $package)
		{
			$this->cssClasses[] = Namer::nameCssClass($package, $sprite);
		}
		$this->cssClass = $this->cssClasses[0];

		$this->image = file_get_contents($sprite->getFullPath());
		$classes = ConstantsFactory::create([$sprite]);
		foreach ($classes as $class)
		{
			foreach ($class->constants as $const)
			{
				$name = $const->name;
				$this->constants[] = sprintf('%s\\%s::%s', $class->ns, $class->name, $name);
				$this->shortConstants[] = sprintf('%s::%s', $class->name, $name);
				$this->hasConstants = true;
			}
		}
	}

}
