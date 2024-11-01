<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (!isset($_GET["posterId"]) || !ctype_digit($_GET["posterId"])) {
        throw new ParameterException("Paramètre non conforme");
    } else {
        $poster = Poster::findById((int)($_GET['posterId']));
        header('Content-Type : image/jpeg');
        echo($poster->getjpeg());
    }
} catch (ParameterException) {
    http_response_code(400);
    header('Content-Type : image/jpeg');
    readfile("img/default.png");
} catch (EntityNotFoundException) {
    http_response_code(404);
    header('Content-Type : image/jpeg');
    readfile("img/default.png");
} catch (Exception) {
    http_response_code(500);
    header('Content-Type : image/jpeg');
    readfile("img/default.png");
}