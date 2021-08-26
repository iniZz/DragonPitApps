<?php

namespace App\Entity;

use App\Repository\ApplicationsRejectedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationsRejectedRepository::class)
 */
class ApplicationsRejected
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
     * @ORM\Column(type="date")
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que1;

    /**
     * @ORM\Column(type="text")
     */
    private $answ1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que2;

    /**
     * @ORM\Column(type="text")
     */
    private $answ2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que3;

    /**
     * @ORM\Column(type="text")
     */
    private $answ3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que4;

    /**
     * @ORM\Column(type="text")
     */
    private $answ4;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que5;

    /**
     * @ORM\Column(type="text")
     */
    private $answ5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $que6;

    /**
     * @ORM\Column(type="text")
     */
    private $answ6;

    /**
     * @ORM\Column(type="text")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $faster;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reason;

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

    public function getbirth_date(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
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

    public function getAnsw1(): ?string
    {
        return $this->answ1;
    }

    public function setAnsw1(string $answ1): self
    {
        $this->answ1 = $answ1;

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

    public function getAnsw2(): ?string
    {
        return $this->answ2;
    }

    public function setAnsw2(string $answ2): self
    {
        $this->answ2 = $answ2;

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

    public function getAnsw3(): ?string
    {
        return $this->answ3;
    }

    public function setAnsw3(string $answ3): self
    {
        $this->answ3 = $answ3;

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

    public function getAnsw4(): ?string
    {
        return $this->answ4;
    }

    public function setAnsw4(string $answ4): self
    {
        $this->answ4 = $answ4;

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

    public function getAnsw5(): ?string
    {
        return $this->answ5;
    }

    public function setAnsw5(string $answ5): self
    {
        $this->answ5 = $answ5;

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

    public function getAnsw6(): ?string
    {
        return $this->answ6;
    }

    public function setAnsw6(string $answ6): self
    {
        $this->answ6 = $answ6;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFaster(): ?bool
    {
        return $this->faster;
    }

    public function setFaster(bool $faster): self
    {
        $this->faster = $faster;

        return $this;
    }
    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }
}
