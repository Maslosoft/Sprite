<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Helpers;

/**
 * Normalize css/constants names
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Normalizer
{

	public static function camelize()
	{
		return str_replace($separator, '', ucwords($input, $separator));
	}

	public static function decamelize()
	{
		return ltrim(strtolower(preg_replace('/[A-Z]/', "$separator$0", $input)), $separator);
	}

}
