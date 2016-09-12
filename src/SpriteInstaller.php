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

namespace Maslosoft\Sprite;

use Maslosoft\Ilmatar\Components\Install\InstallersBase;

/**
 * Sprite installer
 * @deprecated since version 3
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SpriteInstaller extends InstallersBase
{

	public function install()
	{
		$sprite = new Generator();
		$sprite->generate();
		$this->installer->success(tx('Rebuild sprite', 'Maslosoft.Sprite.Installer'));
	}

}
