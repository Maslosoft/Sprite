<?php

namespace Helpers;

use Codeception\Test\Unit;
use Maslosoft\Sprite\Helpers\ConstantsFactory;
use Maslosoft\Sprite\Helpers\ImageFinder;
use Maslosoft\Sprite\Icon\I;
use Maslosoft\Sprite\Models\ConstClass;
use Maslosoft\Sprite\Models\Package;
use ReflectionClass;
use UnitTester;
use const ASSETS_DIR;

class ConstantsFactoryTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// tests
	public function testIfWillCreateConstClassFile(): void
	{
		$path = ASSETS_DIR . '/helpers/image-finder';

		$classPath = dirname((new ReflectionClass(I::class))->getFileName());
		$classFile = sprintf('%s/I2.php', $classPath);

		codecept_debug($classFile);

		@unlink($classFile);

		$package = new Package();
		$package->paths = [$path];
		$package->constantsClassPath = $classPath;
		$package->constantsClass = 'Maslosoft\Sprite\Icon\I2';
		$packages = [$package];
		$sprites = (new ImageFinder)->find($packages);

		// Should be 6 images
		$this->assertCount(6, $sprites);

		$consts = ConstantsFactory::create($sprites);

//		codecept_debug($consts);

		$this->assertFileExists($classFile);
		$this->assertCount(1, $consts, 'That one constants definition class was created');
	}

	public function testIfWillCreateConstClassInstance(): void
	{
		$path = ASSETS_DIR . '/helpers/image-finder';

		$package = new Package();
		$package->paths = [$path];
		$package->constantsClass = I::class;
		$packages = [$package];
		$sprites = (new ImageFinder)->find($packages);

		// Should be 6 images
		$this->assertCount(6, $sprites);

		$consts = ConstantsFactory::create($sprites);

//		codecept_debug($consts);

		$this->assertCount(1, $consts, 'That one constants definition class was created');
	}

	public function testIfWillCreateConstClassInstanceWithTwoPackages(): void
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

		// Should be 10 images
		$this->assertCount(10, $sprites);

		$consts = ConstantsFactory::create($sprites);


		$this->assertCount(1, $consts, 'That one constants definition class was created');

		$const = array_pop($consts);
		/* @var $const ConstClass */
		$this->assertInstanceOf(ConstClass::class, $const);

		$this->assertCount(4, $const->constants, "That has constants for 4 icons, only from `$path2`");
	}

}
