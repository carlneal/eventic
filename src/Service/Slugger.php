<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;

class Slugger {

    /**
     * Disable the transliterate
     *
     * @param $text
     * @param string $separator
     * @return mixed
     */
    public static function transliterate($text, $separator = '-') {
        $text = self::slugify($text, $separator);
        return $text;
    }

    /**
     * Slugify the given text
     *
     * @param $text
     * @param string $separator
     * @return string
     */
    public static function urlize($text, $separator = '-') {
        $text = Urlizer::unaccent($text);
        $text = self::slugify($text, $separator);
        return $text;
    }

    /**
     * Encode the Unicode values to be used in the URI.
     *
     * ported from wordpress
     * @see https://core.trac.wordpress.org/browser/tags/3.9.1/src/wp-includes/formatting.php#L572
     *
     * @param string $utf8_string
     * @param int $length Max length of the string
     * @return string String with Unicode encoded for URI.
     */
    private static function utf8_uri_encode($utf8_string, $length = 0) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;
        $string_length = strlen($utf8_string);
        for ($i = 0; $i < $string_length; $i++) {
            $value = ord($utf8_string[$i]);
            if ($value < 128) {
                if ($length && ( $unicode_length >= $length ))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0)
                    $num_octets = ( $value < 224 ) ? 2 : 3;
                $values[] = $value;
                if ($length && ( $unicode_length + ($num_octets * 3) ) > $length)
                    break;
                if (count($values) == $num_octets) {
                    if ($num_octets == 3) {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                        $unicode_length += 9;
                    } else {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                        $unicode_length += 6;
                    }
                    $values = array();
                    $num_octets = 1;
                }
            }
        }
        return $unicode;
    }

    /**
     * Make the string slug compatible
     * ported from wordpress
     *
     * @see https://core.trac.wordpress.org/browser/tags/3.9.1/src/wp-includes/formatting.php#L1058
     *
     * @param $text
     * @param $separator
     * @return string
     */
    private static function slugify($text, $separator) {
        $text = str_replace('%', '', $text);
        if (Urlizer::seemsUtf8($text)) {
            if (function_exists('mb_strtolower')) {
                $text = mb_strtolower($text, 'UTF-8');
            }
            $text = self::utf8_uri_encode($text, 200);
        } else {
            $text = strtolower($text);
        }
        $text = str_replace('.', $separator, $text);
// Convert nbsp, ndash and mdash to hyphens
        $text = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), $separator, $text);
// Strip these characters entirely
        $text = str_replace(array(
// iexcl and iquest
            '%c2%a1', '%c2%bf',
// angle quotes
            '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
// curly quotes
            '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
            '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
// copy, reg, deg, hellip and trade
            '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
                ), '', $text);
        $text = preg_replace('/[^%a-z0-9 _-]/', '', $text);
        $text = preg_replace('/\s+/', $separator, $text);
        $text = preg_replace('|-+|', $separator, $text);
        $text = trim($text, $separator);
        $text = urldecode($text);
        return $text;
    }

}
