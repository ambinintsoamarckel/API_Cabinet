<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWTSubscriber implements EventSubscriberInterface
{
    public function onLexikJwtAuthenticationOnJwtCreated(JWTCreatedEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if ($user instanceof User) {
            // Vérifiez si l'utilisateur est actif
      


            $data['username'] = $user->getUserIdentifier();
            $data['telephone']= $user->getTelephone();
       


        }

        $event->setData($data);
    }


    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}
