<?php

namespace App\Entity;

use App\Entity\Users;
use App\Repository\TokensRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: TokensRepository::class)]
#[ApiResource]
class Tokens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 35)]
    private ?string $token = null;

    #[ORM\ManyToOne(inversedBy: 'tokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(length: 100)]
    private ?string $keyName = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $ArticlePermission = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $categoryPermission = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $permission = null;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->token;
    }

    public function setKey(string $token): self
    {
        $this->token = $token;

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

    public function getKeyName(): ?string
    {
        return $this->keyName;
    }

    public function setKeyName(string $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    public function getArticlePermission(): ?string
    {
        return $this->ArticlePermission;
    }

    public function setArticlePermission(string $ArticlePermission): self
    {
        $this->ArticlePermission = $ArticlePermission;

        return $this;
    }

    public function getCategoryPermission(): ?string
    {
        return $this->categoryPermission;
    }

    public function setCategoryPermission(?string $categoryPermission): self
    {
        $this->categoryPermission = $categoryPermission;

        return $this;
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }

    public function setPermission(?string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

}
