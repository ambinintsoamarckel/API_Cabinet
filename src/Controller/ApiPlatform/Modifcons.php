<?php

namespace App\Controller\ApiPlatform;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Entity\Consultation;
use App\Entity\Medicaments;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Modifcons extends AbstractController
{
    private $manager;

    public function __construct(private Security $security, private RequestStack $requestStack, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    #[Route(path:'/api/consultation/{id}',methods: ['PUT'])]
    public function __invoke(ConsultationRepository $consultationRepository,$id)
    { 
        try {
            $requestData=json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
            $cons= new Consultation();
            $cons=$consultationRepository->findOneById($id);
            if ($cons) {
               // Suppression des anciens médicaments using orphanRemoval
           
               
            $cons->removeAllMedicaments();// Vide la collection de médicaments
    
            

            $medicaments = $requestData['medicaments'];
            foreach ($medicaments as $data) {
                $medicament = new Medicaments();
                $medicament->setNom($data['nom']);
                $medicament->setPosologie($data['posologie']);
                $medicament->setDuree($data['duree']);
                $medicament->setNote($data['note']);
                // ... set other properties
                
                // Association du médicament à la consultation
                $this->manager->persist($medicament);
                $cons->addMedicament($medicament);
            }

            $cons->setMotif($requestData['motif']);
            $cons->setDiagnostic($requestData['diagnostic']);
            // ... update other properties

            $this->manager->flush();
         
            
            return $this->json($cons, JsonResponse::HTTP_OK, [], ['groups' => ['get:cst']]);
   
            }
            $responseData = [
                'message' => 'Ressource Not Found.',
            ];
            
            $response = new JsonResponse($responseData, 404);
            return $response;

            
           
        } catch (\Throwable $th) {
            $responseData = [
                'message' => $th->getMessage(),
            ];
       
            
            $response = new JsonResponse($responseData, 500);
            return $response;

            
            
        }

    }

}
