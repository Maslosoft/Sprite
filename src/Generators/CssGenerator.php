<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Generators;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Helpers\FolderChecker;
use Maslosoft\Sprite\Helpers\Namer;
use Maslosoft\Sprite\Interfaces\CssGeneratorInterface;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;
use Maslosoft\Sprite\Traits\ConfigurationAwareTrait;

/**
 * CssGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CssGenerator implements CssGeneratorInterface
{

	use ConfigurationAwareTrait,
	  CollectionAwareTrait;

	/**
	 * View instance
	 * @var MiniView
	 */
	private $mv = null;

	public function __construct()
	{
		$this->mv = new MiniView($this);
	}

	public function generate()
	{
		$collection = $this->getCollection();
		$config = $this->getConfig();
		FolderChecker::check($config);
		$css = [];
		$squares = [];
		$rects = [];

		foreach ($collection->getSprites() as $image)
		{
			if ($image->isSquare())
			{
				$squares[$image->width] = $image->width;
			}
			else
			{
				$size = sprintf('%sx%s', $image->width, $image->height);
				$rects[$size] = [
					$image->width,
					$image->height
				];
			}
		}

		// Square icons
		foreach ($squares as $size)
		{
			$params = [
				'prefix' => $config->iconCssClass,
				'size' => $size
			];
			$css[] = $this->mv->render('css-square.latte', $params, true);
		}

		// Rectangle icons
		foreach ($rects as $size)
		{
			$params = [
				'prefix' => $config->iconCssClass,
				'width' => $size[0],
				'height' => $size[1]
			];
			$css[] = $this->mv->render('css-rect.latte', $params, true);
		}

		// Generate css for each image
		foreach ($collection->getGroups() as $group)
		{
			$top = $group->height;
			foreach ($group->sprites as $image)
			{
				foreach ($image->packages as $package)
				{
					$params = [
						'cssClass' => Namer::nameCssClass($package, $image),
						'horizontal' => -$group->offset,
						'vertical' => $top - $group->height
					];
					$css[] = $this->mv->render('css-icon.latte', $params, true);
				}
				// NOTE: This must be in sprites loop, not packages loop
				$top -= $image->height;
			}
		}

		$filename = sprintf('%s/%s.css', $config->generatedPath, $config->basename);
		file_put_contents($filename, implode("\n", $css));
	}

}
