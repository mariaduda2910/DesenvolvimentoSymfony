<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    #[ORM\OneToOne(mappedBy: "user", targetEntity: Customer::class, cascade: ["persist", "remove"])]
    private ?Customer $customer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getisAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setisAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;

        
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        // Define o lado inverso da relação
        if ($customer !== null && $customer->getUser() !== $this) {
            $customer->setUser($this);
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles ?? [];
        return array_unique(array_merge($roles, ['ROLE_USER']));
    }

    public function eraseCredentials(): void
    {
        $this->password = null; // Limpa a senha após o login
    }

    // Implementação do método getUserIdentifier
    public function getUserIdentifier(): string
    {
        return (string) $this->email; // Retorna o email como identificador único
    }


}
