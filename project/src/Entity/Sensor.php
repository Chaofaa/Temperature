<?php declare(strict_types=1);

namespace Entity;

final class Sensor extends Entity {

    public const TEMPERATURE_TYPE_CELSIUS = '1';
    public const TEMPERATURE_TYPE_FAHRENHEIT = 2;

    public const TEMPERATURE_TYPE_TITLES = [
        self::TEMPERATURE_TYPE_CELSIUS => '°C',
        self::TEMPERATURE_TYPE_FAHRENHEIT => '°F',
    ];

    private int $id;
    private string $uuid;
    private float $temperature;
    private int $temperature_type;
    private string $ip_address;
    private int $reading_id = 0;

    public function getTemperatureTypeTitle($type): ?string
    {
        return self::TEMPERATURE_TYPE_TITLES[$type] ?? '';
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperatureType(int $temperatureType): self
    {
        $this->temperature_type = $temperatureType;
        return $this;
    }

    public function getTemperatureType(): int
    {
        return $this->temperature_type;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ip_address = $ipAddress;
        return $this;
    }

    public function getIpAddress(): string
    {
        return $this->ip_address;
    }

    public function increaseReadingId(): self
    {
        $this->reading_id++;
        return $this;
    }

    public function setReadingId($readingId): self
    {
        $this->reading_id = $readingId;
        return $this;
    }

    public function getReadingId(): int
    {
        return $this->reading_id;
    }

    public function getOutputTemperature(): string
    {
        return number_format($this->getTemperature(), 2) . $this->getTemperatureTypeTitle($this->getTemperatureType());
    }
}