<?php

namespace CommonBundle\Utils;

/**
 * Class DateTools
 *
 * @package CommonBundle\Utils
 */
class DateTools
{
    /**
     * @param string $locale
     *
     * @return string
     */
    static public function getLocalizedDateFormat($locale )
    {
        if ('en' === $locale) {
            return 'm/d/y H:m';
        } elseif ('en' === $locale) {
            return 'd/m/y H:m';
        }
        throw new \LogicException();
    }
}