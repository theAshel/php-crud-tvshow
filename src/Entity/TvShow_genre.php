<?php

declare(strict_types=1);

namespace Entity;

/**
 * Class Genre TV Show
 */
class TvShow_genre
{
    private int $id;
    private int $genreId;
    private int $tvShowId;

    /** Guetter Id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Setter id
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** Guetter getGenreId
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /** Setter genreId
     * @param int $genreId
     * @return void
     */
    public function setGenreId(int $genreId): void
    {
        $this->genreId = $genreId;
    }

    /** Guetter tvShowId
     * @return int
     */
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    /** Setter tvShowId
     * @param int $tvShowId
     * @return void
     */
    public function setTvShowId(int $tvShowId): void
    {
        $this->tvShowId = $tvShowId;
    }
}
