<?php

namespace Helpers;

use Codeception\Test\Unit;
use Maslosoft\Sprite\Helpers\ImageSorter;
use Maslosoft\Sprite\Models\SpriteImage;
use Symfony\Component\Finder\Finder;
use UnitTester;

class ImageSorterTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// tests
	public function testIfWillProperlySort()
	{
		$path = ASSETS_DIR . '/helpers/image-sorter';

		// Get icons
		$finder = new Finder();

		$finder->sortByChangedTime();
		$finder->sortByAccessedTime();

		$sprites = [];
		foreach ($finder->in($path) as $fileInfo)
		{
			$sprites[] = new SpriteImage($path, $fileInfo);
		}

		// Should be 5 images
		$this->assertSame(5, count($sprites));

		// Current order
		$current = [];
		foreach ($sprites as $sprite)
		{
			$current[] = $sprite->info->getBasename();
		}

		// Sort images
		ImageSorter::sort($sprites, ImageSorter::SortWidth | ImageSorter::SortHeight | ImageSorter::SortSize);

		$expected = [
			'logo-50.png', // Smallest file
			'logo-60x100.png', // Wider than logo-50.png
			'blurred-logo-60x100.png', // Larger than logo-60x100.png
			'logo-100.png',
			'logo-60x120.png', // Wider than logo-60x100.png
		];

		$actual = [];
		foreach ($sprites as $sprite)
		{
			$actual[] = $sprite->info->getBasename();
		}

		$this->assertSame($expected, $actual);
	}

}
