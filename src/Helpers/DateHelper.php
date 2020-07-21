<?php
// +----------------------------------------------------------------------
// | 通用类包
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.hmall.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: joyecZhang <787027175@qq.com>
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace JoyceZ\ThinkLib\Helpers;

/**
 * 日期常用助手函数
 *
 * Class DateHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class DateHelper
{
    /**
     * 获取今日开始时间戳和结束时间戳
     *
     * 语法：mktime(hour,minute,second,month,day,year) => (小时,分钟,秒,月份,天,年)
     */
    public static function today()
    {
        return [
            'start' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
            'end' => mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1,
        ];
    }

    /**
     * 昨日
     *
     * @return array
     */
    public static function yesterday()
    {
        return [
            'start' => mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')),
            'end' => mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1,
        ];
    }

    /**
     * 本周
     * @return array
     */
    public static function week()
    {
        $length = 0;
        // 星期天直接返回上星期，因为计算周围 星期一到星期天，如果不想直接去掉
        if (date('w') == 0) {
            $length = 7;
        }

        return [
            'start' => mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - $length, date('Y')),
            'end' => mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - $length, date('Y')),
        ];
    }

    /**
     * 上周
     *
     * @return array
     */
    public static function lastWeek()
    {
        $length = 7;
        // 星期天直接返回上星期，因为计算周围 星期一到星期天，如果不想直接去掉
        if (date('w') == 0) {
            $length = 14;
        }
        return [
            'start' => mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - $length, date('Y')),
            'end' => mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - $length, date('Y')),
        ];
    }

    /**
     * 本月
     *
     * @return array
     */
    public static function thisMonth()
    {
        return [
            'start' => mktime(0, 0, 0, date('m'), 1, date('Y')),
            'end' => mktime(23, 59, 59, date('m'), date('t'), date('Y')),
        ];
    }

    /**
     * 上个月
     *
     * @return array
     */
    public static function lastMonth()
    {
        $start = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
        $end = mktime(23, 59, 59, date('m') - 1, date('t'), date('Y'));

        if (date('m', $start) != date('m', $end)) {
            $end -= 60 * 60 * 24;
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    /**
     * 几个月前
     *
     * @param integer $month 月份
     * @return array
     */
    public static function monthsAgo($month)
    {
        return [
            'start' => mktime(0, 0, 0, date('m') - $month, 1, date('Y')),
            'end' => mktime(23, 59, 59, date('m') - $month, date('t'), date('Y')),
        ];
    }

    /**
     * 某年
     * @param $year
     * @return array
     */
    public static function someYear($year)
    {
        $start_month = 1;
        $end_month = 12;

        $start_time = $year . '-' . $start_month . '-1 00:00:00';
        $end_month = $year . '-' . $end_month . '-1 23:59:59';
        $end_time = date('Y-m-t H:i:s', strtotime($end_month));

        return [
            'start' => strtotime($start_time),
            'end' => strtotime($end_time)
        ];
    }

    /**
     * 某月
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public static function aMonth($year = 0, $month = 0)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        $day = date('t', strtotime($year . '-' . $month));

        return [
            "start" => strtotime($year . '-' . $month),
            "end" => mktime(23, 59, 59, $month, $day, $year)
        ];
    }

    /**
     * @param int $time
     * @param string $format
     * @return mixed
     */
    public static function getWeekName(int $time, $format = "周")
    {
        $week = date('w', $time);
        $weekName = ['日', '一', '二', '三', '四', '五', '六'];
        foreach ($weekName as &$item) {
            $item = $format . $item;
        }

        return $weekName[$week];
    }

    /**
     * 格式化时间戳
     *
     * @param $time
     * @return string
     */
    public static function formatTimestamp($time)
    {
        $min = $time / 60;
        $hours = $time / 3600;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));

        return $days . " 天 " . $hours . " 小时 " . $min . " 分钟 ";
    }

    /**
     * 格式化时间戳
     * @param int $time 时间戳
     * @param string $format 格式化时间格式
     * @return false|string
     */
    public static function formatParseTime(int $time = 0, string $format = 'Y-m-d H:i:s')
    {
        return $time > 0 ? date($format, $time) : '';
    }

    /**
     * 生成时间戳
     * @param int $accuracy 精度 默认微妙
     * @return string
     */
    public static function buildTimestamp($accuracy = 1000)
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * $accuracy);
    }

    /**
     * 当前时间多久之前，以天核算
     * @param int $curTime
     * @return false|string
     */
    public static function formatDateLongAgo(int $curTime)
    {
        $todayLast = strtotime(date('Y-m-d 23:59:59'));
        $agoTime = $todayLast - $curTime;
        $agoDay = intval(floor($agoTime / 86400));
        if ($agoDay === 0) {
            return '今天' . date('H:i', $curTime);
        } elseif ($agoDay === 1) {
            return '昨天 ' . date('H:i', $curTime);
        } elseif ($agoDay === 2) {
            return '前天 ' . date('H:i', $curTime);
        } elseif ($agoDay > 2 && $agoDay < 16) {
            return $agoDay . '天前 ' . date('H:i', $curTime);
        } else {
            $format = date('Y') != date('Y', $curTime) ? 'Y-m-d H:i' : 'm-d H:i';
            return date($format, $curTime);
        }
    }

    /**
     * 当前时间多久之前，以分钟到天核算
     * @param int $curTime
     * @return false|string
     */
    public static function formatTimeLongAgo(int $curTime)
    {
        $todayLast = strtotime(date('Y-m-d 23:59:59'));
        $agoTimestamp = time() - $curTime;
        $agoTime = $todayLast - $curTime;
        $agoDay = intval(floor($agoTime / 86400));

        if ($agoTimestamp < 60) {
            $result = '刚刚';
        } elseif ($agoTimestamp < 3600) {
            $result = (ceil($agoTimestamp / 60)) . '分钟前';
        } elseif ($agoTimestamp < 3600 * 12) {
            $result = (ceil($agoTimestamp / 3600)) . '小时前';
        } elseif ($agoDay === 0) {
            $result = '今天 ' . date('H:i', $curTime);
        } elseif ($agoDay === 1) {
            $result = '昨天 ' . date('H:i', $curTime);
        } elseif ($agoDay === 2) {
            $result = '前天 ' . date('H:i', $curTime);
        } elseif ($agoDay > 2 && $agoDay < 16) {
            $result = $agoDay . '天前 ' . date('H:i', $curTime);
        } else {
            $format = date('Y') != date('Y', $curTime) ? 'Y-m-d H:i' : 'm-d H:i';
            return date($format, $curTime);
        }
        return $result;
    }

}