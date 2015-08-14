<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Application;

use Maslosoft\Sprite\Commands\GenerateCommand;
use Maslosoft\Sprite\Generator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * Application
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Application extends ConsoleApplication
{

	/**
	 * Logo
	 * font: slant
	 */
	const Logo = <<<LOGO
   _____            _ __
  / ___/____  _____(_) /____
  \__ \/ __ \/ ___/ / __/ _ \
 ___/ / /_/ / /  / / /_/  __/
/____/ .___/_/  /_/\__/\___/
    /_/

LOGO;

	public function __construct()
	{
		parent::__construct('Sprite', (new Generator)->getVersion());
	}

	public function getHelp()
	{
		return self::Logo . parent::getHelp();
	}

	/**
	 * Gets the default commands that should always be available.
	 *
	 * @return Command[] An array of default Command instances
	 */
	public function getDefaultCommands()
	{
		$commands = parent::getDefaultCommands();

		$commands[] = new GenerateCommand();

		return $commands;
	}

}
