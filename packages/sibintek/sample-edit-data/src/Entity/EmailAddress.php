<?php

namespace Sibintek\ConsentPersData\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Sibintek\ConsentPersData\Repository\EmailAddressRepository")
 * @ORM\Table(name="pd_email_address")
 */
class EmailAddress
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Sibintek\ConsentPersData\Entity\MessageEmail", mappedBy="sender")
     */
    private $messageEmails;

    /**
     * @ORM\ManyToOne(targetEntity="Sibintek\ConsentPersData\Entity\Candidate", inversedBy="emailAddresses")
     */
    private $candidate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isspam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isnoreply;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datesent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateregistration;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->messageEmails = new ArrayCollection();
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

    /**
     * @return Collection|MessageEmail[]
     */
    public function getMessageEmails(): Collection
    {
        return $this->messageEmails;
    }

    public function addMessageEmail(MessageEmail $messageEmail): self
    {
        if (!$this->messageEmails->contains($messageEmail)) {
            $this->messageEmails[] = $messageEmail;
            $messageEmail->setSender($this);
        }

        return $this;
    }

    public function removeMessageEmail(MessageEmail $messageEmail): self
    {
        if ($this->messageEmails->contains($messageEmail)) {
            $this->messageEmails->removeElement($messageEmail);
            // set the owning side to null (unless already changed)
            if ($messageEmail->getSender() === $this) {
                $messageEmail->setSender(null);
            }
        }

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getIsspam(): ?bool
    {
        return $this->isspam;
    }

    public function setIsspam(bool $isspam): self
    {
        $this->isspam = $isspam;

        return $this;
    }

    public function getIsnoreply(): ?bool
    {
        return $this->isnoreply;
    }

    public function setIsnoreply(bool $isnoreply): self
    {
        $this->isnoreply = $isnoreply;

        return $this;
    }

    public function getDatesent(): ?\DateTimeInterface
    {
        return $this->datesent;
    }

    public function setDatesent(?\DateTimeInterface $datesent): self
    {
        $this->datesent = $datesent;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getDateregistration(): ?\DateTimeInterface
    {
        return $this->dateregistration;
    }

    public function setDateregistration(?\DateTimeInterface $dateregistration): self
    {
        $this->dateregistration = $dateregistration;

        return $this;
    }

}
