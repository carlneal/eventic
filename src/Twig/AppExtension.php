<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {

    public function getFilters() {
        return [
            new TwigFilter('getLangFlag', [$this, 'getLangFlag']),
            new TwigFilter('getLangName', [$this, 'getLangName']),
        ];
    }

    public function getLangFlag($lang) {
        switch ($lang) {
            case "en":
                $flag = "us";
                break;
            case "fr":
                $flag = "fr";
                break;
            case "es":
                $flag = "es";
                break;
            case "ar":
                $flag = "sa";
                break;
            default:
                $flag = "us";
        }
        return $flag;
    }

    public function getLangName($lang) {
        switch ($lang) {
            case "en":
                $name = "English";
                break;
            case "fr":
                $name = "Français";
                break;
            case "es":
                $name = "Spanish";
                break;
            case "ar":
                $name = "عربي";
                break;
            default:
                $name = "English";
        }
        return $name;
    }

}
