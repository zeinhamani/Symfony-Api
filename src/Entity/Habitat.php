<?php

namespace App\Entity;


use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=HabitatRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Habitats']],
    denormalizationContext: ['groups' => ['write:Habitat']],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_PROP')",
                   "security_message" => "Desoler, vous ne  pouvez pas changer l'habitat.",
                  ]
                ],
    itemOperations: [
        'put' =>  [
            'denormalization_context' => ['groups' => ['put:Habitat']],
            "security" => "is_granted('ROLE_ADMIN') or object.getUser() == user",
        ],
        'get' => [
            'normalization_context' => ['groups' => ['read:Habitats','read:Habitat']],
        ],
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN') or object.getUser() == user",
            "security_message" => "Vous n'étes pas le propriétaire vous pouvez pas supprimer."
        ]
    ],
),
ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'titre' => 'partial' ])]
class Habitat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:cat','read:Habitats','read:User','read:Reservations'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Habitats', 'put:Habitat', 'write:Habitat','read:Reservations'])]
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['read:Habitat','put:Habitat', 'write:Habitat'])]
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $adresse;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(['read:Habitats', 'put:Habitat', 'write:Habitat'])]
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $superficie;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $capaciteAccueil;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $dateOuvertureDu;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $dateOuvertureAu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $fermetureExp;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $heureArriveeDu;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $heureArriveeAu;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $heureDepartDu;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $heureDepartAu;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="habitats", cascade={"persist"})
     */
    #[Groups(['read:Habitats','read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="habitats")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Habitat','write:Habitat', 'put:Habitat'])]
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class, inversedBy="habitats", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Habitats','read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $destination;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, cascade={"persist"})
     */
    #[Groups(['read:Habitat', 'put:Habitat','write:Habitat'])]
    private $services;

    /**
     * @ORM\ManyToMany(targetEntity=Equipement::class)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat'])]
    private $equipements;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="habitat", cascade={"persist"}, orphanRemoval=true)
     */
    #[Groups(['read:Habitat', 'put:Habitat', 'write:Habitat','read:Reservations'])]
    private $medias;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="habitat", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getCapaciteAccueil(): ?int
    {
        return $this->capaciteAccueil;
    }

    public function setCapaciteAccueil(int $capaciteAccueil): self
    {
        $this->capaciteAccueil = $capaciteAccueil;

        return $this;
    }

    public function getDateOuvertureDu(): ?\DateTimeInterface
    {
        return $this->dateOuvertureDu;
    }

    public function setDateOuvertureDu(\DateTimeInterface $dateOuvertureDu): self
    {
        $this->dateOuvertureDu = $dateOuvertureDu;

        return $this;
    }

    public function getDateOuvertureAu(): ?\DateTimeInterface
    {
        return $this->dateOuvertureAu;
    }

    public function setDateOuvertureAu(\DateTimeInterface $dateOuvertureAu): self
    {
        $this->dateOuvertureAu = $dateOuvertureAu;

        return $this;
    }

    public function getFermetureExp(): ?string
    {
        return $this->fermetureExp;
    }

    public function setFermetureExp(string $fermetureExp): self
    {
        $this->fermetureExp = $fermetureExp;

        return $this;
    }

    public function getHeureArriveeDu(): ?\DateTimeInterface
    {
        return $this->heureArriveeDu;
    }

    public function setHeureArriveeDu(?\DateTimeInterface $heureArriveeDu): self
    {
        $this->heureArriveeDu = $heureArriveeDu;

        return $this;
    }

    public function getHeureArriveeAu(): ?\DateTimeInterface
    {
        return $this->heureArriveeAu;
    }

    public function setHeureArriveeAu(?\DateTimeInterface $heureArriveeAu): self
    {
        $this->heureArriveeAu = $heureArriveeAu;

        return $this;
    }

    public function getHeureDepartDu(): ?\DateTimeInterface
    {
        return $this->heureDepartDu;
    }

    public function setHeureDepartDu(?\DateTimeInterface $heureDepartDu): self
    {
        $this->heureDepartDu = $heureDepartDu;

        return $this;
    }

    public function getHeureDepartAu(): ?\DateTimeInterface
    {
        return $this->heureDepartAu;
    }

    public function setHeureDepartAu(?\DateTimeInterface $heureDepartAu): self
    {
        $this->heureDepartAu = $heureDepartAu;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->services->removeElement($service);

        return $this;
    }

    /**
     * @return Collection|Equipement[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setHabitat($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getHabitat() === $this) {
                $media->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHabitat($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHabitat() === $this) {
                $reservation->setHabitat(null);
            }
        }

        return $this;
    }
}
