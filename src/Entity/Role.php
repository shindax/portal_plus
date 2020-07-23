<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 * @ORM\Table(name="`role`")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;


    /**
     * Many Roles have Many Users.
     *
     * @var ArrayCollection
     *     
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(){
        return $this -> description; // $this -> name." : ".$this -> description;
    }

}
