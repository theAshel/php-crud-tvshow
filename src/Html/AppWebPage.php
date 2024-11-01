<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    /**
     * Texte qui sera compris dans la balise <nav>.
     */
    private string $menu = "";

    /**
     * Constructeur de la classe AppWebpage. En plus de sa classe mère WebPage,
     * elle ajoute une feuille de style par défaut.
     *
     * @param string $title Titre de la page.
     */
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    /**
    * Accesseur de la variable $menu.
     */
    public function getMenu(): string
    {
        return $this->menu;
    }

    /**
     * Ajouter un contenu dans $this->menu.
     * @param string $content Le contenu à ajouter
     */
    public function appendContentToMenu(string $content): void
    {
        $this->menu .= $content;
    }

    public function toHTML(): string
    {
        $html = <<<HTML
            <!doctype html>
            <html lang="fr">
                <head>
                    <title>{$this->getTitle()}</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    {$this->getHead()}
                </head>
                <body>
                    <header class="header">
                        <h1>{$this->getTitle()}</h1>
                    </header>
                    <nav class="menu">
                        {$this->getMenu()}
                    </nav>
                    <main class="content">
                        {$this->getBody()}
                    </main>
                    <footer class="footer">
                        <p>Dernière modification : {$this::getLastModification()}</p>
                    </footer>
                </body>
            </html>
        HTML;

        return $html;
    }
}
