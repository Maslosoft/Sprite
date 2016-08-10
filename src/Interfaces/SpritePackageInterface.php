<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Interfaces;

/**
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface SpritePackageInterface
{

	public function getConstantsClass();

	public function getConstantsConverter();

	public function getIconPrefix();

	public function getPaths();

	public function setConstantsClass($constantsClass);

	public function setConstantsConverter($constantsConverter);

	public function setIconPrefix($iconPrefix);

	public function setPaths($paths);
}
