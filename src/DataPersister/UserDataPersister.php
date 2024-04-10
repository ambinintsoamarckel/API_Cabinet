<?php
namespace App\DataPersister;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// ...

class UserDataPersister implements ProcessorInterface

{

        public function __construct(private UserPasswordHasherInterface $hasher, private ProcessorInterface $persistProcessor, private ProcessorInterface $removeProcessor, private EntityManagerInterface $entityManager,private RequestStack $requestStack)
        {
          
            
        } 
        /**
         * {@inheritDoc}
         */
        public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
        {
 
            $request = $context['request'];
            $requestData = json_decode($request->getContent(), true);

            // call your persistence layer to save $data
            if ($data instanceof User)
            {         
            if (array_key_exists('password', $requestData)) {
           
              
                $password = $data->getPassword();
                $data->setPassword($this->hasher->hashPassword($data, $password));
            }
                $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);  
                return $result;
            }
            
            
           
    
   
  
        }
}

?>