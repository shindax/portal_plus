<?php

namespace Sibintek\ConsentPersData\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Sibintek\ConsentPersData\Repository\AttachmentRepository")
 * @ORM\Table(name="pd_attachment")
 */
class Attachment
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $drive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Sibintek\ConsentPersData\Entity\MessageEmail")
     * @ORM\JoinColumn(nullable=false)
     */
    private $messageEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originName;

    /**
     * Attachment constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getDrive(): ?string
    {
        return $this->drive;
    }

    public function setDrive(?string $drive): self
    {
        $this->drive = $drive;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getMessageEmail(): ?MessageEmail
    {
        return $this->messageEmail;
    }

    public function setMessageEmail(?MessageEmail $messageEmail): self
    {
        $this->messageEmail = $messageEmail;

        return $this;
    }

    public function getOriginName(): ?string
    {
        return $this->originName;
    }

    public function setOriginName(string $originName): self
    {
        $this->originName = $originName;

        return $this;
    }
}
