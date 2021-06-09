<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppServices;

class CountryController extends Controller {

    /**
     * @Route("/get-countries", name="get_countries")
     */
    public function getCountries(Request $request, AppServices $services): Response {

        $q = ($request->query->get('q')) == "" ? "all" : $request->query->get('q');
        $limit = ($request->query->get('limit')) == "" ? 10 : $request->query->get('limit');

        $countries = $services->getCountries(array('keyword' => $q, 'limit' => $limit))->getQuery()->getResult();

        $results = array();
        foreach ($countries as $country) {
            $result = array('id' => $country->getSlug(), 'text' => $country->getName());
            array_push($results, $result);
        }

        return $this->json($results);
    }

    /**
     * @Route("/get-country/{slug}", name="get_country")
     */
    public function getCountry($slug = null, AppServices $services): Response {
        $country = $services->getCountries(array('slug' => $slug))->getQuery()->getOneOrNullResult();

        return $this->json(array("slug" => $country->getSlug(), "text" => $country->getName()));
    }

}
