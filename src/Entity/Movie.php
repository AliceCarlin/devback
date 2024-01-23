<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\Security;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiProperty;
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


#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(types: ['https://schema.org/Movie'])]
#[ApiFilter(SearchFilter::class, properties: ['Titre' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
     /**
     * @Assert\NotBlank(message="Le titre ne doit pas être vide.")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le titre doit avoir au moins {{ limit }} caractères.",
     *      maxMessage = "Le titre doit avoir moins de {{ limit }} caractères."
     * )
     */
    private ?string $Titre = null;


    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    
    private Collection $Acteurs;

    #[ORM\Column(nullable: true)]
    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "La valeur doit être au moins {{ limit }}.",
     *      maxMessage = "La valeur ne peut pas dépasser {{ limit }}."
     * )
     */
    private ?int $Note = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'films')]
    private Collection $categories;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sortie = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    private ?int $entries = null;

    #[ORM\Column(nullable: true)]
    private ?int $budget = null;

    #[ORM\Column(length: 255)]
    private ?string $director = null;

    #[ORM\Column(length: 255, nullable: true)]
    /**
     * @Assert\Url(
     *      message = "L'URL '{{ value }}' n'est pas valide."
     * )
     */
    private ?string $site = null;

    #[ORM\ManyToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[ApiProperty(types: ['https://schema.org/image'])]
    public ?MediaObject $image = null;

    public function __construct()
    {
        $this->Acteurs = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActeurs(): Collection
    {
        return $this->Acteurs;
    }

    public function addActeur(Actor $acteur): static
    {
        if (!$this->Acteurs->contains($acteur)) {
            $this->Acteurs->add($acteur);
        }

        return $this;
    }

    public function removeActeur(Actor $acteur): static
    {
        $this->Acteurs->removeElement($acteur);

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(?int $Note): static
    {
        $this->Note = $Note;

        return $this;
    }


    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addFilm($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeFilm($this);
        }

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(?\DateTimeInterface $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(?int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): static
    {
        $this->site = $site;

        return $this;
    }

}
