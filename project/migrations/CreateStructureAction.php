<?php

final class CreateStructureAction {

    public function __construct(
        private PDO $connection
    ) {}

    public function execute(): void
    {
        $query = 'create table sensors
        (
            id serial
                constraint sensors_pk
                    primary key,
            uuid uuid not null,
            temperature numeric(15,2) not null,
            temperature_type int not null,
            ip_address varchar not null,
            reading_id int default 0 not null
        );';

        $this->connection->exec($query);
    }

}