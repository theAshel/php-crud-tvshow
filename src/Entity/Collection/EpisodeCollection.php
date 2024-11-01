<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    /** Permet de trouver les épisodes par rapport à l'id de season
     * @param int $seasonId
     * @return array
     */
    public static function findBySeasonId(int $seasonId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM episode
            WHERE seasonId = ?
            ORDER BY episodeNumber;
            SQL
        );
        $stmt->execute([$seasonId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Episode::class);

        return $stmt->fetchAll();
    }
}