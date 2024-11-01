<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    /*
     * Retourne les genres
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM genre
            ORDER BY id
        SQL
        );

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);

        return $stmt->fetchAll();
    }
}