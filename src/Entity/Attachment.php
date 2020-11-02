<?php

namespace App\Entity;

use App\Repository\AttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 * @Vich\Uploadable()
 */
class Attachment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public.attachment_id_seq", allocationSize=1, initialValue=1)
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="org_news_attachments", fileNameProperty="image")
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="OrgNews", inversedBy="attachments")
     */
    private $orgNews;

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }


    /**
     * @param mixed $imageFile
     */
    public function setImageFile(?File $imageFile): void
    {
        // dd( $this->orgNews->getId() );
        $this->imageFile = $imageFile;
    }

    public function getOrgNews()
    {
        return $this->orgNews;
    }

    public function setOrgNews( $orgNews ): self
    {
        $this->orgNews = $orgNews;
        return $this;
    }


}
