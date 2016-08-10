<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Interfaces;

use Maslosoft\Sprite\Models\Configuration;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface ConfigurationAwareInterface
{

	/**
	 * Get configuration
	 * @
	 */
	public function getConfig();

	/**
	 * Set configuration
	 * @param Configuration $config
	 * @
	 */
	public function setConfig(Configuration $config);
}
