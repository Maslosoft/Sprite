<?php

namespace Models;

use Codeception\Test\Unit;
use Maslosoft\Sprite\Helpers\ImageFinder;
use Maslosoft\Sprite\Models\Collection;
use Maslosoft\Sprite\Models\Group;
use Maslosoft\Sprite\Models\Package;
use Maslosoft\Sprite\Models\SpriteImage;
use UnitTester;
use const ASSETS_DIR;

class CollectionTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// tests
	public function testIfWillProperlyCreateCollectionOfSpriteImages(): void
	{
		$path1 = ASSETS_DIR . '/models/collection';
		$path2 = ASSETS_DIR . '/models/collection/deeper';

		$package1 = new Package();
		$package1->paths = [$path1];

		$package2 = new Package();
		$package2->paths = [$path2];

		$packages = [$package1, $package2];
		$images = (new ImageFinder)->find($packages);

		$collection = new Collection($images);

		$sprites = $collection->getSprites();

		// Should be 6 images
		$this->assertCount(6, $sprites);

		foreach ($sprites as $sprite)
		{
			$this->assertInstanceOf(SpriteImage::class, $sprite);
		}
		$groups = $collection->getGroups();
		$this->assertIsArray($groups);
		$this->assertGreaterThan(0, count($groups), 'That collection have groups');

		$this->assertGreaterThan(0, $collection->height, 'That collection have height');
		$this->assertGreaterThan(0, $collection->width, 'That collection have width');

		foreach ($groups as $group)
		{
			$this->assertInstanceOf(Group::class, $group);
		}
	}

}
