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

namespace Maslosoft\Sprite\Generators;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Helpers\ConstantsFactory;
use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;

/**
 * ConstantsGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ConstantsGenerator implements GeneratorInterface, CollectionAwareInterface
{

	use CollectionAwareTrait;

	/**
	 * View instance
	 * @var MiniView
	 */
	private MiniView $mv;

	public function __construct()
	{
		$this->mv = new MiniView($this);
	}

	public function generate(): void
	{
		$collection = $this->getCollection();
		$sprites = $collection->getSprites();
		$classes = ConstantsFactory::create($sprites);
		foreach ($classes as $class)
		{
			$definition = $this->mv->render('constants-class.latte', ['class' => $class], true);
			file_put_contents($class->getPath(), $definition);
		}
	}

}
