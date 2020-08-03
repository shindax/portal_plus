<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\SysUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=SysUserRepository::class)
 */
class SysUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $UserLogin;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLogin(): ?string
    {
        return $this->UserLogin;
    }

    public function setUserLogin(string $UserLogin): self
    {
        $this->UserLogin = $UserLogin;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->UserLogin;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // $roles = $this->roles;
        $roles = [];
        foreach ( $this -> groups AS $values );
        {
            $subroles = $values -> getRoles();
                foreach ( $subroles as $svalue )
                    $roles[] = $svalue -> getName();
        }

        // dump( $roles );

        return array_unique( $roles );
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdAD;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $UserDomain;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsActive;

    public function getIdAD(): ?int
    {
        return $this->IdAD;
    }

    public function setIdAD(?int $IdAD): self
    {
        $this->IdAD = $IdAD;

        return $this;
    }

    public function getUserDomain(): ?string
    {
        return $this->UserDomain;
    }

    public function setUserDomain(string $UserDomain): self
    {
        $this->UserDomain = $UserDomain;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SysGroup", inversedBy="users")
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity=OrgUser::class, cascade={"persist", "remove"})
     */
    private $OrgUserID;

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
        }
        return $this;
    }

    public function removeGroups(SysGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

    public function __toString()
    {
        return $this -> UserLogin;
    }

    public function getOrgUserID(): ?OrgUser
    {
        return $this->OrgUserID;
    }

    public function setOrgUserID(?OrgUser $OrgUserID): self
    {
        $this->OrgUserID = $OrgUserID;

        return $this;
    }

    public function groupList()
    {
        $arr = [];
        foreach ( $this -> groups AS $value )
            $arr [] = $value -> getName();

        return join(", ", $arr );
    }

    public function addGroup(SysGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(SysGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

}
