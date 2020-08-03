<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RnPhotos
 *
 * @ORM\Table(name="rn_photos")
 * @ORM\Entity
 */
class RnPhotos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rn_photos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="main", type="smallint", nullable=false)
     */
    private $main;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="employee_id", type="integer", nullable=true)
     */
    private $employeeId = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="checked", type="smallint", nullable=true)
     */
    private $checked = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer", nullable=false)
     */
    private $typeId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMain(): ?int
    {
        return $this->main;
    }

    public function setMain(int $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
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

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employeeId;
    }

    public function setEmployeeId(?int $employeeId): self
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    public function getChecked(): ?int
    {
        return $this->checked;
    }

    public function setChecked(?int $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getTypeId(): ?RNContent
    {
        return $this->typeId;
    }

    public function setTypeId(?RNContent $type_id): self
    {
        $this->typeId = $type_id;

        return $this;
    }
}
