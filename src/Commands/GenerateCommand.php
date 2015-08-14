<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Sprite\Commands;

use Maslosoft\Sitcom\Command;
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
		$this->setDescription("Generate sprites");
		$this->setHelp(<<<EOT
The <info>generate</info> command emit's signal to gather icons and generate sprite image.
EOT
		);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
//		$zamm = new \Maslosoft\Zamm\Zamm();
//		(new \Maslosoft\Zamm\File\Applier($input, $output))->apply();
	}

	public function reacOn(Command $signal)
	{
		$signal->add($this, 'sprite');
	}

}
