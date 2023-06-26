<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSubscriber implements EventSubscriberInterface
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface )
    {
    
    }
    public function hashPasswor(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof User || (!in_array($method,[Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH ])) )
        {
            Return;
        }

        $hashedPassword = $this->userPasswordHasherInterface->hashPassword(
            $entity,
            $entity->getPassword()
        );
        $entity->setPassword($hashedPassword);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['hashPasswor',EventPriorities::PRE_WRITE],
        ];
    }
}
