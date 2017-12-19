<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\SpriteTest\Extensions;

use Codeception\Event\TestEvent;
use Codeception\Platform\Extension;
use Maslosoft\Sprite\Generator;

/**
 * SpriteWipe
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SpriteWipe extends Extension
{

	// list events to listen to
	public static $events = [
		'test.before' => 'testBefore',
	];

	public function testBefore(TestEvent $e)
	{
		$dir = 'generated';
		@unlink(sprintf('%s/sprite.css', $dir));
		@unlink(sprintf('%s/sprite.png', $dir));
	}

}
