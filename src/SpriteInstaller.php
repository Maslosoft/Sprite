<?php

/**
 * @licence For licence @see LICENCE.html
 *
 * @copyright Maslosoft
 * @link http://maslosoft.com/
 */

namespace Maslosoft\Sprite;

use Maslosoft\Ilmatar\Components\Install\InstallersBase;

/**
 * Sprite installer
 * @deprecated since version 3
 * @SignalFor('Maslosoft\Ilmatar\Components\Install\Installer')
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SpriteInstaller extends InstallersBase
{

	public function install()
	{
		$sprite = new Generator();
		$sprite->reset();
		$this->installer->success(tx('Rebuild sprite', 'Maslosoft.Sprite.Installer'));
	}

}
