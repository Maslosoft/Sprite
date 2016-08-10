<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Sprite\Generators\CheatSheetGenerator;
use Maslosoft\Sprite\Generators\ConstantsGenerator;
use Maslosoft\Sprite\Generators\CssGenerator;
use Maslosoft\Sprite\Generators\ImgGenerator;
use Maslosoft\Sprite\Helpers\ImageFinder;
use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Interfaces\ConfigurationAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Maslosoft\Sprite\Models\Collection;
use Maslosoft\Sprite\Models\Configuration;

/**
 * CompoundGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CompoundGenerator implements GeneratorInterface
{

	/**
	 * Sprite packages
	 * @var SpritePackageInterface[]
	 */
	private $packages = [];

	public function add(SpritePackageInterface $package)
	{
		$this->packages[] = $package;
	}

	public function generate()
	{
		$config = new Configuration();
		$di = new EmbeDi();
		$sprites = (new ImageFinder())->find($this->packages);
		$collection = new Collection($sprites);
		foreach ($config->generators as $generatorConfig)
		{
			$generator = $di->apply($generatorConfig);
			/* @var $generator GeneratorInterface */
			if ($generator instanceof CollectionAwareInterface)
			{
				$generator->setCollection($collection);
			}
			if ($generator instanceof ConfigurationAwareInterface)
			{
				$generator->setConfig($config);
			}
			$generator->generate();
		}
	}

}
