<?php

namespace Helpers;

use Maslosoft\Sprite\Helpers\ImageFinder;
use Maslosoft\Sprite\Models\Package;
use Maslosoft\Sprite\Models\SpriteImage;
use UnitTester;
use const ASSETS_DIR;

class ImageFinderTest extends \Codeception\TestCase\Test
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// tests
	public function testIfWillFindImagesWithoutDuplicatesWithOnePackage()
	{
		$path = ASSETS_DIR . '/helpers/image-finder';

		$package = new Package();
		$package->paths = [$path];
		$packages = [$package];
		$sprites = (new ImageFinder)->find($packages);

		// Should be 5 images
		$this->assertSame(5, count($sprites));

		foreach ($sprites as $sprite)
		{
			$this->assertInstanceOf(SpriteImage::class, $sprite);
			$packages = count($sprite->packages);
			$this->assertSame(1, $packages);
			$this->assertInstanceOf(Package::class, $sprite->packages[0]);
		}
	}

	public function testIfWillFindImagesWithTwoPackagesAndOneContainingConstClass()
	{
		$path = ASSETS_DIR . '/helpers/image-finder';

		$package = new Package();
		$package->paths = [$path];

		$path2 = ASSETS_DIR . '/helpers/image-finder2';
		$package2 = new Package();
		$package2->paths = [$path2];
		$package2->constantsClass = I::class;

		$packages = [$package, $package2];

		$sprites = (new ImageFinder)->find($packages);

		// Should be 9 images
		$this->assertSame(9, count($sprites));

		$withConstants = 0;
		foreach ($sprites as $sprite)
		{
			$this->assertInstanceOf(SpriteImage::class, $sprite);
			$packages = count($sprite->packages);
			$this->assertSame(1, $packages);
			$this->assertInstanceOf(Package::class, $sprite->packages[0]);
			$package = $sprite->packages[0];
			$const = $package->getConstantsClass();
			if (!empty($const))
			{
				$withConstants++;
			}
		}
		$this->assertSame(4, $withConstants, 'That there are 4 packages with constants');
	}

	public function testIfWillFindImagesWithoutDuplicatesWithTwoPackages()
	{
		$path1 = ASSETS_DIR . '/helpers/image-finder';
		$path2 = ASSETS_DIR . '/helpers/image-finder/deeper';

		$package1 = new Package();
		$package1->paths = [$path1];

		$package2 = new Package();
		$package2->paths = [$path2];

		$packages = [$package1, $package2];
		$sprites = (new ImageFinder)->find($packages);

		// Should be 5 images
		$this->assertSame(5, count($sprites));

		foreach ($sprites as $sprite)
		{
			$this->assertInstanceOf(SpriteImage::class, $sprite);
			$packages = count($sprite->packages);
			$this->assertInstanceOf(Package::class, $sprite->packages[0]);
			if ($packages == 2)
			{
				$this->assertInstanceOf(Package::class, $sprite->packages[1]);
			}
		}
	}

}
