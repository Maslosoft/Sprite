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

namespace Maslosoft\Sprite\Traits;

/**
 * VersionTrait
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
trait VersionTrait
{

	/**
	 * Version number holder
	 * @var string
	 */
	private static $_version = null;

	/**
	 * Get current version number
	 * @return string
	 */
	public function getVersion()
	{
		if (null === self::$_version)
		{
			self::$_version = require __DIR__ . '/../version.php';
		}
		return self::$_version;
	}

}
