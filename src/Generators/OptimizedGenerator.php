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
			$this->getLogger()->info(sprintf('Running PNG optimizer `%s`', $config->optimizer));
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
				$this->getLogger()->debug(implode(PHP_EOL, $output));
			}
		}
	}

}
