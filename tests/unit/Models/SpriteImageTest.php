<?php

namespace Models;

use Maslosoft\Sprite\Models\SpriteImage;
use Symfony\Component\Finder\Finder;

class SpriteImageTest extends \Codeception\TestCase\Test
{

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// tests
	public function testIfwillProperlyCreateSpriteImage()
	{
		$path = ASSETS_DIR . '/models';

		// Let finder create SplFileInfo
		$finder = new Finder();
		$finder->in($path);
		$finder->name('logo-60x100.png');

		// Should be one file
		$this->assertSame(1, $finder->count());
		foreach ($finder as $fileInfo)
		{
			// empty
		}

		$si = new SpriteImage($path, $fileInfo);

		$this->assertSame($path, $si->basePath);

		$this->assertSame(1287, $si->size);

		$this->assertSame(100, $si->width);
		$this->assertSame(60, $si->height);

		$this->assertSame('image/png', $si->mime);

		$this->assertSame('png', $si->type);

		$this->assertSame('sprite-image-icons-logo-60x100', $si->name);
	}

}
