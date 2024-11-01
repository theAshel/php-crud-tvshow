<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;
use Entity\Collection\SeasonCollection;

class TVShow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private ?int $posterId;

    private function __construct()
    {

    }
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return TVShow
     */
    private function setId(?int $id): TVShow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TVShow
     */
    public function setName(string $name): TVShow
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return TVShow
     */
    public function setOriginalName(string $originalName): TVShow
    {
        $this->originalName = $originalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage
     * @return TVShow
     */
    public function setHomepage(string $homepage): TVShow
    {
        $this->homepage = $homepage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     * @return TVShow
     */
    public function setOverview(string $overview): TVShow
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int $posterId
     * @return TVShow
     */
    public function setPosterId(?int $posterId): TVShow
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * Recherche un show via son identifiant et le retourne.
     *
     * @param int $id identifiant du show
     * @return TVShow
     *
     * @throws EntityNotFoundException si un show n'a pas été trouvé
     */
    public static function findById(int $id): TVShow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE id = ?;
            SQL
        );

        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, TVShow::class);

        if (($tvShow = $stmt->fetch()) === false) {
            throw new EntityNotFoundException("Show non trouvé.");
        }

        return $tvShow;
    }

    /**
     * Retourne toutes les saisons de la série sous la forme d'un tableau de saisons.
     *
     * @return Season[]
     */
    public function getSeasons(): array
    {
        return SeasonCollection::findByTvShowId($this->getId());
    }

    /**
     * Crée une nouvelle instance de TVShow en utilisant le constructeur privé
     *
     * @param int|null $id
     * @param string $name
     * @param string $originalName
     * @param string $homepage
     * @param string $overview
     * @param int|null $posterId
     * @return TVShow
     */
    public static function create(
        string $name,
        string $originalName,
        string $homepage,
        string $overview,
        ?int $id = null,
        ?int $posterId = null
    ): TVShow {
        $tvShow = new TVShow();
        $tvShow->setId($id)->setName($name)->setOriginalName($originalName)->setHomepage($homepage)->setOverview($overview)->setPosterId($posterId);

        return $tvShow;
    }

    /**
     * Supprime la ligne correspondante à l'id dans la BDD et met à null l'id de l'instance.
     *
     * @return TVShow
     */
    public function delete(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                DELETE FROM tvshow
                WHERE id = ?;
            SQL
        );

        $stmt->execute([$this->getId()]);

        $this->setId(null);

        return $this;
    }

    /**
     * En fonction de la valeur de l'id, s'il est null ou non, insère ou met à jour le show dans la base de données.
     *
     * @return TVShow
     */
    public function save(): TVShow
    {
        if ($this->getId() !== null) {
            $this->update();
        } else {
            $this->insert();
        }

        return $this;
    }

    /**
     * Met à jour les attributs de la table tvshow pour la ligne dont l'id est celui
     * de l'instance courante.
     *
     * @return TVShow
     */
    protected function update(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                UPDATE tvshow SET name = ?, originalName = ?, homepage = ?, overview = ?
                WHERE id = ?;
            SQL
        );

        $stmt->execute([
            $this->getName(),
            $this->getOriginalName(),
            $this->getHomepage(),
            $this->getOverview(),
            $this->getId()
        ]);

        return $this;
    }

    /**
     * Insère un nouveau TVShow dans la base de données.
     *
     * @return TVShow
     */
    protected function insert(): TVShow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                INSERT INTO tvshow (name, originalName, homepage, overview, posterId)
                VALUES (?, ?, ?, ?, null)
            SQL
        );

        $stmt->execute([
            $this->getName(),
            $this->getOriginalName(),
            $this->getHomepage(),
            $this->getOverview()
        ]);

        $this->setId((int) MyPdo::getInstance()->lastInsertId());

        return $this;
    }
}
