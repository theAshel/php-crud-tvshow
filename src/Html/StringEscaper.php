<?php

namespace Html;

trait StringEscaper
{
    /**
     * @param string|null $string
     * @return string
     */
    public function escapeString(?string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
    }

    public function stripTagsAndTrim(?string $text): string
    {
        return $text ? trim(strip_tags($text)) : "";
    }
}