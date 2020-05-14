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
 * 字符操作
 * Class StrHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class StrHelper
{
    const UTF8 = 'utf-8';
    const GBK = 'gbk';

    /**
     * 截取字符串,支持字符编码,默认为utf-8
     * @param string $string 要截取的字符串编码
     * @param int $start 开始截取
     * @param int $length 截取的长度
     * @param string $charset 原妈编码,默认为UTF8
     * @param bool $dot 是否显示省略号,默认为false
     * @return false|string 截取后的字串
     */
    public static function substr(string $string, int $start, int $length, $charset = self::UTF8, $dot = false)
    {
        switch (strtolower($charset)) {
            case self::GBK:
                $string = self::substrForGbk($string, $start, $length, $dot);
                break;
            case self::UTF8:
                $string = self::substrForUtf8($string, $start, $length, $dot);
                break;
            default:
                $string = substr($string, $start, $length);
        }
        return $string;
    }

    /**
     * 以utf8格式截取的字符串编码
     * @param string $string 要截取的字符串编码
     * @param int $start 开始截取
     * @param null $length 截取的长度，默认为null，取字符串的全长
     * @param bool $dot 是否显示省略号，默认为false
     * @return false|string
     */
    public static function substrForUtf8(string $string, int $start, $length = null, $dot = false)
    {
        $l = strlen($string);
        $p = $s = 0;
        if (0 !== $start) {
            while ($start-- && $p < $l) {
                $c = $string[$p];
                if ($c < "\xC0")
                    $p++;
                elseif ($c < "\xE0")
                    $p += 2;
                elseif ($c < "\xF0")
                    $p += 3;
                elseif ($c < "\xF8")
                    $p += 4;
                elseif ($c < "\xFC")
                    $p += 5;
                else
                    $p += 6;
            }
            $s = $p;
        }

        if (empty($length)) {
            $t = substr($string, $s);
        } else {
            $i = $length;
            while ($i-- && $p < $l) {
                $c = $string[$p];
                if ($c < "\xC0")
                    $p++;
                elseif ($c < "\xE0")
                    $p += 2;
                elseif ($c < "\xF0")
                    $p += 3;
                elseif ($c < "\xF8")
                    $p += 4;
                elseif ($c < "\xFC")
                    $p += 5;
                else
                    $p += 6;
            }
            $t = substr($string, $s, $p - $s);
        }

        $dot && ($p < $l) && $t .= "...";
        return $t;
    }

    /**
     * 以gbk格式截取的字符串编码
     * @param string $string 要截取的字符串编码
     * @param int $start 开始截取
     * @param null $length 截取的长度，默认为null，取字符串的全长
     * @param bool $dot 是否显示省略号，默认为false
     * @return false|string
     */
    public static function substrForGbk(string $string, int $start, $length = null, $dot = false)
    {
        $l = strlen($string);
        $p = $s = 0;
        if (0 !== $start) {
            while ($start-- && $p < $l) {
                if ($string[$p] > "\x80")
                    $p += 2;
                else
                    $p++;
            }
            $s = $p;
        }

        if (empty($length)) {
            $t = substr($string, $s);
        } else {
            $i = $length;
            while ($i-- && $p < $l) {
                if ($string[$p] > "\x80")
                    $p += 2;
                else
                    $p++;
            }
            $t = substr($string, $s, $p - $s);
        }

        $dot && ($p < $l) && $t .= "...";
        return $t;
    }

    /**
     * 以utf8求取字符串长度
     * @param string $string 要计算的字符串编码
     * @return int
     */
    public static function strLenForUtf8(string $string)
    {
        $l = strlen($string);
        $p = $c = 0;
        while ($p < $l) {
            $a = $string[$p];
            if ($a < "\xC0")
                $p++;
            elseif ($a < "\xE0")
                $p += 2;
            elseif ($a < "\xF0")
                $p += 3;
            elseif ($a < "\xF8")
                $p += 4;
            elseif ($a < "\xFC")
                $p += 5;
            else
                $p += 6;
            $c++;
        }
        return $c;
    }

    /**
     * 以gbk求取字符串长度
     * @param string $string 要计算的字符串编码
     * @return int
     */
    public static function strLenForGbk(string $string)
    {
        $l = strlen($string);
        $p = $c = 0;
        while ($p < $l) {
            if ($string[$p] > "\x80")
                $p += 2;
            else
                $p++;
            $c++;
        }
        return $c;
    }

    /**
     * 生成13位码
     * @return string
     */
    public static function getVoucherCode()
    {
        $time = time();
        $start = mt_rand(10000, 99999);
        $end = mt_rand(10000, 99999);
        return $start . substr($time, strlen($time) - 3, 3) . $end;
    }

    /**
     * 生成订单号
     * @return string
     */
    public static function orderNo()
    {
        return date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * 字符串匹配替换
     *
     * @param string $search 查找的字符串
     * @param string $replace 替换的字符串
     * @param string $subject 字符串
     * @param null $count
     * @return mixed
     */
    public static function replace(string $search, string $replace, string $subject, &$count = null)
    {
        return str_replace($search, $replace, $subject, $count);
    }


    /**
     * 将一个字符串部分字符用*替代隐藏
     * @param string $string 待转换的字符串
     * @param int $begin 起始位置，从0开始计数，当$type=4时，表示左侧保留长度
     * @param int $len 需要转换成*的字符个数，当$type=4时，表示右侧保留长度
     * @param int $type  转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
     * @param string $glue 分割符
     * @return bool|string
     */
    public static function hideStr(string $string, int $begin = 0, int $len = 4, int $type = 0,string $glue = "@"){
        if (empty($string)) {
            return false;
        }

        $array = [];
        if ($type == 0 || $type == 1 || $type == 4) {
            $strLen = $length = mb_strlen($string);

            while ($strLen) {
                $array[] = mb_substr($string, 0, 1, "utf8");
                $string = mb_substr($string, 1, $strLen, "utf8");
                $strLen = mb_strlen($string);
            }
        }

        switch ($type) {
            case 0 :
                for ($i = $begin; $i < ($begin + $len); $i++) {
                    isset($array[$i]) && $array[$i] = "*";
                }

                $string = implode("", $array);
                break;
            case 1 :
                $array = array_reverse($array);
                for ($i = $begin; $i < ($begin + $len); $i++) {
                    isset($array[$i]) && $array[$i] = "*";
                }

                $string = implode("", array_reverse($array));
                break;
            case 2 :
                $array = explode($glue, $string);
                $array[0] = self::hideStr($array[0], $begin, $len, 1);
                $string = implode($glue, $array);
                break;
            case 3 :
                $array = explode($glue, $string);
                $array[1] = self::hideStr($array[1], $begin, $len, 0);
                $string = implode($glue, $array);
                break;
            case 4 :
                $left = $begin;
                $right = $len;
                $tem = array();
                for ($i = 0; $i < ($length - $right); $i++) {
                    if (isset($array[$i])) {
                        $tem[] = $i >= $left ? "*" : $array[$i];
                    }
                }

                $array = array_chunk(array_reverse($array), $right);
                $array = array_reverse($array[0]);
                for ($i = 0; $i < $right; $i++) {
                    $tem[] = $array[$i];
                }
                $string = implode("", $tem);
                break;
        }

        return $string;
    }
}