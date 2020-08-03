<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RnComments
 *
 * @ORM\Table(name="rn_comments")
 * @ORM\Entity
 */
class RnComments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rn_comments_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="target_id", type="integer", nullable=true)
     */
    private $targetId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="target_type", type="string", length=255, nullable=true)
     */
    private $targetType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=false)
     */
    private $dateCreate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="employee_name", type="string", length=128, nullable=true)
     */
    private $employeeName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="employee_id", type="integer", nullable=true)
     */
    private $employeeId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_modered", type="smallint", nullable=true)
     */
    private $isModered = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_anonim", type="smallint", nullable=true)
     */
    private $isAnonim;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetId(): ?int
    {
        return $this->targetId;
    }

    public function setTargetId(?int $targetId): self
    {
        $this->targetId = $targetId;

        return $this;
    }

    public function gettarget_id(): ?int
    {
        return $this->targetId;
    }

    public function settarget_id(?int $targetId): self
    {
        $this->targetId = $targetId;

        return $this;
    }


    public function getTargetType(): ?string
    {
        return $this->targetType;
    }

    public function setTargetType(?string $targetType): self
    {
        $this->targetType = $targetType;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function gettitle(): ?string
    {
        return $this->text;
    }


    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getEmployeeName(): ?string
    {
        return $this->employeeName;
    }

    public function setEmployeeName(?string $employeeName): self
    {
        $this->employeeName = $employeeName;

        return $this;
    }

    public function getemployeeId(): ?int
    {
        return $this->employeeId;
    }

    public function setemployeeId(?int $employeeId): self
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    public function getIsModered(): ?int
    {
        return $this->isModered;
    }

    public function setIsModered(?int $isModered): self
    {
        $this->isModered = $isModered;

        return $this;
    }

    public function getis_anonim(): ?int
    {
        return $this->isAnonim;
    }

    public function setis_anonim(?int $isAnonim): self
    {
        $this->isAnonim = $isAnonim;
        return $this;
    }

    public function getemployee(): ?string
    {
        return $this->employeeName;
    }

    public function setemployee(?string $employeeName): self
    {
        $this->employeeName = $employeeName;

        return $this;
    }

    public function getUser(): ?string
    {
        $arr = explode("\\", $this->employeeName);
        return $arr[2];
    }

    // public function getDate(): ?String
    // {
    //     return $this->dateCreate -> format('Y-m-d H:i');
    // }
}
