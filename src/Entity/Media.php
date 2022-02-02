<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: 'Le nom doit avoir au moins {{ limit }} caractères',
        maxMessage: 'Le nom doit avoir au plus {{ limit }} caractères',
        )]
    #[Assert\NotBlank(message:"Vous devez indiquer un titre")]
    #[Assert\Regex(pattern:"/^[a-zA-Z0-9 ]+$/", match:true, message:"Les caractères spéciaux sont interdits dans le titre")]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\File(
             maxSize : "5M",
             mimeTypes : ["image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf", "video/x-msvideo", "video/webm", "video/mpeg"],
             maxSizeMessage : "Le maximum autorisé est de 5MB.",
             mimeTypesMessage : "Seuls les fichiers de type image, application ou vidéo sont autorisés."
         )]
    private $link;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private $userAuthor;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'media')]
    private $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserAuthor(): ?User
    {
        return $this->userAuthor;
    }

    public function setUserAuthor(?User $userAuthor): self
    {
        $this->userAuthor = $userAuthor;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}
