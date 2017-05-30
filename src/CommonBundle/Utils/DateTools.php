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
            return 'm/d/Y';
        } elseif ('fr' === $locale) {
            return 'd/m/Y';
        }

        throw new \LogicException();
    }
}