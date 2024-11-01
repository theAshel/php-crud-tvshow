<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

/**
 * Class poster
 */
class Poster
{
    private int $id;
    private string $jpeg;

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

    /** Guetter de jpeg
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /** Setter de jpeg
     * @param string $jpeg
     * @return void
     */
    public function setJpeg(string $jpeg): void
    {
        $this->jpeg = $jpeg;
    }
    /**
     * Renvoit le poster dont l'id est égal à l'integer passé en paramètre
     * @param int $id
     * @return Poster
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Poster
    {

        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
             FROM poster
             WHERE id = ?
            SQL
        );
        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Poster::class);

        if (($poster = $stmt->fetch()) === false) {
            throw new EntityNotFoundException('Poster non trouvé');
        }

        return $poster;
    }
}
