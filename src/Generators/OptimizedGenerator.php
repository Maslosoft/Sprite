<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Generators;

use Maslosoft\Sprite\Interfaces\ConfigurationAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Traits\ConfigurationAwareTrait;
use Maslosoft\Sprite\Traits\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

/**
 * Generate optimized file
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class OptimizedGenerator implements GeneratorInterface, ConfigurationAwareInterface, LoggerAwareInterface
{

	use ConfigurationAwareTrait,
	  LoggerAwareTrait;

	public function generate()
	{
		$config = $this->getConfig();
		$dst = sprintf('%s/%s.png', $config->generatedPath, $config->basename);
		if (!empty($config->optimizer))
		{

			$src = str_replace('.png', '', $dst);
			rename($dst, $src);
//			$this->logger->info(sprintf('Running PNG optimizer `%s`', $this->optimizer));
			$cmd = strtr($config->optimizer, [
				'{src}' => $src,
				'{dst}' => $dst
			]);
			$output = [];
			$result = 0;
			exec($cmd, $output, $result);
			unlink($src);
			// Log on failure
			if ($result !== 0)
			{
//				$this->logger->debug(implode(PHP_EOL, $output));
			}
		}
	}

}
