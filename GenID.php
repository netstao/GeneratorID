<?php
/**
 * Created by PhpStorm.
 * User: netstao
 * Date: 2016/5/9
 * Time: 10:21
 */

namespace src;

class GenID
{
    const   EPOCH      = 14188017870000; //某个时间偏移点
    const   TMPTIME    = 1099511627775;  //毫秒时间位
    const   MACHINE    = 511;            //机器位
    const   RANDOM     = 2047;           //随机数

    public static function generateID($machineID=1)
    {
        /*
        * Time - 41 bits
        */
        $time = floor(microtime(true) * 10000);
        /*
        * Substract custom epoch from current time
        */
        $time -= self::EPOCH;

        /*
        * Create a base and add time to it
        */
        $base = decbin(self::TMPTIME + $time);

        /*
        * Configured machine id - 10 bits - up to 512 machines
        */
        $machineid = decbin(self::MACHINE + $machineID);

        /*
        * sequence number - 12 bits - up to 2048 random numbers per machine
        */
        $random = mt_rand(1, self::RANDOM);
        $random = decbin(self::RANDOM + $random);

        /*
        * Pack
        */
        $base = $base.$machineid.$random;

        /*
        * Return unique time id no
        */
        return bindec($base);
    }

    public static function timeFromID($ID)
    {
        /*
        * Return time
        */
        return bindec(substr(decbin($ID),0,41)) - pow(2,40) + 1 + self::EPOCH;
    }

}