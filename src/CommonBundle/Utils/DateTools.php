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
            return 'm/d/y';
        } elseif ('en' === $locale) {
            return 'd/m/y';
        }
        throw new \LogicException();
    }
}