<?php
declare(strict_types=1);

namespace Entity;

/**
 * Class episode
 */
class Episode
{
    private int $id;
    private int $seasonId;
    private string $name;
    private string $overview;
    private int $episodeNumber;

    /** Guetter de id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Setter de id
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /** Guetter de seasonId
     * @return int
     */
    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    /** Setter de seasonId
     * @param int $seasonId
     * @return void
     */
    public function setSeasonId(int $seasonId): void
    {
        $this->seasonId = $seasonId;
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

    /** Guetter de overview
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Setter de overview
     * @param string $overview
     * @return void
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /** Guetter de episodeNumber
     * @return int
     */
    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }

    /** Setter de episodeNumber
     * @param int $episodeNumber
     * @return void
     */
    public function setEpisodeNumber(int $episodeNumber): void
    {
        $this->episodeNumber = $episodeNumber;
    }
}