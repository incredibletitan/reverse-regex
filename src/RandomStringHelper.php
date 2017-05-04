<?php

namespace src;

/**
 * Class RandomStringHelper
 *
 * @author Yuriy Stos
 */
class RandomStringHelper
{
    /**
     * Generates random string by range
     *
     * @param $rangeStart
     * @param $rangeEnd
     * @param int $limitFrom
     * @param int $limitTo
     * @return string
     */
    public static function randomString($rangeStart, $rangeEnd, $limitFrom = 1, $limitTo = 0)
    {
        $str = "";
        $characters = range($rangeStart, $rangeEnd);

        $max = count($characters) - 1;

        if ($limitTo && $limitTo >= $limitFrom) {
            $length = mt_rand($limitFrom, $limitTo);
        } else {
            $length = $limitFrom;
        }

        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}