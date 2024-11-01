<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Season;
use Entity\TVShow;
use Html\AppWebPage;

// on vérifie qu'un id de season au format valide a été fourni via une méthode GET
if (!isset($_GET["seasonId"]) || !ctype_digit($_GET["seasonId"])) {
    header("Location: index.php");
    exit();
}

$seasonId = (int) $_GET["seasonId"];

$webPage = new AppWebPage();
$webPage->appendCssUrl("css/season.css");

// on cherche un season avec l'identifiant fourni précédemment
try {
    $season = Season::findById($seasonId);
} catch (EntityNotFoundException $e) { // le season n'existe pas : erreur 404
    http_response_code(404);
    $webPage->appendContent("            <h1>{$e->getMessage()}</h1>\n");
    echo $webPage->toHTML();
    exit();
}
// On récupère la série
$tvShow = TVShow::findById($season->getTvShowId());

$webPage->setTitle("Séries TV : {$tvShow->getName()} - {$season->getName()}");

// on récupère et affiche les épisodes d'une saison
$episodesList = $season->getEpisodes();

$webPage->appendContentToMenu(<<<HTML
        <a id="show-redirection-button" href="show.php?tvShowId={$tvShow->getId()}">&#x2190 Liste des saisons</a>
HTML);

$webPage->appendContent(<<<HTML
<div class="season__recap">
    <img class="season__poster" src="poster.php?posterId={$season->getPosterId()}" alt="Poster de la saison"/>
    <div class="season__info">
        <a href="{$tvShow->getHomepage()}">{$tvShow->getName()}</a>
        <p id="season__name">{$season->getname()}</p>
    </div>
</div>
HTML);

foreach ($episodesList as $episode) {
    $webPage->appendContent(<<<HTML
                    <div class="season__episode">
                        <span class="episode__num">{$episode->getEpisodeNumber()} - {$webPage->escapeString($episode->getName())}</span>
                        <span class="episode__text">{$webPage->escapeString($episode->getOverview())}</span>
                    </div>

HTML);
}

echo $webPage->toHTML();
