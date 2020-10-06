<?php

namespace App\DependencyInjection;

use DateTime;
use DateTimeZone;

/**
 * DateExtension.
 */
class DateTimeExtension
{
    public static function getNowDateTime(): DateTime
    {
        return new DateTime('now', new DateTimeZone('Europe/Lisbon'));
    }
}
