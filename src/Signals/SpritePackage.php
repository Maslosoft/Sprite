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

namespace Maslosoft\Sprite\Signals;

use Maslosoft\Signals\Interfaces\SignalInterface;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Maslosoft\Sprite\Models\Package;

/**
 * Signal for adding package.
 *
 * Respond to this signal to instruct sprite
 * generator where are icons located and how the should be named.
 * 
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SpritePackage implements SignalInterface
{

	/**
	 * Packages coming with this signal
	 * @var SpritePackageInterface[]|Package[]
	 */
	private $packages = [];

	/**
	 *
	 * @param SpritePackageInterface|Package $package
	 */
	public function add(SpritePackageInterface $package)
	{
		$this->packages[] = $package;
	}

	/**
	 *
	 * @return SpritePackageInterface[]|Package[]
	 */
	public function getPackages()
	{
		return $this->packages;
	}

}
