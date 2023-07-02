<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;


trait CommonDate
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getCreatedAt():?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    

    public function getUpdatedAt():?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt():void
    {
        $this->updatedAt = new \DateTimeImmutable();
      
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]

   public function updatedAt()
   {
    if ($this->getCreatedAt() == null)
     {
            $this->setCreatedAt( new \DateTimeImmutable());
     }
        $this->setUpdatedAt( new \DateTimeImmutable());
    

   }

}
