<?php
// src/Controller/CustomerController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
class CustomerController extends AbstractController
{

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @Route("/customers", name="customer_list", methods={"GET"})
	 */
	public function listCustomers(): JsonResponse
	{
		$customers = $this->entityManager->getRepository(Customer::class)->findAll();
		$data = [];

		foreach ($customers as $customer) {
			$data[] = [
				'fullName' => $customer->getFirstName() . ' ' . $customer->getLastName(),
				'email' => $customer->getEmail(),
				'country' => $customer->getCountry(),
			];
		}

		return $this->json($data);
	}

	/**
	 * @Route("/customers/{customerId}", name="customer_show", methods={"GET"})
	 */
	public function getCustomerDetails(int $customerId): JsonResponse
	{
		$customer = $this->entityManager->getRepository(Customer::class)->find($customerId);

		if (!$customer) {
			throw $this->createNotFoundException('Customer not found');
		}

		$data = [
			'fullName' => $customer->getFirstName() . ' ' . $customer->getLastName(),
			'email' => $customer->getEmail(),
			'username' => $customer->getUsername(),
			'gender' => $customer->getGender(),
			'country' => $customer->getCountry(),
			'city' => $customer->getCity(),
			'phone' => $customer->getPhone(),
		];

		return $this->json($data);
	}
}
