<?php

namespace App\Entity;

use App\Entity\Users;
use App\Repository\ArticlesRepository;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    // security: "is_granted('ROLE_BROWSE')",
    // operations: [
    //     new GetCollection(
    //         security: "is_granted('ROLE_Browse')", 
    //         securityMessage: 'Vous devez etre connecté pour voir les articles.'
    //     ),
    //     new Get(
    //         security: "is_granted('ROLE_USER') and object.user == user", 
    //         securityMessage: 'Vous devez etre l\'auteur de l\'article pour le voir.'
    //     ),
    //     new Put(
    //         securityPostDenormalize: "is_granted('ROLE_ADMIN') or (object.user == user and previous_object.user == user)", 
    //         securityPostDenormalizeMessage: 'Vous ne pouvez pas modifier l\'article si vous n\'etes pas administrateur et l\'auteur.'
    //     ),
    //     new Post(
    //         security: "is_granted('ROLE_ADMIN')", 
    //         securityMessage: 'Seul les administrateurs peuvent créer de nouveaux articles.'
    //     ),
    //     new Delete(
    //         security: "is_granted('ROLE_ADMIN')", 
    //         securityMessage: 'Seul les administrateurs peuvent supprimer article.'
    //     )
    // ]
)]


#[ORM\Entity(repositoryClass: ArticlesRepository::class)]

class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categories $category = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

}
