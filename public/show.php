<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use Html\AppWebPage;

// on vérifie qu'un id de TVShow au format valide a été fourni via une méthode GET
if (!isset($_GET["tvShowId"]) || !ctype_digit($_GET["tvShowId"])) {
    header("Location: index.php");
    exit();
}

$tvShowId = (int) $_GET["tvShowId"];

$webPage = new AppWebPage();
$webPage->appendCssUrl("css/show.css");
// on cherche un show avec l'identifiant fourni précédemment
try {
    $tvShow = TVShow::findById($tvShowId);
} catch (EntityNotFoundException $e) { // le show n'existe pas : erreur 404
    http_response_code(404);
    $webPage->appendContent("            <h1>{$e->getMessage()}</h1>\n");
    echo $webPage->toHTML();
    exit();
}

$webPage->setTitle("Séries TV : {$tvShow->getName()}");

// on récupère et affiche les saisons du show

$seasonsList = $tvShow->getSeasons();

$webPage->appendContentToMenu(<<<HTML
        <a id="index-redirection-button" href="/">&#x2190 Retourner à l'accueil</a>
        <div class="menu__buttons">
            <a id="save-button" href="admin/tvshow-form.php?tvShowId={$tvShowId}">Modifier la série</a>
            <a id="delete-button" href="admin/tvshow-delete.php?tvShowId={$tvShowId}">Supprimer la série</a>
        </div>
HTML);

$webPage->appendContent(<<<HTML
<div class="show__recap">
    <img class="show__poster" src="poster.php?posterId={$tvShow->getPosterId()}" alt="Poster du show"/>
    <div class="show__info">
        <div class="show__titles">
            <span class="show__name">{$tvShow->getName()}</span>
            <span class="show__originalName">{$tvShow->getOriginalName()}</span>
        </div>
        <p id="show__overview">{$tvShow->getOverview()}</p>
    </div>
</div>
HTML);

foreach ($seasonsList as $season) {
    $webPage->appendContent(<<<HTML
                    <a class="season_link" href="season.php?seasonId={$season->getId()}">
                        <div class="season">
                            <img class="season__poster" src="poster.php?posterId={$season->getPosterId()}" alt="Poster de la saison"/>
                            <span class="season__title">{$season->getName()}</span>
                        </div>
                    </a>

HTML);
}

echo $webPage->toHTML();
