<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[Groups("Category")]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: 'Le nom doit avoir au moins {{ limit }} caractères',
        maxMessage: 'Le nom doit avoir au plus {{ limit }} caractères',
        )]
        
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Vous devez indiquer un titre")]
    #[Assert\Regex(pattern:"/^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]{5,60}$/", match:true, message:"Les caractères spéciaux sont interdits dans le titre")]
    private $name;

    #[ORM\OneToMany(targetEntity:'Category', mappedBy:'parent')]
    private $children;

    #[ORM\ManyToOne(targetEntity:'Category', inversedBy:'children')]
    #[ORM\JoinColumn(name:"parent_id", referencedColumnName:"id")]
    private $parent;


    #[Groups("Category")]
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Media::class,  orphanRemoval: true)]
    private $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->children = new ArrayCollection();
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


    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setCategory($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getCategory() === $this) {
                $medium->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }
    

    public function addChildren(Category $childrens): self
    {
        if (!$this->children->contains($childrens)) {
          //  $this->children[] = $childrens;
            $this->children->add($this);
        }

        return $this;
    }

    public function removeChildren(Category $category): self
    {
        if ($this->children->contains($category)) {
          $this->children->removeElement($category);
        }

        return $this;
    }


    /**
     * Get the value of parent
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @return  self
     */ 
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
