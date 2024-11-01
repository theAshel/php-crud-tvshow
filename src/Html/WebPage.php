<?php

namespace Html;

class WebPage
{
    use StringEscaper;
    /**
     * Texte qui sera compris entre <head> et </head>.
     */
    private string $head = "";

    /**
     * @var string Texte qui sera compris entre <title> et </title>
     */
    private string $title = "";

    /**
     * @var string Texte qui sera compris entre <body> et </body>.
     */
    private string $body = "";

    /**
     * Constructeur.
     * @param string $title Titre de la page
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Ajouter un contenu dans $this->body.
     * @param string $content Le contenu à ajouter
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Ajouter un contenu CSS dans $this->head.
     * @param string $css Le contenu CSS à ajouter
     * @see http://cutrona/but/s2/php-webpage/html/classWebPage.html#a4d462bd41c46b0aa1a9c5ce5d8d9d58e WebPage::appendToHead(string $content): void
     */
    public function appendCss(string $css): void
    {
        $style = <<<HTML
            <style>
{$css}
            </style>
HTML;
        $this->head .= $style;
    }

    /**
     * Ajouter l'URL d'un script CSS dans $this->head.
     * @param string $url L'URL du script CSS
     * @see http://cutrona/but/s2/php-webpage/html/classWebPage.html#a4d462bd41c46b0aa1a9c5ce5d8d9d58e WebPage::appendToHead(string $content) : void
     */
    public function appendCssUrl(string $url): void
    {
        $cssUrl = <<<HTML
        <link href='{$url}' rel='stylesheet' type='text/css'>

        HTML;

        $this->head .= $cssUrl;
    }

    /**
     * Ajouter un contenu JavaScript dans $this->head.
     * @param string $js Le contenu JavaScript à ajouter
     * @see http://cutrona/but/s2/php-webpage/html/classWebPage.html#a4d462bd41c46b0aa1a9c5ce5d8d9d58e WebPage::appendToHead(string $content) : void     */
    public function appendJs(string $js): void
    {
        $script = <<<HTML
            <script>
                {$js}
            </script>
        HTML;

        $this->head .= $script;
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans $this->head.
     * @param string $url L'URL du script JavaScript
     * @see http://cutrona/but/s2/php-webpage/html/classWebPage.html#a4d462bd41c46b0aa1a9c5ce5d8d9d58e WebPage::appendToHead(string $content) : void
     */
    public function appendJsUrl(string $url): void
    {
        $jsUrl = <<<HTML
            <script src="$url"></script>
        HTML;

        $this->head .= $jsUrl;
    }

    /**
     * Ajouter un contenu dans $this->head.
     * @param string $content Le contenu à ajouter
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Retourner le contenu de $this->body.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Retourner le contenu de $this->head.
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Donner la date et l'heure de la dernière modification du script principal.
     */
    public static function getLastModification(): string
    {
        return date("d F Y H:i:s.", getlastmod());
    }

    /**
     * Retourner le contenu de $this->title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Affecter le titre de la page.
     * @param string $title Le titre
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Produire la page Web complète.
     */
    public function toHTML(): string
    {
        $html = <<<HTML
            <!doctype html>
            <html lang="fr">
                <head>
                    <title>$this->title</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {$this->getHead()}
                </head>
                <body>
        {$this->getBody()}
                </body>
            </html>
        HTML;

        return $html;
    }
}
