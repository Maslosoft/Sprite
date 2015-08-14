<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
class GenerateCommand extends ConsoleCommand
{

	protected function configure()
	{
		parent::configure();
		$this->setName("generate");
		$this->setDescription("Generate sprite imge and CSS");
		$this->setHelp(<<<EOT
The <info>generate</info> command will generate sprite image and CSS based on <info>sprite.yml</info> and emitted signal result.
EOT
		);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		(new Generator)->generate();
	}

	public function reacOn(Command $signal)
	{
		$signal->add($this, 'sprite');
	}

}
