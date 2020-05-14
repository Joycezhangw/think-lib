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
 *
 * bcmath 高精度库
 *
 * 在 php7+版本中，bcmath扩展库，要自己安装上，没有自动安装
 *
 * 四舍六入(银行家舍入)
 * round(3.1489, 2, PHP_ROUND_HALF_EVEN);
 *
 * Class BcHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class BcHelper
{
    /**
     * 将两个高精确度数字相加
     *
     * @param string|float $left_operand
     * @param string|float $right_operand
     * @param int $scale
     * @return string
     */
    public static function add($left_operand, $right_operand, int $scale = 2): string
    {
        return bcadd($left_operand, $right_operand, $scale);
    }

    /**
     * 将两个高精度数字相减
     * @param string|float $left_operand
     * @param string|float $right_operand
     * @param int $scale
     * @return string
     */
    public static function sub($left_operand, $right_operand, int $scale = 2): string
    {
        return bcsub($left_operand, $right_operand, $scale);
    }

    /**
     * 两数相乘
     * @param string|float $left_operand
     * @param string|float $right_operand
     * @param int $scale
     * @return string
     */
    public static function mul($left_operand, $right_operand, int $scale = 2): string
    {
        return bcmul($left_operand, $right_operand, $scale);
    }

    /**
     * 两数相除
     * @param string|float $left_operand 左边操作数
     * @param string|float $right_operand 右边操作数
     * @param int $scale
     * @return string|null
     */
    public static function div($left_operand, $right_operand, int $scale = 2): string
    {
        return bcdiv($left_operand, $right_operand, $scale);
    }

    /**
     * 任意精度数字的乘方，左操作数的右操作数次方运算.
     * @param string|float $left_operand 字符串类型的左操作数.
     * @param string|float $right_operand 字符串类型的右操作数.
     * @param int $scale
     * @return string
     */
    public static function pow($left_operand, $right_operand, int $scale = 2): string
    {
        return bcpow($left_operand, $right_operand, $scale);
    }

    /**
     * 两个高精度数求余/取模,对左操作数使用系数取模
     * @param string|float $left_operand 字符串类型的左操作数
     * @param string|float $modulus 字符串类型系数
     * @param int $scale
     * @return string|null
     */
    public static function mod($left_operand, $modulus, int $scale = 2): string
    {
        return bcmod($left_operand, $modulus, $scale);
    }

    /**
     * 比较两个任意精度的数字
     * 把right_operand和left_operand作比较, 并且返回一个整数的结果.
     * @param string|float $left_operand 左边的运算数, 是一个字符串.
     * @param string|float $right_operand 右边的运算数, 是一个字符串.
     * @param int $scale
     * @return int
     */
    public static function comp($left_operand, $right_operand, int $scale = 2): int
    {
        return bccomp($left_operand, $right_operand, $scale);
    }

    /**
     * 任意精度数字的二次方根
     * @param string|float $operand 字符串类型的操作数.
     * @param int|null $scale
     * @return string
     */
    public static function sqrt($operand, int $scale = null): string
    {
        return bcsqrt($operand, $scale);

    }


    /**
     * 设置所有bc数学函数的默认小数点保留位数
     *
     * @param $scale
     * @return bool
     */
    public static function scale(int $scale)
    {
        return bcscale($scale);
    }


    /**
     * 四舍五入
     * @param $num
     * @param int $scale
     * @return false|float
     */
    public static function round($num, int $scale = 2)
    {
        return round($num, $scale);
    }
}