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
