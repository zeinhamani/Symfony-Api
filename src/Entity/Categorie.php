<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:cat']],
    denormalizationContext: ['groups' => ['write:cat']],
    collectionOperations: [
        
        "get",
        "post" => ["security" => "is_granted('ROLE_ADMIN')",
        ],
                ],
    itemOperations: [
        'get',
        'put' =>  [
            "security" => "is_granted('ROLE_ADMIN') ",
            
        ],
        
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN') ",
            
        ]
    ],
)]
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Habitats','read:Habitat','read:cat'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['write:cat','read:Habitats','read:Habitat','read:cat',])]
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Habitat::class, mappedBy="categorie", cascade={"persist", "remove"})
     */
    #[Groups(['read:habitat','read:cat'])]
    private $habitats;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, mappedBy="categorie", cascade={"persist", "remove"})
     */
    #[Groups(['read:cat'])]
    private $media;

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Habitat[]
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(Habitat $habitat): self
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats[] = $habitat;
            $habitat->setCategorie($this);
        }

        return $this;
    }

    public function removeHabitat(Habitat $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getCategorie() === $this) {
                $habitat->setCategorie(null);
            }
        }

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        // unset the owning side of the relation if necessary
        if ($media === null && $this->media !== null) {
            $this->media->setCategorie(null);
        }

        // set the owning side of the relation if necessary
        if ($media !== null && $media->getCategorie() !== $this) {
            $media->setCategorie($this);
        }

        $this->media = $media;

        return $this;
    }
}
