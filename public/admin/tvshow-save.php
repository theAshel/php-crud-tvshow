<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    $tvShowForm = new TVShowForm();
    $tvShowForm->setEntityFromQueryString();
    $tvShowForm->getTvShow()->save();

    header("Location: /");
    exit();
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}