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

namespace Maslosoft\Sprite\Commands;

use Maslosoft\Addendum\Interfaces\AnnotatedInterface;
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
class LocalCommand extends ConsoleCommand implements AnnotatedInterface
{

	protected function configure(): void
	{
		parent::configure();
		$this->setName("local");
		$this->setDescription("Generate sprite image, CSS and possibly other files locally");
		$this->setHelp(<<<EOT
The <info>generate</info> command will generate sprite image and CSS based on local <info>sprite.yml</info> or any EmbeDi configuration.

This might also generate helper files such as:
	- HTML Cheat Sheet with all generated icons
	- Class with constants containing sprite package CSS names
	- User provided generators

See <info>sprite.yml</info> for default configuration.
EOT
		);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		(new Generator)->generate();
		return 0;
	}

	/**
	 * @SlotFor(Command)
	 * @param Command $signal
	 */
	public function reacOn(Command $signal): void
	{
		$signal->add($this, 'sprite');
	}

}
