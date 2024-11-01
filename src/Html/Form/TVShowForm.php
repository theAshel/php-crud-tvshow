<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\TVShow;
use Exception\ParameterException;
use Html\StringEscaper;

class TVShowForm
{
    use StringEscaper;

    private ?TVShow $tvShow;

    /**
     * @param TVShow|null $tvShow
     */
    public function __construct(?TVShow $tvShow = null)
    {
        $this->tvShow = $tvShow;
    }
    public function getTvShow(): ?TVShow
    {
        return $this->tvShow;
    }

    public function getHtmlForm(string $action): string
    {
        $nameValue = $this->tvShow?->getName();
        $originalNameValue = $this->tvShow?->getOriginalName();
        $homepageValue = $this->tvShow?->getHomepage();
        $overviewValue = $this->tvShow?->getOverview();

        return <<<HTML
            <form method="post" action="{$action}">
                <input name="id" type="hidden" id="tvShowId" value="{$this->tvShow?->getId()}"/>
                <label for="tvShowName">Nom</label>
                <input name="name" type="text" id="tvShowName" value="{$nameValue}" required>
                <label for="tvShowOriginalName">Nom original</label>
                <input name="originalName" type="text" id="tvShowOriginalName" value="{$originalNameValue}" required>
                <label for="tvShowHomepage">Homepage</label>
                <input name="homepage" type="text" id="tvShowHomepage" value="{$homepageValue}" required>
                <label for="tvShowOverview">Description</label>
                <textarea name="overview" id="tvShowOverview" rows="10" required>{$overviewValue}</textarea>
                <input name="posterId" type="hidden" id="tvShowId" value="{$this->tvShow?->getPosterId()}"/>
                <button type="submit">Enregistrer</button>
            </form>

        HTML;
    }

    /**
     * @throws ParameterException Si le nom du TVShow n'est pas entré.
     * @throws ParameterException Si le nom original du TVShow n'est pas entré.
     * @throws ParameterException Si le homepage du TVShow n'est pas entré.
     * @throws ParameterException Si la description du TVShow n'est pas entré.
     */
    public function setEntityFromQueryString(): void
    {
        if (!isset($_POST["name"]) || $_POST["name"] === "") {
            throw new ParameterException("Nom du TVShow non présent.");
        }
        if (!isset($_POST["originalName"]) || $_POST["originalName"] === "") {
            throw new ParameterException("Nom original du TVShow non présent.");
        }
        if (!isset($_POST["homepage"]) || $_POST["homepage"] === "") {
            throw new ParameterException("Homepage du TVShow non présent.");
        }
        if (!isset($_POST["overview"]) || $_POST["overview"] === "") {
            throw new ParameterException("Description du TVShow non présent.");
        }
        $id = (isset($_POST["id"]) && ctype_digit($_POST["id"])) ? (int) $_POST["id"] : null;
        $posterId = (isset($_POST["posterId"]) && ctype_digit($_POST["posterId"])) ? (int) $_POST["posterId"] : null;

        $name = $this->stripTagsAndTrim($this->escapeString($_POST["name"]));
        $originalName = $this->stripTagsAndTrim($this->escapeString($_POST["originalName"]));
        $homepage = $this->stripTagsAndTrim($this->escapeString($_POST["homepage"]));
        $overview = $this->stripTagsAndTrim($this->escapeString($_POST["overview"]));

        $this->tvShow = TVShow::create($name, $originalName, $homepage, $overview, $id, $posterId);
    }
}
