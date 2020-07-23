<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\SysGroup;
use App\Repository\SysRoleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SysRoleRepository::class)
 */
class SysRole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $Name;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SysGroup", mappedBy="roles")
     */
    private $groups;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return Collection|SysGroup[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroups(SysGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addRoles($this);
        }
        return $this;
    }

    public function removeGroups(SysGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $groups->removeRoles($this);
        }
        return $this;
    }

    public function __toString()
    {
        return $this -> Name;
    }

    public function getGroupNames()
    {
        $arr = [];

        foreach ( $this -> groups AS $value )
            $arr [] = $value -> getName();

        return join(", ", $arr );
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
