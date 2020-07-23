<?php

namespace Sibintek\ConsentPersData\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Sibintek\ConsentPersData\Repository\MessageEmailRepository")
 * @ORM\Table(name="pd_message_email")
 */
class MessageEmail
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Sibintek\ConsentPersData\Entity\EmailAddress", inversedBy="messageEmails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTimeReceived;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTimeSent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAttachment;

    /**
     * MessageEmail constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public function getSender(): ?EmailAddress
    {
        return $this->sender;
    }

    public function setSender(?EmailAddress $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getDateTimeReceived(): ?\DateTimeInterface
    {
        return $this->dateTimeReceived;
    }

    public function setDateTimeReceived(\DateTimeInterface $dateTimeReceived): self
    {
        $this->dateTimeReceived = $dateTimeReceived;

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

    public function getIsAttachment(): ?bool
    {
        return $this->isAttachment;
    }

    public function setIsAttachment(bool $isAttachment): self
    {
        $this->isAttachment = $isAttachment;

        return $this;
    }
}
