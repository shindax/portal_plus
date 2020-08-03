<?php

namespace App\Entity;

use App\Entity\RnPhotos;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RnContent
 *
 * @ORM\Table(name="rn_content")
 * @ORM\Entity
 */
class RnContent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rn_content_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="catalog_section", type="integer", nullable=false)
     */
    private $catalogSection;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="text", nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="short_text", type="text", nullable=true)
     */
    private $shortText;

    /**
     * @var string|null
     *
     * @ORM\Column(name="full_text", type="text", nullable=true)
     */
    private $fullText;

    /**
     * @var int|null
     *
     * @ORM\Column(name="external_id", type="integer", nullable=true)
     */
    private $externalId;

    /**
     * @var int
     *
     * @ORM\Column(name="show_on_main", type="smallint", nullable=false)
     */
    private $showOnMain = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="publish", type="smallint", nullable=false)
     */
    private $publish = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="no_comments", type="smallint", nullable=true)
     */
    private $noComments;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="publish_date", type="datetime", nullable=true)
     */
    private $publishDate;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=false)
     */
    private $author = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatalogSection(): ?int
    {
        return $this->catalogSection;
    }

    public function setCatalogSection(int $catalogSection): self
    {
        $this->catalogSection = $catalogSection;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortText(): ?string
    {
        return $this->shortText;
    }

    public function setShortText(?string $shortText): self
    {
        $this->shortText = $shortText;

        return $this;
    }

    public function getFullText(): ?string
    {
        return $this->fullText;
    }

    public function setFullText(?string $fullText): self
    {
        $this->fullText = $fullText;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(?int $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getShowOnMain(): ?int
    {
        return $this->showOnMain;
    }

    public function setShowOnMain(int $showOnMain): self
    {
        $this->showOnMain = $showOnMain;

        return $this;
    }

    public function getPublish(): ?int
    {
        return $this->publish;
    }

    public function setPublish(int $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getNoComments(): ?int
    {
        return $this->noComments;
    }

    public function setNoComments(?int $noComments): self
    {
        $this->noComments = $noComments;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(?\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
