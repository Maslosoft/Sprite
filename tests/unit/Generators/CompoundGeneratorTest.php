<?php

namespace Helpers;

use Codeception\Test\Unit;
use Maslosoft\Sprite\CompoundGenerator;
use Maslosoft\Sprite\Icon\I;
use Maslosoft\Sprite\Icon\I4;
use Maslosoft\Sprite\Models\Package;
use ReflectionClass;
use ReflectionObject;
use UnitTester;
use const ASSETS_DIR;

class CompoundGeneratorTest extends Unit
{

	/**
	 * @var UnitTester
	 */
	protected $tester;

	// tests
	public function testIfGenerateAllWhatsNeeded(): void
	{
		$generator = new CompoundGenerator();

		$classPath = dirname((new ReflectionClass(I::class))->getFileName());
		$classFile = sprintf('%s/I3.php', $classPath);

		@unlink($classFile);

		$path1 = ASSETS_DIR . '/helpers/image-finder';
		$package1 = new Package();
		$package1->paths = [$path1];
		$package1->constantsClassPath = $classPath;
		$package1->constantsClass = 'Maslosoft\Sprite\Icon\I3';

		$path2 = ASSETS_DIR . '/helpers/image-finder2';

		$package2 = new Package();
		$package2->paths = [$path2];
		$package2->constantsClass = I4::class;

		$path3 = ASSETS_DIR . '/helpers/image-finder-one';
		$package3 = new Package();
		// Same set of one icon
		$package3->paths = [$path3];
		$package3->constantsClassPath = $classPath;
		$package3->constantsClass = 'Maslosoft\Sprite\Icon\I5';

		// Add packages and generate
		$generator->add($package1);
		$generator->add($package2);
		$generator->add($package3);
		$generator->generate();

		$this->assertFileExists($classFile);
		$n = 'Maslosoft\Sprite\Icon\I3';
		$x = new $n;
		$info1 = new ReflectionObject($x);
		$info2 = new ReflectionClass(I4::class);
		codecept_debug($info1->getConstants());
		codecept_debug($info1->getFileName());

		$constants1 = $info1->getConstants();
		$this->assertCount(6, $constants1);
		$this->assertCount(4, $info2->getConstants());
	}

}
