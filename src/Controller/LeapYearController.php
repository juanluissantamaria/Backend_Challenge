<?php
namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\LeapYear;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function index(Request $request, int $year = NULL): string
    {
        echo $request->query->get('filter');
        $leapYear = new LeapYear();
        if ($leapYear->isLeapYear($year)) {
            return 'Yep, this is a leap year!';
        }

        return 'Nope, this is not a leap year.';
    }
}