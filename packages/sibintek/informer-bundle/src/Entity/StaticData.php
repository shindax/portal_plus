<?php

namespace Sibintek\InformerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RnStaticData
 *
 * @ORM\Table(name="rn_static_data")
 * @ORM\Entity
 */
class StaticData
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false, options={"comment"="Тип записи"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="frequency", type="integer", nullable=false, options={"comment"="Частота обновления"})
     */
    private $frequency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false, options={"comment"="Дата последнего обновления"})
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false, options={"comment"="Значение параметра"})
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="success", type="integer", nullable=false, options={"default"="1"})
     */
    private $success = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_Value", type="string", length=255, nullable=true)
     */
    private $lastValue;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSuccess(): ?int
    {
        return $this->success;
    }

    public function setSuccess(int $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function getLastValue(): ?string
    {
        return $this->lastValue;
    }

    public function setLastValue(?string $lastValue): self
    {
        $this->lastValue = $lastValue;

        return $this;
    }


}
