<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DestinationRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Destinations', 'read:Habitats']],
    denormalizationContext: ['groups' => ['write:Destination']],
    collectionOperations: [
        
        "get",
        "post" => ["security" => "is_granted('ROLE_PROP')",
        ],
                ],
    itemOperations: [
         
        'get' => [
            'normalization_context' => ['groups' => ['read:Destinations']],
        ],
        'put'=>  [
            'denormalization_context' => ['groups' => ['put:Destination']],
            "security" => "is_granted('ROLE_PROP') ",
            
        ],
        
        'delete' => [
            "security" => "is_granted('ROLE_PROP') ",
            
        ]
    ]
)]
class Destination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Destinations'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Habitats','read:Habitat','put:Habitat', 'write:Habitat','read:Destinations', 'put:Destination', 'write:Destination'])]
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Habitats','read:Habitat', 'write:Habitat','put:Habitat','read:Destinations', 'put:Destination', 'write:Destination'])]
    private $departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Habitats','read:Habitat', 'write:Habitat','put:Habitat','read:Destinations', 'put:Destination', 'write:Destination'])]
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=Habitat::class, mappedBy="destination")
     */
    private $habitats;

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDepartement(): ?int
    {
        return $this->departement;
    }

    public function setDepartement(int $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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
            $habitat->setDestination($this);
        }

        return $this;
    }

    public function removeHabitat(Habitat $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getDestination() === $this) {
                $habitat->setDestination(null);
            }
        }

        return $this;
    }
}
