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
            "security" => "is_granted('ROLE_ADMIN') ",
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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Habitat'])]
    private $nom;

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
}
