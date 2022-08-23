<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:commentaires']],
    attributes: ["security" => "is_granted('ROLE_USER')"],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_LOC')",
                   
                  ],
                ],
    itemOperations: [
        'get',
        'put' =>  [
                        "security" => "is_granted('ROLE_ADMIN') or object.getReservation().getUser() == user",
                        
            ],

        'delete' => [
                        "security" => "is_granted('ROLE_ADMIN') or object.getReservation().getUser() == user",
                        
            ]
    ]

)]
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['read:commentaires'])]
    private $Contenu;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    #[Groups(['read:commentaires'])]
    private $Evaluation;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['read:commentaires'])]
    private $DateCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:commentaires'])]
    private $reservation;

    public function __construct()
    {
        $this->DateCommentaire = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getEvaluation(): ?float
    {
        return $this->Evaluation;
    }

    public function setEvaluation(?float $Evaluation): self
    {
        $this->Evaluation = $Evaluation;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->DateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $DateCommentaire): self
    {
        $this->DateCommentaire = $DateCommentaire;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
