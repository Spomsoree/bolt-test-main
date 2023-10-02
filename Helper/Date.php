<?php

namespace App\Helper;

class Date
{
    static public function helper(): object
    {
        $datetime    = new \DateTime('today');
        $today       = $datetime->format('Y-m-d');
        $datetime    = new \DateTime('tomorrow');
        $tomorrow    = $datetime->format('Y-m-d');
        $weekdays    = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
        $weekdays_en = ['Montag' => 'monday', 'Dienstag' => 'tuesday', 'Mittwoch' => 'wednesday', 'Donnerstag' => 'thursday', 'Freitag' => 'friday', 'Samstag' => 'saturday', 'Sonntag' => 'sunday'];

        return (object)[
            'today'                   => $today,
            'tomorrow'                => $tomorrow,
            'weekdays'                => $weekdays,
            'weekdays_en'             => $weekdays_en,
            'today_css'               => 'today',
            'today_label'             => 'Heute',
            'tomorrow_label'          => 'Morgen',
            'timeline_length_default' => '780',
            'timeline_start_default'  => '09:00',
        ];
    }
}
