<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Traits;

use Maslosoft\Sprite\Interfaces\ConfigurationAwareInterface;
use Maslosoft\Sprite\Models\Configuration;

/**
 * Basic implementation of Configuration Aware interface
 *
 * @see ConfigurationAwareInterface
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
trait ConfigurationAwareTrait
{

	/**
	 * Sprite generator configuration
	 * @var Configuration
	 */
	private $config = null;

	/**
	 * Get configuration
	 * @return Configuration
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * Set configuration
	 * @param Configuration $config
	 * @return $this
	 */
	public function setConfig(Configuration $config)
	{
		$this->config = $config;
		return $this;
	}

}
