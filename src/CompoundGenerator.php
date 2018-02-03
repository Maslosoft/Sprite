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

namespace Maslosoft\Sprite;

use Maslosoft\Cli\Shared\ConfigReader;
use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Sprite\Helpers\ImageFinder;
use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Interfaces\ConfigurationAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Maslosoft\Sprite\Models\Collection;
use Maslosoft\Sprite\Models\Configuration;
use Maslosoft\Sprite\Traits\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

/**
 * CompoundGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CompoundGenerator extends Configuration implements GeneratorInterface, LoggerAwareInterface
{

	use LoggerAwareTrait;

	const DefaultInstanceId = 'sprite';

	/**
	 * Sprite packages
	 * @var SpritePackageInterface[]
	 */
	private $packages = [];

	public function __construct($configName = self::DefaultInstanceId)
	{

		$config = new ConfigReader($configName);
		$di = EmbeDi::fly($configName);
		$di->apply($config->toArray(), $this);
		$di->configure($this);
		if (is_string($this->logger))
		{
			$loggerClass = $this->logger;
			$this->logger = new $loggerClass;
		}
	}

	public function add(SpritePackageInterface $package)
	{
		$this->packages[] = $package;
	}

	public function generate()
	{
		$di = new EmbeDi();
		$sprites = (new ImageFinder())->find($this->packages);

		$collection = new Collection($sprites);
		foreach ($this->generators as $generatorConfig)
		{
			$generator = $di->apply($generatorConfig);
			/* @var $generator GeneratorInterface */
			if ($generator instanceof CollectionAwareInterface)
			{
				$generator->setCollection($collection);
			}
			if ($generator instanceof ConfigurationAwareInterface)
			{
				$generator->setConfig($this);
			}
			if ($generator instanceof LoggerAwareInterface)
			{
				$generator->setLogger($this->getLogger());
			}
			$generator->generate();
		}
	}

}
