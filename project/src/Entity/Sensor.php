<?php declare(strict_types=1);

namespace Entity;

final class Sensor {

    public const TEMPERATURE_TYPE_CELSIUS = '1';
    public const TEMPERATURE_TYPE_FAHRENHEIT = 2;

    public const TEMPERATURE_TYPES = [
        self::TEMPERATURE_TYPE_CELSIUS,
        self::TEMPERATURE_TYPE_FAHRENHEIT,
    ];

    private string $uuid;
    private float $temperature;
    private int $temperature_type;
    private string $ip_address;
    private int $reading_id;

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }


}