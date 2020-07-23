<?php

namespace Sibintek\InformerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RnWeather
 *
 * @ORM\Table(name="rn_weather")
 * @ORM\Entity
 */
class Weather
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="Temperature", type="float", precision=10, scale=2, nullable=false, options={"comment"="Значение температуры"})
     */
    private $temperature;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=false, options={"comment"="Название точки"})
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Pressure", type="integer", nullable=true, options={"comment"="Давление"})
     */
    private $pressure;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Humidity", type="integer", nullable=true, options={"comment"="Влажность"})
     */
    private $humidity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type", type="string", length=50, nullable=true, options={"comment"="Тип погоды (солнечно, паспурно и т.д.)"})
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="WindDirection", type="string", length=50, nullable=true, options={"comment"="Направление ветра"})
     */
    private $winddirection;

    /**
     * @var float|null
     *
     * @ORM\Column(name="WindPower", type="float", precision=10, scale=2, nullable=true, options={"comment"="Сила ветра"})
     */
    private $windpower;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Source", type="string", length=50, nullable=true, options={"comment"="Источник данных"})
     */
    private $source;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
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

    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    public function setPressure(?int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function setHumidity(?int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWinddirection(): ?string
    {
        return $this->winddirection;
    }

    public function setWinddirection(?string $winddirection): self
    {
        $this->winddirection = $winddirection;

        return $this;
    }

    public function getWindpower(): ?float
    {
        return $this->windpower;
    }

    public function setWindpower(?float $windpower): self
    {
        $this->windpower = $windpower;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }


}
