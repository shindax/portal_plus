<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $pid;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $controller;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $action;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $ord;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(?int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPid(): ?int
    {
        return $this->pid;
    }

    public function setPid(?int $pid): self
    {
        $this->pid = $pid;

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

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getController(): ?string
    {
        return $this->controller;
    }

    public function setController(?string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getOrd(): ?int
    {
        return $this->ord;
    }

    public function setOrd(?int $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
