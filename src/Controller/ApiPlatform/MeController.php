<?php
namespace App\Controller\ApiPlatform;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class MeController extends AbstractController
{
      public function __construct(private Security $security)
    {
        
    }
    
    #[Route(path: '/api/me', name: 'api_me', methods: ['GET'])]
    public function __invoke()
    {
       
        $user = $this->security->getUser();

       
      
        if ($user) {
                $userData = [

                    'username' => $user->getUserIdentifier(),
                    'roles'=> $user->getRoles()

                    // Ajoutez d'autres propriétés que vous souhaitez inclure
                ];
                
                return new JsonResponse($userData);
            } else {
                return new JsonResponse(['message' => 'Utilisateur non connecté'], 401);
            }
        
    }
}
?>