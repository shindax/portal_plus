<?php

namespace App\Entity;

use App\Repository\OrgStructureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrgStructureRepository::class)
 */
class OrgStructure
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
    private $IdParent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $SAPBE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdParent(): ?int
    {
        return $this->IdParent;
    }

    public function setIdParent(?int $IdParent): self
    {
        $this->IdParent = $IdParent;

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

    public function getSAPBE(): ?string
    {
        return $this->SAPBE;
    }

    public function setSAPBE(?string $SAPBE): self
    {
        $this->SAPBE = $SAPBE;

        return $this;
    }
}
