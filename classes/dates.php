<?php
class Dates{
    
    public static function daysCount($startDate,$endDate)
    {
        return ((strtotime($endDate) - strtotime($startDate))/ (60 * 60 * 24))+1;
    }
    
    public static function isEvenWeek($date)
    {
        return (boolean)((strtotime($date) - strtotime("2006-01-01"))/ (60 * 60 * 24 * 7))%2;
    }
    
    public static function dayOfFortnight($date)
    {
        return ((strtotime($date) - strtotime("2006-01-01"))/ (60 * 60 * 24))%14 + 1;
    }
    
    public static function convertDateToBulgarianStandard($date)
    {
        $d = strptime($date, '%Y-%m-%d');
        $timestamp = mktime(0, 0, 0, $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
        return date ("d.m.Y", $timestamp)."г.";
    }
    
    public static function convertDateFromBulgarianStandard($dateBG)
    {
        $d = strptime($dateBG, '%d.%m.%Y');
        $timestamp = mktime(0, 0, 0, $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
        return date ("Y-m-d", $timestamp);
    }
    
    public static function dateShift($date,$days=0,$weeks=0,$months=0)
    {
        $d = strptime($date, '%Y-%m-%d');
        $days = $days+7*$weeks;
        $timestamp = mktime(0, 0, 0, $d['tm_mon']+1+$months, $d['tm_mday']+$days, $d['tm_year']+1900);
        return date ("Y-m-d", $timestamp);
    }
    
    public static function mkDateToGetParameters($date)
    {
        $d = strptime($date, '%Y-%m-%d');
        $timestamp = mktime(0, 0, 0, $d['tm_mon']+1, $d['tm_mday'], $d['tm_year']+1900);
        return "day=".date("d", $timestamp)."&month=".date("m", $timestamp)."&year=".date("Y", $timestamp);
    }
    
    public static function getWeekday($date)
    {
        $d = strptime($date, '%Y-%m-%d');
        $timestamp = mktime(0, 0, 0, $d['tm_mon']+1, $d['tm_mday']+$i, $d['tm_year']+1900);
        switch  ((int) date("w", $timestamp))
        {
            case 0:
                $day = "неделя";
                break;
            case 1:
                $day = "понеделник";
                break;
            case 2:
                $day = "вторник";
                break;
            case 3:
                $day = "сряда";
                break;
            case 4:
                $day = "четвъртък";
                break;
            case 5:
                $day = "петък";
                break;
            case 6:
                $day = "събота";
                break;
            default:
                brak;
        }
        
        return $day;
    }
    
    public static function isCorectDate($date)
    {
        if(preg_match("/^[12][0-9]{3}-[01][0-9]-[0123][0-9]$/",$date))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}