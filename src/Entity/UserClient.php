<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserClientRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GET;
use ApiPlatform\Metadata\GetCollection;

use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: UserClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read']])]
#[POST(    uriTemplate:'api/clients/import')]
#[GET()]
#[GetCollection()]
class UserClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read','lire'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read','lire'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read','lire'])]

    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read','lire'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read','lire'])]

    private ?string $code_postal = null;

    #[ORM\ManyToOne(inversedBy: 'user_clients')]
   
    #[Groups(['read'])]

    private ?Client $client = null;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
