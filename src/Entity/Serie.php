<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\NotBlank(message="You have to fill this input")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="You have to fill this input")
     * @Assert\Positive(message="a year can't be negative dummy")
     * @Assert\NotNull(message="The serie have to start somewhere")
     */
    private $yearOfStart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="a year can't be negative dummy")
     */
    private $yearOfEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="You have to fill this input")
     * @Assert\Positive(message="a number of seasons can't be negative dummy")
     * @Assert\NotNull(message="How a serie can't have at least one season ?")
     */
    private $numberOfSeason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYearOfStart(): ?int
    {
        return $this->yearOfStart;
    }

    public function setYearOfStart(int $yearOfStart): self
    {
        $this->yearOfStart = $yearOfStart;

        return $this;
    }

    public function getYearOfEnd(): ?int
    {
        return $this->yearOfEnd;
    }

    public function setYearOfEnd(?int $yearOfEnd): self
    {
        $this->yearOfEnd = $yearOfEnd;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNumberOfSeason(): ?int
    {
        return $this->numberOfSeason;
    }

    public function setNumberOfSeason(int $numberOfSeason): self
    {
        $this->numberOfSeason = $numberOfSeason;

        return $this;
    }
}
