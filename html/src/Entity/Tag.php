<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Conference", inversedBy="tags")
     */
    private $Conference;

    public function __construct()
    {
        $this->Conference = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection|Conference[]
     */
    public function getConference(): Collection
    {
        return $this->Conference;
    }

    public function addConference(Conference $conference): self
    {
        if (!$this->Conference->contains($conference)) {
            $this->Conference[] = $conference;
        }

        return $this;
    }

    public function removeConference(Conference $conference): self
    {
        if ($this->Conference->contains($conference)) {
            $this->Conference->removeElement($conference);
        }

        return $this;
    }
}
