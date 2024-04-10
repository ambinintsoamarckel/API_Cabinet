<?php

namespace App\Controller\ApiPlatform;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConsultationParMois extends AbstractController
{
    public function __construct(private Security $security)
    {
        
    }
    #[Route(path:'/api/consultation/parmois',methods: ['GET'])]
    public function __invoke( ConsultationRepository $consultationRepository)
    { 

        return($consultationRepository->consultationsParMois());
   

    }

}
?>