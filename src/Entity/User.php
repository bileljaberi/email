<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource()]
#[Get(
    normalizationContext:['groups'=>['read']],
    uriTemplate:'users/afficher_user/{id}',
    )]
#[Post(
    denormalizationContext:['groups'=>['write']],
    normalizationContext:['groups'=>['read']],
    uriTemplate:'users/ajout_user/{id}',
    )]
#[GetCollection(
    normalizationContext:['groups'=>['read']],
    uriTemplate:'users/afficher_tous',
    )]
#[Delete(
    uriTemplate:'users/effacer_user/{id}',

)]
#[Put(
    uriTemplate:'users/modifier_user/{id}',

)]
#[Patch(
    name:'change_password',
    uriTemplate:'users/change_password/{id}',
    denormalizationContext:['groups'=>['change_password']],
    normalizationContext:['groups'=>['change_password']],

)]


class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;


    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "l'email est obligatoire")]
    #[Assert\Length(min: 10, max: 50, minMessage: "l email doit faire au moins {{ limit }} caractères",
     maxMessage: "L email ne peut pas faire plus de {{ limit }} caractères")]
    #[Groups(['write','read'])]

    private ?string $email = null;


    #[ORM\Column]
    #[Groups(['write','read'])]

    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(
        min:4,
        max:255,
        minMessage:'le password doit etre plus que {{ limit }} caractéres',
        maxMessage:'le password doit etre moin que {{ limit }} caractéres'

    )]
    #[groups(['change_password'])]

    private ?string $password = null;
    

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    
   
    

  
}
