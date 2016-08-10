<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
