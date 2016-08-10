<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Generators;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Helpers\Namer;
use Maslosoft\Sprite\Interfaces\CssGeneratorInterface;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;

/**
 * CssGenerator
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CssGenerator implements CssGeneratorInterface
{

	use CollectionAwareTrait;

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
		$css = [];
		$sizes = [];

		foreach ($collection->getSprites() as $image)
		{
			$sizes[$image->width] = $image->width;
		}

		foreach ($sizes as $size)
		{
//			$css[] = sprintf($template, $this->iconCssClass, $size);
			$params = [
				'prefix' => 'icon',
				'size' => $size
			];
			$this->mv->render('css-size', $params, true);
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
					$css[] = $this->mv->render('css-icon', $params, true);
				}
				// NOTE: This must be in sprites loop, not packages loop
				$top -= $image->height;
//				$css .= '.' . $this->iconCssClass . '-' . $image->name . '{';
//				$css .= 'background-position:' . -$group->offset . 'px ' . ($top - $group->height) . 'px;';
//				$css .= '}' . "\n";
//				$top -= $image->height;
			}
		}
	}

}
