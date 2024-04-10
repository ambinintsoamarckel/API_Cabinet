<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Controller\ApiPlatform\MeController;
use App\DataPersister\UserDataPersister;
use Doctrine\ORM\Mapping\Id;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ApiResource(normalizationContext: ['groups'=>['getcollection:user']],denormalizationContext:['groups'=>['getcollection:user']])]
#[Get(openapiContext:['security' => [['JWT'=> []]]])]
#[Get( name: 'me', uriTemplate:'/me',read: false,controller:MeController::class,
openapiContext:['security' => [['JWT'=> []]]])]
#[Post(openapiContext:['security' => [['JWT'=> []]]], uriTemplate:'/user',processor: UserDataPersister::class)]

#[GetCollection(
    openapiContext:['security' => [['JWT'=> []]]],
paginationItemsPerPage: 10)]
#[Patch(openapiContext:['security' => [['JWT'=> []]]],processor: UserDataPersister::class)]
#[Delete()]

/*#[Patch(denormalizationContext: ['groups'=>['password']],processor: UserDataPersister::class,uriTemplate:"/reset/{id}")]
#[ApiFilter(SearchFilter::class, properties: ['uuid'=>'partial','telephone'=>'partial','email'=>'partial','adresse'=>'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['createdat' => 'DESC'])] */

#[ApiFilter(OrderFilter::class, properties: ['id' => 'DESC'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:user'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['getcollection:user'])]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['getcollection:user'])]
    private ?string $password = null;

    #[ORM\Column(length: 10, unique: true)]
    #[Groups(['getcollection:user'])]
    private ?string $telephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function SetId(int $id): void
    {
        $this->id=$id;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }
    public static function createFromPayload( $id, array $payload)
    {
        $user=new User();
        $user->setId($id);
        $user->setUsername($payload['username']);
        $user->setRoles($payload['roles']);
         
        return $user;
    }

}
