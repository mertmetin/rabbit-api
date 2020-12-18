<?php

namespace App;

class TaxCalculator
{
    /**
     * Federal Tax
     */
    const TAX_FEDERAL = 5;

    /**
     * Ontario
     */
    const TAX_ON = 8;

    /**
     * Newfoundland and Labrador
     */
    const TAX_NL = 10;

    /**
     * Nova Scotia
     */
    const TAX_NS = 10;

    /**
     * Prince Edward Island
     */
    const TAX_PEI = 10;

    /**
     * Prince Edward Island
     */
    const TAX_NB = 10;

    /**
     * Quebec
     */
    const TAX_QC = 9.975;

    /**
     * Manitoba
     */
    const TAX_MB = 7;

    /**
     * Saskatchewan
     */
    const TAX_SK = 6;

    /**
     * Alberta
     */
    const TAX_AB = 0;

    /**
     * British Columbia
     */
    const TAX_BC = 7;

    /**
     * Northwest Territories
     */
    const TAX_NT = 5;

    /**
     * Yukon
     */
    const TAX_YT = 5;

    public function calculateTax($postalCode, $price)
    {
        $firstChar = substr($postalCode, 0, 1);

        switch ($firstChar)
        {
            case 'A':
                $hst = (self::TAX_NL + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'B':
                $hst = (self::TAX_NS + self::TAX_FEDERAL) * $price / 100 ;
                break;
            case 'C':
                $hst = (self::TAX_PEI + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'E':
                $hst = (self::TAX_NB + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'G':
            case 'H':
            case 'J':
                $hst = (self::TAX_QC + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'K':
            case 'L':
            case 'M':
            case 'N':
            case 'P':
                $hst = (self::TAX_ON + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'R':
                $hst = (self::TAX_MB + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'S':
                $hst = (self::TAX_SK + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'T':
                $hst = (self::TAX_AB + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'V':
                $hst = (self::TAX_BC + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'X':
                $hst = (self::TAX_NT + self::TAX_FEDERAL) * $price / 100;
                break;
            case 'Y':
                $hst = (self::TAX_NT + self::TAX_FEDERAL) * $price / 100;
                break;
            default:
                throw new \Exception('Invalid postal code');
        }

        return $hst;
    }
}