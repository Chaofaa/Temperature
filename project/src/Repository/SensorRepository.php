<?php declare(strict_types=1);

namespace Repository;

use Entity\Sensor;
use PDO;

class SensorRepository
{

    public function __construct(
        private PDO $connection
    ) {}

    public function findByIp(string $ipAddress): ?Sensor
    {
        $sql = 'SELECT * FROM sensors as s WHERE s.ip_address = :ip_address';

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':ip_address', $ipAddress);
        $statement->execute();

        $entry = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($entry)) {
            return null;
        }

        $sensor = new Sensor();
        $sensor->hydrate($entry);

        return $sensor;
    }

    public function increaseReadingId(Sensor $sensor): Sensor
    {
        $sensor->setReadingId($sensor->getReadingId() + 1);

        $sql = 'UPDATE sensors SET reading_id = :reading_id WHERE id = :id';

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':reading_id', $sensor->getReadingId());
        $statement->bindValue(':id', $sensor->getId());
        $statement->execute();

        return $sensor;
    }

    public function store(Sensor $sensor): Sensor
    {
        $sql = 'INSERT INTO sensors (uuid, temperature, temperature_type, ip_address, reading_id)
                VALUES (:uuid, :temperature, :temperature_type, :ip_address, :reading_id) RETURNING id AS id';

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':uuid', $sensor->getUuid());
        $statement->bindValue(':temperature', $sensor->getTemperature());
        $statement->bindValue(':temperature_type', $sensor->getTemperatureType());
        $statement->bindValue(':ip_address', $sensor->getIpAddress());
        $statement->bindValue('reading_id', $sensor->getReadingId());
        $statement->execute();

        $entry = $statement->fetch(PDO::FETCH_ASSOC);

        $sensor->setId((int) $entry['id']);

        return $sensor;
    }

}

