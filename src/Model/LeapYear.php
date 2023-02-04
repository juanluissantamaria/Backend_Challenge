<?php

namespace Crimsoncircle\Model;

class LeapYear
{
    public function isLeapYear(int $year = NULL): bool
    {
        //TODO: Logic must be implemented to calculate if a year is a leap year
        if (null === $year)
            $year = date('Y');
        return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
    }
}