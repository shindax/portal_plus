<?php

namespace Sibintek\ConsentPersData\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Sibintek\ConsentPersData\Repository\FeedbackRepository")
 * @ORM\Table(name="pd_feedback")*
 */
class Feedback
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $emailAddresses = [];

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
     * @ORM\Column(type="datetime")
     */
    private $dateTimeSent;

    /**
     * Feedback constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmailAddresses(): ?array
    {
        return $this->emailAddresses;
    }

//    public function getEmailAddress(): ?array
//    {
//        return $this->emailAddresses;
//    }

    public function setEmailAddresses(array $emailAddresses): self
    {
        $this->emailAddresses = $emailAddresses;

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

    public function getDateTimeSent(): ?\DateTimeInterface
    {
        return $this->dateTimeSent;
    }

    public function setDateTimeSent(\DateTimeInterface $dateTimeSent): self
    {
        $this->dateTimeSent = $dateTimeSent;

        return $this;
    }
}
