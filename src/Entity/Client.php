<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['lire']],)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read','lire'])]

    private ?string $nom_societe = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: UserClient::class)]
   
    #[Groups(['lire'])]

    private Collection $user_clients;

    public function __construct()
    {
        $this->user_clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSociete(): ?string
    {
        return $this->nom_societe;
    }

    public function setNomSociete(string $nom_societe): static
    {
        $this->nom_societe = $nom_societe;

        return $this;
    }

    /**
     * @return Collection<int, UserClient>
     */
    public function getUserClients(): Collection
    {
        return $this->user_clients;
    }

    public function addUserClient(UserClient $userClient): static
    {
        if (!$this->user_clients->contains($userClient)) {
            $this->user_clients->add($userClient);
            $userClient->setClient($this);
        }

        return $this;
    }

    public function removeUserClient(UserClient $userClient): static
    {
        if ($this->user_clients->removeElement($userClient)) {
            // set the owning side to null (unless already changed)
            if ($userClient->getClient() === $this) {
                $userClient->setClient(null);
            }
        }

        return $this;
    }
}
