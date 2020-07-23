<?php

namespace Sibintek\ConsentPersData\Entity;

use Sibintek\ConsentPersData\Repository\TemplateRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


/**
 * @ORM\Entity(repositoryClass=TemplateRepository::class)
 * @ORM\Table(name="pd_template")
 */
class Template
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $files = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $filesName = [];

    /**
     * Template constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }
    public function getFilesName(): ?array
    {
        return $this->filesName;
    }

    public function setFilesName(?array $filesName): self
    {
        $this->filesName = $filesName;

        return $this;
    }

}
