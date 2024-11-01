<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\TVShowCollection;
use Entity\Genre;
use Html\AppWebPage;

// Creation d'une page web
$webPage = new AppWebPage("Séries TV");

// AJout d'un fichier style
$webPage->appendCssUrl("css/index.css");

// Button pour ajouter une série
$webPage->appendContentToMenu(<<<HTML
<a id="add-button" href="admin/tvshow-form.php">Ajouter une série</a>
HTML);

// On récupère les genres
$tabGenre = GenreCollection::findAll();

// formulaire de genre
$webPage->appendContentToMenu(
    <<<HTML

            <form id="genre-filter" method="GET" action="index.php" >
            <label for="genre">Filtrer par genre :</label>
            <select name="genre" id="genre" onchange="this.form.submit()">
                <option value="">Choisissez un genre</option>
HTML
);

// On ajoute tous les genres dans les options du formulaire
foreach($tabGenre as $genre) {
    $selected = "";

    // on regarde si un id de genre est transmis et est valide
    if (isset($_GET['genre']) && ctype_digit($_GET['genre'])) {
        if ($genre->getId() === (int) $_GET['genre']) {
            $selected = "selected";
        }
    }

    $webPage->appendContentToMenu(<<<HTML
    <option value="{$genre->getId()}" $selected>{$genre->getName()}</option>
HTML);
}

$webPage->appendContentToMenu(<<<HTML
           <option value="0">Tous</option>
                </select>
            </form>
HTML);

// Si le genre est sélectionné, alors on affiche que les séries de ce genre
if (isset($_GET['genre']) && ctype_digit($_GET['genre'])) {
    $tabShow = TVShowCollection::findByGenre((int) $_GET['genre']);

    if (count($tabShow) == 0) {
        $tabShow = TVShowCollection::findAll();
    }
    // Sinon on affiche tous
} else {
    $tabShow = TVShowCollection::findAll();
}

// affichage des séries
foreach ($tabShow as $show) {
    $webPage->appendContent("\n" . <<<HTML
                 <a href ="./show.php?tvShowId={$show->getId()}">
                    <div class ="show">
                        <img class="show__poster" src="./poster.php?posterId={$show->getPosterId()}" alt="Poster">
                        <div class="text">
                            <h4 class="show__title">{$show->getName()}</h4>
                            <p class="show__overview">{$show->getOverview()}</p>
                        </div>
                    </div>
                  </a>
    HTML);
}
echo $webPage->toHTML();
