<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_PROP')"],
                ],
    itemOperations: [
        'get',
        'put' =>  [
            "security" => "is_granted('ROLE_ADMIN') ",
            "security_message" => "Service peut modifier seulement par l'Administration."
        ],
        
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN') ",
            "security_message" => "Service peut supprimer seulement par l'Administration."
        ]
    ],
)]
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['write:Habitat','read:Habitat','put:Habitat'])]
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['write:Habitat','read:Habitat','put:Habitat','write:Habitat'])]
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
