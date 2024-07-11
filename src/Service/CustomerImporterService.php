<?php

// src/Service/CustomerImporterService.php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Customer;

class CustomerImporterService
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function importCustomers(int $count)
	{
		$httpClient = HttpClient::create();
		$response = $httpClient->request('GET', "https://randomuser.me/api/?results={$count}&nat=au");

		$data = $response->toArray();




		foreach ($data['results'] as $userData) {
			// Check if customer already exists by email
			$existingCustomer = $this->entityManager->getRepository(Customer::class)->findOneBy(['email' => $userData['email']]);

			if ($existingCustomer instanceof Customer) {
				// Update existing customer
				$existingCustomer->setFirstName($userData['name']['first']);
				$existingCustomer->setLastName($userData['name']['last']);
				$existingCustomer->setCountry($userData['nat']);
				$existingCustomer->setCity($userData['location']['city']);
				$existingCustomer->setPhone($userData['phone']);
				$existingCustomer->setUsername($userData['login']['username']);
				$existingCustomer->setPassword($userData['login']['password']);
				// Update other fields as needed

				$this->entityManager->persist($existingCustomer);
			} else {
				// Create new customer
				$customer = new Customer();
				$customer->setFirstName($userData['name']['first']);
				$customer->setLastName($userData['name']['last']);
				$customer->setEmail($userData['email']);
				$customer->setGender($userData["gender"]);
				$customer->setCountry($userData['nat']);
				$customer->setCity($userData['location']['city']);
				$customer->setPhone($userData['phone']);
				$customer->setUsername($userData["login"]['username']);
				$customer->setPassword($userData["login"]['password']);
				// Set other fields as needed

				$this->entityManager->persist($customer);
			}
		}

		$this->entityManager->flush();
	}
}
