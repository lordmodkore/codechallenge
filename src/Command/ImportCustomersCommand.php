<?php

// src/Command/ImportCustomersCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Service\CustomerImporterService;
class ImportCustomersCommand extends Command
{
	private $customerImporterService;

	public function __construct(CustomerImporterService $customerImporterService)
	{
		$this->customerImporterService = $customerImporterService;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('app:import-customers')
			->setDescription('Import customers from third-party API')
			->addOption('count', 'c', InputOption::VALUE_REQUIRED, 'Number of customers to import', 100);

	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Fetch the count option value
		$count = $input->getOption('count');

		$this->customerImporterService->importCustomers($count);

		$output->writeln(sprintf('Successfully imported %d customers.', $count));

		return Command::SUCCESS;
	}
}
