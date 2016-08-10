<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/sprite
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Sprite\Models;

use Maslosoft\Sprite\Helpers\Normalizer;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;

/**
 * Sprite package
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Package implements SpritePackageInterface
{

	/**
	 * If set, it will **override** this class with same class name,
	 * but containing formatted constants with icon names.
	 *
	 * This parameter combined with `iconPrefix` can be used to select
	 * icons based on class constants, with IDE autocomplete support, and shorter names.
	 *
	 * Possible example usage, assume class name is `Icon` or some namespaced
	 * name, let's say `Maslosoft\Module\Icon` and is imported here:
	 * ```php
	 * Icon::Folder; // icon-folder
	 * ```
	 *
	 * With `iconPrefix` constant name will be the same, however CSS name will be prefixed:
	 * ```php
	 * Icon::Folder; // icon-module-folder
	 * ```
	 * @var string
	 */
	public $constantsClass = '';

	/**
	 * Define any valid PHP callback to customize transformation constant names.
	 * By default they are camelized, ie:
	 * ```
	 * document-folder
	 * ```
	 * Will become:
	 * ```
	 * DocumentFolder
	 * ```
	 *
	 * Function accepts two parameter, package interface instance and sprite object.
	 *
	 * Example function:
	 * ```php
	 * $converter = function(SpritePackageInterface $package, SpriteImage $sprite)
	 * {
	 * 			// Basic camelize function
	 * 		return lcfirst(str_replace('-', '', ucwords($sprite->name, '-')));
	 * };
	 * ```
	 * @var callback
	 */
	public $constantsConverter = [Normalizer::class, 'camelize'];

	/**
	 * Define any valid PHP callback to customize transformation of CSS class names.
	 * By default they are decamelized, ie:
	 * ```
	 * Document-Folder
	 * ```
	 * Will become:
	 * ```
	 * document-folder
	 * ```
	 *
	 * Function accepts two parameter, package interface instance and sprite object.
	 *
	 * Example function:
	 * ```php
	 * $converter = function(SpritePackageInterface $package, SpriteImage $sprite)
	 * {
	 * 			// Basic camelize function
	 * 		return lcfirst(str_replace('-', '', ucwords($sprite->name, '-')));
	 * };
	 * ```
	 * @var callback
	 */
	public $cssClassNameConverter = [Normalizer::class, 'decamelize'];

	/**
	 * Icon prefix. It is used by CSS as selector.
	 * This can be usefull to create icon namespace for application module.
	 * Example icon CSS class name without prefix:
	 * ```
	 * 		icon-folder
	 * ```
	 * With prefix it will append this prefix after `icon` part
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
	 * 
	 * @var string[]
	 */
	public $paths = '';

	public function getConstantsClass()
	{
		return $this->constantsClass;
	}

	public function getConstantsConverter()
	{
		return $this->constantsConverter;
	}

	public function getCssClassNameConverter()
	{
		return $this->cssClassNameConverter;
	}

	public function getIconPrefix()
	{
		return $this->iconPrefix;
	}

	public function getPaths()
	{
		return $this->paths;
	}

	public function setConstantsClass($constantsClass)
	{
		$this->constantsClass = $constantsClass;
		return $this;
	}

	public function setConstantsConverter($constantsConverter)
	{
		$this->constantsConverter = $constantsConverter;
		return $this;
	}

	public function setCssClassNameConverter($cssClassNameConverter)
	{
		$this->cssClassNameConverter = $cssClassNameConverter;
		return $this;
	}

	public function setIconPrefix($iconPrefix)
	{
		$this->iconPrefix = $iconPrefix;
		return $this;
	}

	public function setPaths($paths)
	{
		$this->paths = $paths;
		return $this;
	}

}
