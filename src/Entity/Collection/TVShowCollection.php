<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\TVShow;
use PDO;

/**
 * Classe permettant de retourner une collection de toutes les entités TVShow sous la forme d'un
 * tableau d'objets.
 */
class TVShowCollection
{
    /**
     * @return TVShow[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM tvshow
            ORDER BY name
        SQL
        );

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, TVShow::class);

        return $stmt->fetchAll();
    }

    /** Retourne les séries par genres
     * @return TVShow[]
     */
    public static function findByGenre(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT tvshow.id, tvshow.name, tvshow.originalName, tvshow.homepage, tvshow.overview, tvshow.posterId
        FROM tvshow
        INNER JOIN tvshow_genre ON (tvshow.id = tvshow_genre.tvShowId) 
        INNER JOIN genre ON (tvshow_genre.genreId = genre.id)
        WHERE genre.id = ?
        ORDER BY tvshow.name
    SQL
        );

        $stmt->execute([$genreId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, TVShow::class);

        return $stmt->fetchAll();
    }
}
