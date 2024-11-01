<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Entity\TVShow;

try {
    if (!isset($_GET["tvShowId"]) || !ctype_digit($_GET["tvShowId"])) {
        throw new ParameterException(("Identifiant de show non valide."));
    }

    $artist = TVShow::findById((int) $_GET["tvShowId"]);
    $artist->delete();

    header("Location: /index.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}