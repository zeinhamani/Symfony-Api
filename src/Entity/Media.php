<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use App\Controller\UploadMediaAction;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 * @Vich\Uploadable()
 */
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => [
                   "path" => "/media",
                   "controller" => UploadMediaAction::class,
                   "defaults" => ["_api_receive" => false]
        ],
                ],
    itemOperations: [
        'get',
        'put', 
        'delete'
    ],
)]
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:cat'])]
    private $id;

    /**
     * @Vich\UploadableField(mapping="medias", fileNameProperty="url")
     */
    #[Assert\NotNull]
    private $file;

    /**
     * @ORM\Column(nullable=true)
     */
    #[Groups(['read:cat','read:Habitat','read:Equipement','read:Habitats','read:Users', 'write:User','read:Reservations','read:commentaires'])]
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Habitat::class, inversedBy="medias")
     */
    private $habitat;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="media", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Categorie::class, inversedBy="media", cascade={"persist", "remove"})
     */
    private $categorie;

    /**
     * @ORM\OneToOne(targetEntity=Equipement::class, mappedBy="media", cascade={"persist", "remove"})
     */
    private $equipement;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
    public function getUrl()
    {
        return '/medias/'. $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(Equipement $equipement): self
    {
        // set the owning side of the relation if necessary
        if ($equipement->getMedia() !== $this) {
            $equipement->setMedia($this);
        }

        $this->equipement = $equipement;

        return $this;
    }

}
