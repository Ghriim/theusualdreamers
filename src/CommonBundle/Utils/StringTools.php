<?php

namespace CommonBundle\Utils;

/**
 * Class StringTools
 *
 * @package CommonBundle\Utils
 */
class StringTools
{
    /**
     * @param $text
     *
     * @return string
     */
    static public function slugify ($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', ' ', $text);
        $text = self::removeAccents($text);
        $text = preg_replace('~[^-\w]+~', ' ', $text);
        $text = trim($text, ' ');
        $text = preg_replace('~-+~', ' ', $text);
        $text = strtolower($text);

        return str_replace(' ', '-', $text);
    }

    /**
     * @param string $str
     * @param string $charset
     *
     * @return mixed|string
     */
    static function removeAccents ($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

        return $str;
    }
}