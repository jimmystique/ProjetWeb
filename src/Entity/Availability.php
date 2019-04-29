<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvailabilityRepository")
 */
class Availability
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
    private $Username;

    /**
     * @ORM\Column(type="integer")
     */
    private $Week;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Begin_hour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->Week;
    }

    public function setWeek(int $Week): self
    {
        $this->Week = $Week;

        return $this;
    }

    public function getBeginHour(): ?string
    {
        return $this->Begin_hour;
    }

    public function setBeginHour(string $Begin_hour): self
    {
        $this->Begin_hour = $Begin_hour;

        return $this;
    }
}
