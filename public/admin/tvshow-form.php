<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Entity\TVShow;
use Html\AppWebPage;
use Html\Form\TVShowForm;
use Html\WebPage;

try {
    $tvShow = null;

    $webPage = new appWebPage("Ajouter une série");
    $webPage->appendCssUrl("../css/form.css");

    if (isset($_GET["tvShowId"])) {
        if (!ctype_digit($_GET["tvShowId"])) {
            throw new ParameterException("Non conformité de l'identifiant du show.");
        } else {
            $tvShow = TVShow::findById((int) $_GET["tvShowId"]);
            $webPage->appendContentToMenu(<<<HTML
                <a id="redirection-button" href="/show.php?tvShowId={$tvShow->getId()}">&#x2190 Retourner à la liste des saisons</a>
            HTML);
        }
    } else {
        $webPage->appendContentToMenu(<<<HTML
            <a id="redirection-button" href="/">&#x2190 Retourner à l'accueil</a>
        HTML);
    }

    $tvShowForm = new TVShowForm($tvShow);
    $webPage->appendContent($tvShowForm->getHtmlForm("./tvshow-save.php"));
    echo $webPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
