<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\EpisodeCollection;
use Entity\Exception\EntityNotFoundException;
use PDO;

/**
 * Class season
 */
class Season
{
    private int $id;

    private int $tvShowId;

    private string $name;

    private int $seasonNumber;

    private ?int $posterId;

    /** Guetter de Id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Setter de Id
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** Guetter de tvShowId
     * @return int
     */
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    /** Setter de tvShowId
     * @param int $tvShowId
     * @return void
     */
    public function setTvShowId(int $tvShowId): void
    {
        $this->tvShowId = $tvShowId;
    }

    /** Guetter de name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Setter de name
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** Guetter de seasonNumber
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    /** Setter de seasonNumber
     * @param int $seasonNumber
     * @return void
     */
    public function setSeasonNumber(int $seasonNumber): void
    {
        $this->seasonNumber = $seasonNumber;
    }

    /** Guetter de posterId
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /** Setter de posterId
     * @param int $posterId
     * @return void
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * Recherche un season via son identifiant et le retourne.
     *
     * @param int $id identifiant du season
     * @return Season
     *
     * @throws EntityNotFoundException si un season n'a pas été trouvé
     */
    public static function findById(int $id): Season
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM season
                WHERE id = ?;
            SQL
        );

        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Season::class);

        if (($season = $stmt->fetch()) === false) {
            throw new EntityNotFoundException("Season non trouvé.");
        }

        return $season;
    }

    /**
     * Retourne tous les épisodes de la saison sous la forme d'un tableau d'épisodes.
     *
     * @return Episode[]
     */
    public function getEpisodes(): array
    {
        return EpisodeCollection::findBySeasonId($this->getId());
    }




}
