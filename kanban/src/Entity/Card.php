<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     * @Groups("card")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("card")
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @Groups("card")
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @Groups("card")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @Groups("card")
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @Groups("lists_card")
     * @ORM\ManyToOne(targetEntity=ListContainer::class, inversedBy="cards", cascade={"remove"})
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id")
     */
    private $list;

    /**
     * @Groups("cards_tag")
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="cards")
     */
    private $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getList(): ?ListContainer
    {
        return $this->list;
    }

    public function setList(?ListContainer $list): self
    {
        $this->list = $list;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
