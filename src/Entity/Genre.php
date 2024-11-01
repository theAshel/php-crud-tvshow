<?php
declare(strict_types=1);

namespace Entity;

/**
 * Class genre
 */
class Genre
{
    private int $id;
    private string $name;

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
}