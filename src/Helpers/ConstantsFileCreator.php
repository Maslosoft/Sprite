<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Models\Package;
use RuntimeException;

/**
 * ConstantsFileCreator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ConstantsFileCreator
{

	public static function generate(Package $package)
	{
		$path = $package->getConstantsClassPath();

		if (empty($path))
		{
			return;
		}
		$className = $package->getConstantsClass();

		$parts = explode('\\', $className);
		$name = array_pop($parts);
		$ns = implode('\\', $parts);
		$fileName = sprintf('%s/%s.php', $path, $name);

		if (!file_exists($fileName))
		{

			$view = new MiniView(new self);
			$params = [
				'tag' => '<?php',
				'ns' => $ns,
				'name' => $name
			];
			$def = $view->render('constantsClass.latte', $params, true);
			$result = file_put_contents($fileName, $def);
			assert($result, new RuntimeException("Could not write into $fileName"));
		}
	}

}
