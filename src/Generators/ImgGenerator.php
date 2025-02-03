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

use Maslosoft\Sprite\Interfaces\SpriteGeneratorInterface;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;
use Maslosoft\Sprite\Traits\ConfigurationAwareTrait;
use UnexpectedValueException;

/**
 * ImgGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ImgGenerator implements SpriteGeneratorInterface
{

	use ConfigurationAwareTrait,
	  CollectionAwareTrait;

	public function generate(): void
	{
		$collection = $this->getCollection();
		$config = $this->getConfig();
		if ($collection->width === 0 || $collection->height === 0)
		{
			throw new UnexpectedValueException('Expected collection width and height to be grater than zero');
		}
		$sprite = imagecreatetruecolor($collection->width, $collection->height);
		imagesavealpha($sprite, true);
		$transparent = imagecolorallocatealpha($sprite, 0, 0, 0, 127); //127 not 100
		imagefill($sprite, 0, 0, $transparent);
		foreach ($collection->getGroups() as $group)
		{
			$top = 0;
			foreach ($group->sprites as $image)
			{
				$img = null;
				$path = $image->getFullPath();
				switch ($image->type)
				{
					case 'png':
						$img = imagecreatefrompng($path);
						break;
					case 'jpg':
						$img = imagecreatefromjpeg($path);
						break;
					case 'gif':
						$img = imagecreatefromgif($path);
						break;
					default:
						$img = null;
				}
				if (empty($img))
				{
					continue;
				}
				imagecopy($sprite, $img, $group->offset, $top, 0, 0, $image->width, $image->height);
				$top += $image['height'];
			}
		}

		$filename = sprintf('%s/%s.png', $config->generatedPath, $config->basename);
		imagepng($sprite, $filename);
		imagedestroy($sprite);
	}

}
