<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity( fields={"email"},message="L'email a déjà été attribué !")
 * @UniqueEntity( fields={"username"},message="L'username a déjà été attribué !")
 */
class User implements UserInterface
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.",checkMX = true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="1", minMessage="Mot de passe trop court")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profile_pic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quality1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quality2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quality3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quality4;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PhoneNumber;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }

    public function getSalt(){}

    public function eraseCredentials(){}

    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    public function setProfilePic(?string $profile_pic): self
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    public function getQuality1(): ?string
    {
        return $this->quality1;
    }

    public function setQuality1(?string $quality1): self
    {
        $this->quality1 = $quality1;

        return $this;
    }

    public function getQuality2(): ?string
    {
        return $this->quality2;
    }

    public function setQuality2(?string $quality2): self
    {
        $this->quality2 = $quality2;

        return $this;
    }

    public function getQuality3(): ?string
    {
        return $this->quality3;
    }

    public function setQuality3(?string $quality3): self
    {
        $this->quality3 = $quality3;

        return $this;
    }

    public function getQuality4(): ?string
    {
        return $this->quality4;
    }

    public function setQuality4(?string $quality4): self
    {
        $this->quality4 = $quality4;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }



}
