<?php

namespace App\Entity;

use App\Repository\CardHasTagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardHasTagRepository::class)
 */
class CardHasTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $card_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $tag_id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardId(): ?int
    {
        return $this->card_id;
    }

    public function setCardId(int $card_id): self
    {
        $this->card_id = $card_id;

        return $this;
    }

    public function getTagId(): ?int
    {
        return $this->tag_id;
    }

    public function setTagId(int $tag_id): self
    {
        $this->tag_id = $tag_id;

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
}
