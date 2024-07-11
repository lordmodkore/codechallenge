<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "customers")]
class Customer
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private ?int $id;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $firstName;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $lastName;

	#[ORM\Column(type: "string", length: 255, unique: true)]
	private ?string $email;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $country;

	#[ORM\Column(type: "string", length: 255,nullable:true)]
	private ?string $city;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $phone;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $password;

	#[ORM\Column(type: "string", length: 255)]
	private ?string $username;

	#[ORM\Column(type: "string", length: 10)]
	private ?string $gender;

	// Constructor is optional and can be used to initialize properties

	public function __construct(
		?string $firstName = null,
		?string $lastName = null,
		?string $email = null,
		?string $country = null,
		?string $city = null,
		?string $phone = null,
		?string $password = null,
		?string $username = null,
		?string $gender = null
	) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->country = $country;
		$this->city = $city;
		$this->phone = $phone;
		$this->password = $password;
		$this->username = $username;
		$this->gender = $gender;
	}

	// Getters and setters for each property

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): self
	{
		$this->id = $id;
		return $this;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

	public function setCountry(string $country): self
	{
		$this->country = $country;
		return $this;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(string $city): self
	{
		$this->city = $city;
		return $this;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function setPhone(string $phone): self
	{
		$this->phone = $phone;
		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		// Example: MD5 hashing (not recommended for real applications, use secure hashing methods)
		$this->password = md5($password);
		return $this;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(string $username): self
	{
		$this->username = $username;
		return $this;
	}

	public function getGender(): ?string
	{
		return $this->gender;
	}

	public function setGender(string $gender): self
	{
		$this->gender = $gender;
		return $this;
	}
}
