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

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * LoggerAwareTrait
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
trait LoggerAwareTrait
{

	/**
	 * Logger instance
	 * @var LoggerInterface
	 */
	public $logger;

	/**
	 * Set logger
	 * @param LoggerInterface $logger
	 * @return static
	 */
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
		return $this;
	}

	/**
	 * Get logger
	 * @return LoggerInterface
	 */
	public function getLogger()
	{
		if (empty($this->logger))
		{
			$this->logger = new NullLogger;
		}
		return $this->logger;
	}

}
