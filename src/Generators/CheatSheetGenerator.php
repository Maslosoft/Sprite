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

use Maslosoft\MiniView\MiniView;
use Maslosoft\Sprite\Helpers\FolderChecker;
use Maslosoft\Sprite\Interfaces\CollectionAwareInterface;
use Maslosoft\Sprite\Interfaces\ConfigurationAwareInterface;
use Maslosoft\Sprite\Interfaces\GeneratorInterface;
use Maslosoft\Sprite\Models\CheatSheetSprite;
use Maslosoft\Sprite\Traits\CollectionAwareTrait;
use Maslosoft\Sprite\Traits\ConfigurationAwareTrait;

/**
 * Generate HTML cheat sheet with all of the icons
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CheatSheetGenerator implements GeneratorInterface, CollectionAwareInterface, ConfigurationAwareInterface
{

	use ConfigurationAwareTrait,
	  CollectionAwareTrait;

	/**
	 * View instance
	 * @var MiniView
	 */
	private MiniView $mv;

	public function __construct()
	{
		$this->mv = new MiniView($this);
	}

	public function generate(): void
	{
		$collection = $this->getCollection();
		$config = $this->getConfig();
		FolderChecker::check($config);

		$hasConsts = false;
		$sprites = [];
		foreach ($collection->getSprites() as $sprite)
		{
			$cSprite = new CheatSheetSprite($sprite);
			$sprites[] = $cSprite;
			if (!$hasConsts && $cSprite->hasConstants)
			{
				$hasConsts = true;
			}
		}

		uasort($sprites, [$this, 'compare']);

		$table = $this->mv->render('cheat-sheet.latte', ['sprites' => $sprites, 'hasConsts' => $hasConsts], true);

		// Generate raw table
		$filename = sprintf('%s/%s-table.html', $config->generatedPath, $config->basename);
		file_put_contents($filename, $table);

		$cssFileName = sprintf('%s/%s.css', $config->generatedPath, $config->basename);
		$pngFileName = sprintf('%s/%s.png', $config->generatedPath, $config->basename);
		$pngImage = base64_encode(file_get_contents($pngFileName));
		$pattern = sprintf('url(%s.png)', $config->basename);
		$replace = sprintf('url(data:image/png;base64,%s)', $pngImage);
		$cssContents = file_get_contents($cssFileName);
		$css = str_replace($pattern, $replace, $cssContents);

		// Generate index
		$params = [
			'table' => $table,
			// Use base name, as cheet sheet is in same directory
			// and base name in config might point to sub-folder
			'css' => $css,
			'hasConsts' => $hasConsts
		];

		$index = $this->mv->render('cheat-sheet-index.latte', $params, true);
		$indexFilename = sprintf('%s/%s-index.html', $config->generatedPath, $config->basename);
		file_put_contents($indexFilename, $index);
	}

	public function compare(CheatSheetSprite $a, CheatSheetSprite $b)
	{
		if ($a->cssClass == $b->cssClass)
		{
			return 0;
		}
		return ($a->cssClass < $b->cssClass) ? -1 : 1;
	}

}
