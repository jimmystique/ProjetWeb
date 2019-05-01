<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RDVRepository")
 */
class RDV
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
    private $Student;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Teacher;

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

    public function getStudent(): ?string
    {
        return $this->Student;
    }

    public function setStudent(string $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getTeacher(): ?string
    {
        return $this->Teacher;
    }

    public function setTeacher(string $Teacher): self
    {
        $this->Teacher = $Teacher;

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
