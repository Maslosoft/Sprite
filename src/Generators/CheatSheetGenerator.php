<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

		$sprites = [];
		foreach ($collection->getSprites() as $sprite)
		{
			$sprites[] = new CheatSheetSprite($sprite);
		}

		uasort($sprites, [$this, 'compare']);

		$table = $this->mv->render('cheat-sheet.latte', ['sprites' => $sprites], true);

		// Generate raw table
		$filename = sprintf('%s/%s-table.html', $config->generatedPath, $config->basename);
		file_put_contents($filename, $table);

		// Generate index
		$params = [
			'table' => $table,
			// Use base name, as cheet sheet is in same directory
			// and base name in config might point to sub-folder
			'css' => sprintf('%s.css', basename($config->basename))
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
