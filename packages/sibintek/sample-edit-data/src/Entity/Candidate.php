<?php

namespace Sibintek\ConsentPersData\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="Sibintek\ConsentPersData\Repository\CandidateRepository")
 * @ORM\Table(name="pd_candidate")
 *
 * Defines the properties of the Candidate entity.
 *
 * @author Alexander Nikitin <NikitinAY@sibintek.ru>
 */
class Candidate
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;


    /**
     * @ORM\OneToMany(targetEntity="Sibintek\ConsentPersData\Entity\EmailAddress", mappedBy="candidate")
     */
    private $emailAddresses;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isconsent;

    /**
     * Candidate constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->answers = new ArrayCollection();
        $this->emailAddresses = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|EmailAddress[]
     */
    public function getEmailAddress(): Collection
    {
        return $this->emailAddresses;
    }

    /**
     * @return Collection|EmailAddress[]
     */
    public function getEmailAddresses(): Collection
    {
        return $this->emailAddresses;
    }

    public function addEmailAddress(EmailAddress $emailAddress): self
    {
        if (!$this->emailAddresses->contains($emailAddress)) {
            $this->emailAddresses[] = $emailAddress;
            $emailAddress->setCandidate($this);
        }

        return $this;
    }

    public function removeEmailAddress(EmailAddress $emailAddress): self
    {
        if ($this->emailAddresses->contains($emailAddress)) {
            $this->emailAddresses->removeElement($emailAddress);
            // set the owning side to null (unless already changed)
            if ($emailAddress->getCandidate() === $this) {
                $emailAddress->setCandidate(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    public function  getFullName() {
        return $this->getLastName() . ' ' . $this->getFirstName() . ' ' . $this->getPatronymic();
    }

    public function getIsconsent(): ?bool
    {
        return $this->isconsent;
    }

    public function setIsconsent(bool $isconsent): self
    {
        $this->isconsent = $isconsent;

        return $this;
    }
}
