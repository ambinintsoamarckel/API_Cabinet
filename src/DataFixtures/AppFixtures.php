<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Consultation;
use App\Entity\Medicaments;
use App\Entity\Patient;
use App\Entity\Planning;
use App\Entity\Rendezvous;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $secretaire=new User();
        $secretaire->setUsername("Secretaire")
                ->setTelephone($this->generatePhoneNumber())
                ->setPassword($this->hasher->hashPassword($secretaire, 'secretaire'))
                ->setRoles(['ROLE_USER']);
        $manager->persist($secretaire);
        $docteur=new User();
        $docteur->setUsername("docteur")
                ->setTelephone($this->generatePhoneNumber())
                ->setPassword($this->hasher->hashPassword($docteur, 'docteur'))
                ->setRoles(['ROLE_ADMIN']);
        $manager->persist($docteur);



        for ($i = 0; $i < 50; $i++) {
            $patient = new Patient();
            $patient->setNom($this->faker->lastName)
                    ->setPrenom($this->faker->firstName)
                    ->setTelephone($this->generatePhoneNumber())
                    ->setSexe($this->faker->boolean())
                    ->setAge($this->faker->numberBetween(18, 80));

            $manager->persist($patient);

            for ($j = 0; $j < 2; $j++) {
                $planning = new Planning();
                $planning->setDebut($this->faker->dateTimeBetween('-2years'))
                         ->setFin($this->faker->dateTimeBetween('-2years'))
                         ->setLimite($this->faker->numberBetween(10, 20));

                $manager->persist($planning);

                for ($k = 0; $k < 3; $k++) {
                    $rendezvous = new Rendezvous();
                    $rendezvous->setStatut($this->faker->word())
                                ->setPatient($patient)
                                ->setPlanning($planning);

                    $manager->persist($rendezvous);

                    $consultation = new Consultation();
                    $consultation->setDate($this->faker->dateTimeBetween('-2years'))
                                 ->setPatient($patient)
                                 ->setMotif($this->faker->sentence())
                                 ->setDiagnostic($this->faker->text());
    


                    for ($l = 0; $l < 2; $l++) {
                        $medicaments = new Medicaments();
                        $medicaments->setNom($this->faker->word())
                                     ->setPosologie($this->generatePosologie())
                                     ->setDuree($this->faker->numberBetween(1, 30))
                                     ->setNote($this->faker->text())
                                     ->setConsultation($consultation);

                        $manager->persist($medicaments);
                    }

                    $manager->persist($consultation);
                }
            }
        }

        $manager->flush();
    }
function generatePhoneNumber(): string
{
    $prefixes = ['032', '033', '034', '037', '038'];
    $prefix = $prefixes[random_int(0, count($prefixes) - 1)];
    $subscriberNumber = '';

    for ($i = 0; $i < 7; $i++) {
        $subscriberNumber .= random_int(0, 9);
    }



    return $prefix . $subscriberNumber ;
}
function generatePosologie(): string
{
    $posologieParts = [];

    for ($i = 0; $i < 3; $i++) {
        $posologieParts[] = random_int(0, 3);
    }

    return implode('-', $posologieParts);
}


}
