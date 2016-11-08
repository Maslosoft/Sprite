<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/sprite
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @copyright Copyright (c) Others as mentioned in code
 * @link http://maslosoft.com/sprite/
 */

namespace Maslosoft\Sprite\Interfaces;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface SpritePackageInterface
{

	public function getConstantsClass();

	public function getConstantsClassPath();

	public function getConstantsConverter();

	public function getCssClassNameConverter();

	public function getIconPrefix();

	public function getPaths();

	public function setConstantsClass($constantsClass);

	public function setConstantsClassPath($constantsClassPath);

	public function setConstantsConverter($constantsConverter);

	public function setCssClassNameConverter($cssClassNameConverter);

	public function setIconPrefix($iconPrefix);

	public function setPaths($paths);
}
