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
use Maslosoft\Signals\Interfaces\SlotAwareInterface;
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
class SpritePackage implements SignalInterface, SlotAwareInterface
{

	/**
	 * Packages coming with this signal
	 * @var SpritePackageInterface[]|Package[]
	 */
	private array $packages = [];
	private $slot = null;

	/**
	 *
	 * @param SpritePackageInterface|Package $package
	 */
	public function add(SpritePackageInterface $package): void
	{
		$this->packages[] = $package;
	}

	/**
	 *
	 * @return SpritePackageInterface[]|Package[]
	 */
	public function getPackages(): array
	{
		return $this->packages;
	}

	public function setSlot($slot): void
	{
		$this->slot = $slot;
	}

	public function getSlot()
	{
		return $this->slot;
	}

}
