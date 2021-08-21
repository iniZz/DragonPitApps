<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionsRepository::class)
 */
class Questions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $discordId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $steamHex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que4;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que6;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(string $discordId): self
    {
        $this->discordId = $discordId;

        return $this;
    }

    public function getSteamHex(): ?string
    {
        return $this->steamHex;
    }

    public function setSteamHex(string $steamHex): self
    {
        $this->steamHex = $steamHex;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birth_date;
    }

    public function setBirthDate(string $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getQue1(): ?string
    {
        return $this->que1;
    }

    public function setQue1(string $que1): self
    {
        $this->que1 = $que1;

        return $this;
    }

    public function getQue2(): ?string
    {
        return $this->que2;
    }

    public function setQue2(string $que2): self
    {
        $this->que2 = $que2;

        return $this;
    }

    public function getQue3(): ?string
    {
        return $this->que3;
    }

    public function setQue3(string $que3): self
    {
        $this->que3 = $que3;

        return $this;
    }

    public function getQue4(): ?string
    {
        return $this->que4;
    }

    public function setQue4(string $que4): self
    {
        $this->que4 = $que4;

        return $this;
    }

    public function getQue5(): ?string
    {
        return $this->que5;
    }

    public function setQue5(string $que5): self
    {
        $this->que5 = $que5;

        return $this;
    }

    public function getQue6(): ?string
    {
        return $this->que6;
    }

    public function setQue6(string $que6): self
    {
        $this->que6 = $que6;

        return $this;
    }
}
