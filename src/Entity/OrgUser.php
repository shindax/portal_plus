<?php

namespace App\Entity;

use App\Repository\OrgUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrgUserRepository::class)
 */
class OrgUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdOrgStructure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdOrgStructurePosition;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Surname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $MiddleName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsActive;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $TN;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $PKZI;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdPortal;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $PhotoUrl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsLoad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrgStructure(): ?int
    {
        return $this->IdOrgStructure;
    }

    public function setIdOrgStructure(?int $IdOrgStructure): self
    {
        $this->IdOrgStructure = $IdOrgStructure;

        return $this;
    }

    public function getIdOrgStructurePosition(): ?int
    {
        return $this->IdOrgStructurePosition;
    }

    public function setIdOrgStructurePosition(?int $IdOrgStructurePosition): self
    {
        $this->IdOrgStructurePosition = $IdOrgStructurePosition;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(?string $Surname): self
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->MiddleName;
    }

    public function setMiddleName(?string $MiddleName): self
    {
        $this->MiddleName = $MiddleName;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->IsActive;
    }

    public function setIsActive(?bool $IsActive): self
    {
        $this->IsActive = $IsActive;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): self
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getTN(): ?string
    {
        return $this->TN;
    }

    public function setTN(?string $TN): self
    {
        $this->TN = $TN;

        return $this;
    }

    public function getPKZI(): ?string
    {
        return $this->PKZI;
    }

    public function setPKZI(?string $PKZI): self
    {
        $this->PKZI = $PKZI;

        return $this;
    }

    public function getIdPortal(): ?int
    {
        return $this->IdPortal;
    }

    public function setIdPortal(?int $IdPortal): self
    {
        $this->IdPortal = $IdPortal;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->PhotoUrl;
    }

    public function setPhotoUrl(?string $PhotoUrl): self
    {
        $this->PhotoUrl = $PhotoUrl;

        return $this;
    }

    public function getIsLoad(): ?bool
    {
        return $this->IsLoad;
    }

    public function setIsLoad(?bool $IsLoad): self
    {
        $this->IsLoad = $IsLoad;

        return $this;
    }

    public function __toString()
    {
        return $this -> Name ." ". $this -> MiddleName ." ". $this -> Surname;
    }

}
