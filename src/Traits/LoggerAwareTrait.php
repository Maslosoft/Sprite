<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
	 * @return LoggerAwareInterface
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
