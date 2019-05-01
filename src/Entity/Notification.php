<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(type="string", length=255)
     */
    private $Message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Begin_hour;

    /**
     * @ORM\Column(type="integer")
     */
    private $Week;

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

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

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

    public function getWeek(): ?int
    {
        return $this->Week;
    }

    public function setWeek(int $Week): self
    {
        $this->Week = $Week;

        return $this;
    }
}
