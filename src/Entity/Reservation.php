<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
#[ApiResource(
    
    normalizationContext: ['groups' => ['read:Reservations']],
    denormalizationContext: ['groups' => ['write:Reservation']],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_LOC')",
                   "security_message" => "Desoler, vous ne  pouvez pas effectuer une reservation avant que vous connecter.",
                  ],
    ],
    itemOperations: [
        'put' =>  [
            'denormalization_context' => ['groups' => ['put:Reservation']],
            "security" => "is_granted('ROLE_ADMIN') or object.getHabitat().getUser() == user",
            
        ],
        'get' => [
            'normalization_context' => ['groups' => ['read:Reservations','read:Reservation']],
        ],
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN') "
        ]
    ]
)]
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User','read:Reservations'])]
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:Reservation', 'write:Reservation'])]
    private $DateArrivee;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:Reservation', 'write:Reservation'])]
    private $DateDepart;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Reservation', 'write:Reservation'])]
    private $NombrePersonnes;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(['read:Reservation', 'write:Reservation'])]
    private $MontantTotal;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:Reservations', 'write:Reservation'])]
    private $DateReservation;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(['read:Reservations', 'put:Reservation', 'write:Reservation'])]
    private $Annulee;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Reservations', 'write:Reservation'])]
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Habitat::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Reservations', 'write:Reservation'])]
    private $habitat;
     
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="reservation", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->DateReservation = new DateTime();
        $this->Annulee = false; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->DateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $DateArrivee): self
    {
        $this->DateArrivee = $DateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->DateDepart;
    }

    public function setDateDepart(\DateTimeInterface $DateDepart): self
    {
        $this->DateDepart = $DateDepart;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->NombrePersonnes;
    }

    public function setNombrePersonnes(int $NombrePersonnes): self
    {
        $this->NombrePersonnes = $NombrePersonnes;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->MontantTotal;
    }

    public function setMontantTotal(float $MontantTotal): self
    {
        $this->MontantTotal = $MontantTotal;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDateReservation(\DateTimeInterface $DateReservation): self
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getAnnulee(): ?bool
    {
        return $this->Annulee;
    }

    public function setAnnulee(bool $Annulee): self
    {
        $this->Annulee = $Annulee;

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

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): self
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setReservation($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getReservation() === $this) {
                $commentaire->setReservation(null);
            }
        }

        return $this;
    }
}
