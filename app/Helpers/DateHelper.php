<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\Izin;
use App\Models\Admin\Ulo;
use App\Models\OffDay;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;

class DateHelper{
    
    public function __construct(){
        if (!isset($GLOBALS["date_day_id"])) $GLOBALS["date_day_id"] = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
        if (!isset($GLOBALS["date_month_id"]))$GLOBALS["date_month_id"] = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        if (!isset($GLOBALS["date_month_en"]))$GLOBALS["date_month_en"] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        if (!isset($GLOBALS["date_simple_month_id"]))$GLOBALS["date_simple_month_id"] = array("JAN", "FEB", "MAR", "APR", "MEI", "JUNI", "JULI", "AUG", "SEPT", "OKT", "NOV", "DES");
        if (!isset($GLOBALS["date_simple_month"]))$GLOBALS["date_simple_month"] = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    }

    function date_reformat($format = "", $strdate = "") {
        return @date($format, @strtotime($strdate));
    }


    function dateday_lang_reformat_long($strdate, $lang = "id") {
        global $date_day_id, $date_month_id;
        
        $sttime = @strtotime($strdate);
        if ($lang == "id") {
            return $date_day_id[date("w", $sttime)].", ".date("j", $sttime)." ".$date_month_id[date("n", $sttime)-1]." ".date("Y", $sttime);
        } else {
            return date("l, F j Y");
        }
    }

    function date_lang_reformat_long($strdate, $lang = "id") {
        global $date_day_id, $date_month_id;
        
        $sttime = @strtotime($strdate);
        if ($lang == "id") {
            return date("j", $sttime)." ".$date_month_id[date("n", $sttime)-1]." ".date("Y", $sttime);
        } else {
            return date("l, F j Y");
        }
    }

    function date_lang_reformat_long_with_time($strdate, $lang = "id") {
        global $date_day_id, $date_month_id;
        
        $sttime = @strtotime($strdate);
        if ($lang == "id") {
            return date("j", $sttime)." ".$date_month_id[date("n", $sttime)-1]." ".date("Y", $sttime).' - '.date("H:i:s", $sttime);
        } else {
            return date("l, F j Y");
        }
    }

    static function getWorkingDays($startDate, $endDate, $holidays)
    {
        if (empty($holidays)) {
            $offday = OffDay::all();
            $holidays = [];
            foreach ($offday as $off) {
                array_push($holidays, $off['off_day']);
            };
        }

        // do strtotime calculations just once
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);


        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        } else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)

            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            } else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }

        //We subtract the holidays
        foreach ($holidays as $holiday) {
            $time_stamp = strtotime($holiday);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
                $workingDays--;
        }

        return $workingDays;
    }
}
