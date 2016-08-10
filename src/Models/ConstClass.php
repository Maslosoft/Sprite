<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Models;

use Maslosoft\Sprite\Helpers\Namer;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use ReflectionClass;

/**
 * ConstClass
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ConstClass
{

	/**
	 * Namespace
	 * @var string
	 */
	public $ns = '';

	/**
	 * Short name
	 * @var string
	 */
	public $name = '';

	/**
	 * Constants
	 * @var ConstItem[]
	 */
	public $constants = [];

	/**
	 * Package
	 * @var SpritePackageInterface
	 */
	private $package = null;

	/**
	 * @var string
	 */
	private $path = '';

	public function __construct(SpritePackageInterface $package)
	{
		$this->package = $package;
		$className = $this->package->getConstantsClass();
		$info = new ReflectionClass($className);
		$this->ns = $info->getNamespaceName();
		$this->name = $info->getShortName();
		$this->path = $info->getFileName();
	}

	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Add constant from sprite, but only if in current package.
	 * @param SpriteImage $sprite
	 */
	public function add(SpriteImage $sprite)
	{
		$dest = $this->package->getConstantsClass();
		foreach ($sprite->packages as $package)
		{
			$src = $package->getConstantsClass();
			if ($src === $dest)
			{
				$this->addSprite($sprite);
			}
		}
	}

	private function addSprite(SpriteImage $sprite)
	{
		$item = new ConstItem();
		$item->name = Namer::nameConstant($this->package, $sprite);
		$item->value = Namer::nameCssClass($this->package, $sprite);
		$this->constants[] = $item;
	}

	public function __toString()
	{
		return '<?php';
	}

}
