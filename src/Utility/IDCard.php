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

namespace JoyceZ\ThinkLib\Utility;

/**
 * 二代身份证相关函数
 * Class IDCard
 * @package JoyceZ\ThinkLib\Utility
 */
class IDCard
{
    /**
     * 根据身份证获取性别
     * @param string $idCard
     * @return string|null
     */
    static function gender(string $idCard)
    {
        if (empty($idCard)) return null;
        $ext = (int)substr($idCard, 16, 1);
        return $ext % 2 === 0 ? 2 : 1;
    }

    /**
     * 根据身份证号获取生日
     * @param string $idCard
     * @return string|null
     */
    static function birthday(string $idCard)
    {
        if (empty($idCard)) return null;
        $bir = substr($idCard, 6, 8);
        $year = (int)substr($bir, 0, 4);
        $month = (int)substr($bir, 4, 2);
        $day = (int)substr($bir, 6, 2);
        return $year . "-" . $month . "-" . $day;
    }

    /**
     * 根据身份证号码计算年龄
     * @param string $idCard
     * @return float|int|null
     */
    static function age(string $idCard)
    {
        if (empty($idCard)) return null;
        #  获得出生年月日的时间戳
        $date = strtotime(substr($idCard, 6, 8));
        #  获得今日的时间戳
        $today = strtotime('today');
        #  得到两个日期相差的大体年数
        $diff = floor(($today - $date) / 86400 / 365);
        #  strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        $age = strtotime(substr($idCard, 6, 8) . ' +' . $diff . 'years') > $today ? ($diff + 1) : $diff;
        return $age;
    }

    /**
     * 获取所在区域
     * @param string $idCard
     * @param int $type
     * @return mixed|string|null
     */
    static function region(string $idCard)
    {
        if (empty($idCard)) return null;
        return substr($idCard, 0, 6);
    }


    /**
     * 判断是否正确的身份证号
     * @param $idCard
     * @return string
     */
    static function isIdCard($idCard)
    {
        if (mb_strlen($idCard) != 18) return false;
        #  转化为大写，如出现x
        $idCard = strtoupper($idCard);
        #  加权因子
        $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        #  按顺序循环处理前17位
        $sigma = 0;
        #  提取前17位的其中一位，并将变量类型转为实数
        for ($i = 0; $i < 17; $i++) {
            $b = (int)$idCard{$i};
            #  提取相应的加权因子
            $w = $wi[$i];
            #  把从身份证号码中提取的一位数字和加权因子相乘，并累加
            $sigma += $b * $w;
        }
        #  计算序号
        $sidcard = $sigma % 11;
        #  按照序号从校验码串中提取相应的字符。
        $check_idcard = $ai[$sidcard];
        if ($idCard{17} == $check_idcard) {
            return true;
        } else {
            return false;
        }
    }
}