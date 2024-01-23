<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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


#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[ApiResource(paginationType: 'page', types: ['https://schema.org/Category'])]
#[ApiFilter(SearchFilter::class, properties: ['Prenom' => 'partial', 'Nom' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\NotBlank
     */
    private ?string $Nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @Assert\NotBlank
     */
    private ?string $Prenom = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $Date_de_naissance = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'Acteurs')]
    private Collection $movies;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Choice(['Oscar', 'Other'])]
    private ?string $reward = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\OneToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[ApiProperty(types: ['https://schema.org/image'])]
    public ?MediaObject $image = null;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeImmutable
    {
        return $this->Date_de_naissance;
    }

    public function setDateDeNaissance(?\DateTimeImmutable $Date_de_naissance): static
    {
        $this->Date_de_naissance = $Date_de_naissance;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addActeur($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeActeur($this);
        }

        return $this;
    }

    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(?string $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }
}
