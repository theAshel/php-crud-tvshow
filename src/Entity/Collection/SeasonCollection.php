<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;
use PDO;

class SeasonCollection
{
    public static function findByTvShowId(int $tvShowId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM season
            WHERE tvShowId = ?
            ORDER BY seasonNumber;
            SQL
        );
        $stmt->execute([$tvShowId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Season::class);

        return $stmt->fetchAll();
    }
}