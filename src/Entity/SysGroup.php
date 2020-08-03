<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\SysRole;
use App\Entity\SysUser;
use App\Repository\SysGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SysGroupRepository::class)
 */
class SysGroup
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
     * @ORM\ManyToMany(targetEntity="App\Entity\SysRole", inversedBy="groups")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|SysRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRoles(SysRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function removeRoles(SysRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SysUser", mappedBy="groups")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @return Collection|SysUser[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(SysUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroups($this);
        }
        return $this;
    }

    public function removeUsers(SysUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $users->removeGroups($this);
        }
        return $this;
    }

    public function __toString()
    {
        return $this -> Name;
    }

    public function getRoleNames()
    {
        $arr = [];

        foreach ( $this -> roles AS $value )
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

    public function addRole(SysRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(SysRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function addUser(SysUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroup($this);
        }

        return $this;
    }

    public function removeUser(SysUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGroup($this);
        }

        return $this;
    }

}
