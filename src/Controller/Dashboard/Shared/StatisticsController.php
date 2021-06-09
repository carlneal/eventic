<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\AppServices;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;

class StatisticsController extends Controller {

    /**
     * @Route("/administrator/manage-events/{eventSlug}/event-dates/{eventDateReference}/statistics", name="dashboard_administrator_event_date_statistics")
     * @Route("/organizer/my-events/{eventSlug}/event-dates/{eventDateReference}/statistics", name="dashboard_organizer_event_date_statistics")
     */
    public function eventDateStatistics($eventDateReference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $organizer = "all";
        if ($this->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $eventDate = $services->getEventDates(array("reference" => $eventDateReference, "organizer" => $organizer))->getQuery()->getOneOrNullResult();
        if (!$eventDate) {
            $this->addFlash('error', $translator->trans('The event date can not be found'));
            return $services->redirectToReferer('event');
        }

        // Tickets Sold By Channel Pie Chart
        $ticketsSoldByChannelPieChart = new PieChart();
        $ticketsSoldByChannelPieChart->getData()->setArrayToDataTable(
                [[$translator->trans("Sales channel"), $translator->trans("Number of tickets")],
                    [$translator->trans("Online"), $eventDate->getOrderElementsQuantitySum(1, "all", "ROLE_ATTENDEE")],
                    [$translator->trans("POS"), $eventDate->getOrderElementsQuantitySum(1, "all", "ROLE_POINTOFSALE")],
                ]
        );
        $ticketsSoldByChannelPieChart->getOptions()->setTitle($translator->trans("Tickets sold by channel"));
        $ticketsSoldByChannelPieChart->getOptions()->setIs3D(true);
        $ticketsSoldByChannelPieChart->getOptions()->setHeight(200);
        $ticketsSoldByChannelPieChart->getOptions()->setWidth(200);
        $ticketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setBold(false);
        $ticketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
        $ticketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
        $ticketsSoldByChannelPieChart->getOptions()->getLegend()->setPosition("bottom");

        // Gross Sales By Channel Pie Chart
        $grossSalesByChannelPieChart = new PieChart();
        $grossSalesByChannelPieChart->getData()->setArrayToDataTable(
                [[$translator->trans("Sales channel"), $translator->trans("Gross Sales")],
                    [$translator->trans("Online"), $eventDate->getSales("ROLE_ATTENDEE")],
                    [$translator->trans("POS"), $eventDate->getSales("ROLE_POINTOFSALE")],
                ]
        );
        $grossSalesByChannelPieChart->getOptions()->setTitle($translator->trans("Gross sales by channel") . " (" . $services->getSetting("currency_ccy") . ")");
        $grossSalesByChannelPieChart->getOptions()->setIs3D(true);
        $grossSalesByChannelPieChart->getOptions()->setHeight(200);
        $grossSalesByChannelPieChart->getOptions()->setWidth(200);
        $grossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setBold(false);
        $grossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
        $grossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
        $grossSalesByChannelPieChart->getOptions()->getLegend()->setPosition("bottom");

        // Point of sales stats
        $ticketsSoldPerPointOfSalePieChart = null;
        $grossSalesPerPointOfSalePieChart = null;
        if ($eventDate->getOrderElementsQuantitySum(1, "all", "ROLE_POINTOFSALE") > 0) {
            foreach ($eventDate->getPointofsales() as $pointOfSale) {
                $ticketsSoldPerPointOfSale[] = [$pointOfSale->getName(), $eventDate->getOrderElementsQuantitySum(1, $pointOfSale->getUser())];
                $grossSalesPerPointOfSale[] = [$pointOfSale->getName(), $eventDate->getSales("ROLE_POINTOFSALE", $pointOfSale->getUser())];
            }

            // Tickets sold Per Point of sale
            array_unshift($ticketsSoldPerPointOfSale, [$translator->trans("Point of sale"), $translator->trans("Tickets sold")]);
            $ticketsSoldPerPointOfSalePieChart = new PieChart();
            $ticketsSoldPerPointOfSalePieChart->getData()->setArrayToDataTable($ticketsSoldPerPointOfSale);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->setTitle($translator->trans("Tickets sold Per Point of sale"));
            $ticketsSoldPerPointOfSalePieChart->getOptions()->setIs3D(true);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->setHeight(200);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->setWidth(200);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setBold(false);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
            $ticketsSoldPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
            $ticketsSoldPerPointOfSalePieChart->getOptions()->getLegend()->setPosition("bottom");

            // Gross Sales Per Point of sale
            array_unshift($grossSalesPerPointOfSale, [$translator->trans("Point of sale"), $translator->trans("Gross sales")]);
            $grossSalesPerPointOfSalePieChart = new PieChart();
            $grossSalesPerPointOfSalePieChart->getData()->setArrayToDataTable($grossSalesPerPointOfSale);
            $grossSalesPerPointOfSalePieChart->getOptions()->setTitle($translator->trans("Gross sales per Point of sale") . " (" . $services->getSetting("currency_ccy") . ")");
            $grossSalesPerPointOfSalePieChart->getOptions()->setIs3D(true);
            $grossSalesPerPointOfSalePieChart->getOptions()->setHeight(200);
            $grossSalesPerPointOfSalePieChart->getOptions()->setWidth(200);
            $grossSalesPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setBold(false);
            $grossSalesPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
            $grossSalesPerPointOfSalePieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
            $grossSalesPerPointOfSalePieChart->getOptions()->getLegend()->setPosition("bottom");
        }

        // Tickets Sales By Date Line Chart
        $ordersQuantityByDate = $services->getOrders(array("eventdate" => $eventDateReference, "ordersQuantityByDateStat" => true, "order" => "ASC"))->getQuery()->getResult();
        foreach ($ordersQuantityByDate as $i => $resultArray) {
            $ordersQuantityByDate[$i] = array_values($resultArray);
            $ordersQuantityByDate[$i][1] = \DateTime::createFromFormat('Y-m-j', $ordersQuantityByDate[$i][1]);
            $ordersQuantityByDate[$i] = array_reverse($ordersQuantityByDate[$i]);
        }
        array_unshift($ordersQuantityByDate, [['label' => $translator->trans("Date"), 'type' => 'date'], ['label' => $translator->trans("Tickets sold"), 'type' => 'number']]);
        $ticketsSalesByDateLineChart = new LineChart();
        $ticketsSalesByDateLineChart->getData()->setArrayToDataTable($ordersQuantityByDate);
        $ticketsSalesByDateLineChart->getOptions()->setTitle($translator->trans("Tickets sales by date"));
        $ticketsSalesByDateLineChart->getOptions()->setCurveType('function');
        $ticketsSalesByDateLineChart->getOptions()->setLineWidth(2);
        $ticketsSalesByDateLineChart->getOptions()->getLegend()->setPosition('none');

        // Individual Tickets Sold By Channel Pie Charts
        $ticketsSoldByChannelPieChartsArray = array();
        $ticketsGrossSalesByChannelPieChartsArray = array();

        foreach ($eventDate->getTickets() as $eventTicket) {

            $thisTicketsSoldByChannelPieChart = new PieChart();
            $thisTicketsSoldByChannelPieChart->getData()->setArrayToDataTable(
                    [[$translator->trans("Sales channel"), $translator->trans("Number of tickets")],
                        [$translator->trans("Online"), $eventTicket->getOrderElementsQuantitySum(1, "all", "ROLE_ATTENDEE")],
                        [$translator->trans("POS"), $eventTicket->getOrderElementsQuantitySum(1, "all", "ROLE_POINTOFSALE")],
                    ]
            );
            $thisTicketsSoldByChannelPieChart->getOptions()->setTitle($translator->trans("Tickets sold by channel"));
            $thisTicketsSoldByChannelPieChart->getOptions()->setIs3D(true);
            $thisTicketsSoldByChannelPieChart->getOptions()->setHeight(200);
            $thisTicketsSoldByChannelPieChart->getOptions()->setWidth(200);
            $thisTicketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setBold(false);
            $thisTicketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
            $thisTicketsSoldByChannelPieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
            $thisTicketsSoldByChannelPieChart->getOptions()->getLegend()->setPosition("bottom");

            $thisGrossSalesByChannelPieChart = new PieChart();
            $thisGrossSalesByChannelPieChart->getData()->setArrayToDataTable(
                    [[$translator->trans("Sales channel"), $translator->trans("Gross Sales")],
                        [$translator->trans("Online"), $eventTicket->getSales("ROLE_ATTENDEE")],
                        [$translator->trans("POS"), $eventTicket->getSales("ROLE_POINTOFSALE")],
                    ]
            );
            $thisGrossSalesByChannelPieChart->getOptions()->setTitle($translator->trans("Gross sales by channel") . " (" . $services->getSetting("currency_ccy") . ")");
            $thisGrossSalesByChannelPieChart->getOptions()->setIs3D(true);
            $thisGrossSalesByChannelPieChart->getOptions()->setHeight(200);
            $thisGrossSalesByChannelPieChart->getOptions()->setWidth(200);
            $thisGrossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setBold(false);
            $thisGrossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setColor('#6c757d');
            $thisGrossSalesByChannelPieChart->getOptions()->getTitleTextStyle()->setFontSize(9);
            $thisGrossSalesByChannelPieChart->getOptions()->getLegend()->setPosition("bottom");

            array_push($ticketsSoldByChannelPieChartsArray, $thisTicketsSoldByChannelPieChart);
            array_push($ticketsGrossSalesByChannelPieChartsArray, $thisGrossSalesByChannelPieChart);
        }

        return $this->render('Dashboard/Shared/Statistics/event-date.html.twig', [
                    'eventDate' => $eventDate,
                    'ticketsSoldByChannelPieChart' => $ticketsSoldByChannelPieChart,
                    'grossSalesByChannelPieChart' => $grossSalesByChannelPieChart,
                    'ticketsSoldPerPointOfSalePieChart' => $ticketsSoldPerPointOfSalePieChart,
                    'grossSalesPerPointOfSalePieChart' => $grossSalesPerPointOfSalePieChart,
                    'ticketsSalesByDateLineChart' => $ticketsSalesByDateLineChart,
                    'ticketsSoldByChannelPieChartsArray' => $ticketsSoldByChannelPieChartsArray,
                    'ticketsGrossSalesByChannelPieChartsArray' => $ticketsGrossSalesByChannelPieChartsArray
        ]);
    }

}
