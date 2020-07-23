<?php

namespace App\Entity;

use App\Repository\UnionOrgUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnionOrgUserRepository::class)
 */
class UnionOrgUser
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
    private $IdOrgUserSlave;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdOrgUserMaster;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrgUserSlave(): ?int
    {
        return $this->IdOrgUserSlave;
    }

    public function setIdOrgUserSlave(?int $IdOrgUserSlave): self
    {
        $this->IdOrgUserSlave = $IdOrgUserSlave;

        return $this;
    }

    public function getIdOrgUserMaster(): ?int
    {
        return $this->IdOrgUserMaster;
    }

    public function setIdOrgUserMaster(?int $IdOrgUserMaster): self
    {
        $this->IdOrgUserMaster = $IdOrgUserMaster;

        return $this;
    }
}
