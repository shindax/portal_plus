<?php

namespace App\Entity;

use App\Repository\OrgNewsRepository;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\SecurityController;

/**
 * @ORM\Entity(repositoryClass=OrgNewsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class OrgNews
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ShortText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $FullText;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsShownOnMain;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $IsPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $PublishDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */


    /**
     * @Vich\UploadableField(mapping="news_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=OrgUser::class)
     */
    private $AuthorID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getShortText(): ?string
    {
        return $this->ShortText;
    }

    public function setShortText(?string $ShortText): self
    {
        $this->ShortText = $ShortText;

        return $this;
    }

    public function getFullText(): ?string
    {
        return $this->FullText;
    }

    public function setFullText(?string $FullText): self
    {
        $this->FullText = $FullText;

        return $this;
    }

    public function getIsShownOnMain(): ?bool
    {
        return $this->IsShownOnMain;
    }

    public function setIsShownOnMain(?bool $IsShownOnMain): self
    {
        $this->IsShownOnMain = $IsShownOnMain;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->IsPublished;
    }

    public function setIsPublished( ?bool $IsPublished): self
    {
        $this->IsPublished = $IsPublished;

        if( $IsPublished )
            $this->PublishDate = new \DateTime;
            else
                $this->PublishDate = null;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->PublishDate;
    }

    public function setPublishDate(?\DateTimeInterface $PublishDate): self
    {
        $this->PublishDate = $PublishDate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getAuthorID(): ?OrgUser
    {
        return $this->AuthorID;
    }

    public function setAuthorID(?OrgUser $AuthorID): self
    {
        $this->AuthorID = $AuthorID;
        return $this;
    }

     /**
     * @ORM\PrePersist
     */
     public function setValuesAfterCreate()
     {
        $this->updatedAt = new \DateTime('now');
     }
}
