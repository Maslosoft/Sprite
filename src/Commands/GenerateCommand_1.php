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

namespace Maslosoft\Sprite\Commands;

use Maslosoft\Sitcom\Command;
use Maslosoft\Sprite\Generator;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * GenerateCommand
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SignalCommand extends ConsoleCommand
{

	protected function configure()
	{
		parent::configure();
		$this->setName("generate");
		$this->setDescription("Generate sprite image, CSS and possibly other files based on emitted signal");
		$this->setHelp(<<<EOT
The <info>generate</info> command will generate sprite image and CSS based local on <info>sprite.yml</info> possible EmbeDi configuration sources and emitted signal result.

This might also generate helper files such as:
	- HTML Cheat Sheet with all generated icons
	- Class with constants containing sprite package CSS names
	- User provided generators

See <info>sprite.yml</info> for default configuration.
EOT
		);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		(new Generator)->generate();
	}

	/**
	 * @SlotFor(Command)
	 * @param Command $signal
	 */
	public function reacOn(Command $signal)
	{
		$signal->add($this, 'sprite');
	}

}
