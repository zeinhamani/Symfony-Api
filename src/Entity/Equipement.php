<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
/**
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Equipement']],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_PROP')"],
                ],
    itemOperations: [
        'get',
        'put' =>  [
            "security" => "is_granted('ROLE_ADMIN') ",
            "security_message" => "Equipement peut modifier seulement par l'Administration."
        ],
        
        'delete' => [
            
            "security_message" => "Equipement peut supprimer seulement par l'Administration."
        ]
    ],
)]
class Equipement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Equipement','read:Habitat'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Equipement','read:Habitat'])]
    private $nom;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, inversedBy="equipement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Equipement','read:Habitat'])]
    private $media;

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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(Media $media): self
    {
        $this->media = $media;

        return $this;
    }
}
