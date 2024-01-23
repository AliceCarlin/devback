<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\Security;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;


/**
 * @ApiResource(
 *     itemOperations={
 *         "get",
 *         "post"={
 *             "security"="is_granted('ROLE_ADMIN')"
 *         },
  *         "put"={
 *             "security"="is_granted('ROLE_ADMIN')"
 *         },
 *         "patch"={
 *             "security"="is_granted('ROLE_ADMIN')"
 *         },
 *         "delete"={
 *             "security"="is_granted('ROLE_ADMIN')"
 *         }
 *     }
 * )
 * @ORM\Entity
 * @Security("is_granted('ROLE_USER')")
*/

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(types: ['https://schema.org/Category'])]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id'])]

class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, inversedBy: 'categories')]
    private Collection $films;

    #[ORM\OneToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[ApiProperty(types: ['https://schema.org/image'])]
    public ?MediaObject $image = null;

    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Movie $film): static
    {
        if (!$this->films->contains($film)) {
            $this->films->add($film);
        }

        return $this;
    }

    public function removeFilm(Movie $film): static
    {
        $this->films->removeElement($film);

        return $this;
    }
}
