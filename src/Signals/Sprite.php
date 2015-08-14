<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Signals;

use Maslosoft\Signals\Interfaces\SignalInterface;

/**
 * Respond to this signal to instruct sprite
 * generator where are icons located and how the should be named.
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Sprite implements SignalInterface
{

	/**
	 * Icon prefix. This is important parameter, as it is used by CSS as selector.
	 * This can be usefull to create icon namespace for application module.
	 * @var string
	 */
	public $iconPrefix = '';

	/**
	 * Absolute paths to scan for icons.
	 * It cat be paths to folder or to single icons:
	 * ```php
	 * $paths = [
	 * 		'/var/www/some/application/assets/',
	 * 		'/tmp/some-icon.png'
	 * ]
	 * ```
	 *
	 * If path have sub directories these will be added to icon name as prefix.
	 * For example, when configured path is
	 * ```php
	 * $paths = [
	 * 		'/var/www/some/application/assets/',
	 * ]
	 * ```
	 * And real paths are
	 * ```
	 * Paths:
	 * /var/www/some/application/assets/16/
	 * /var/www/some/application/assets/32/
	 * ```
	 * This will result in icons with two prefixes of `16` and `32`.
	 * This is usefull for icon sizing. So when using icon, one would know
	 * it's size just by the icon name.
	 * @var string[]
	 */
	public $paths = '';

}
