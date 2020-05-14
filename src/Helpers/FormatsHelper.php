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
 * 格式化数据，比如 金钱格式化
 * Class FormatsHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class FormatsHelper
{
    /**
     * 将 int 类型的金额过滤成 小数点金额
     * @param int $money
     * @return float|int|string
     */
    public static function decodeNumericMoney(int $money = 0)
    {
        if ($money < 0) {
            return '0.00';
        }
        if (is_numeric($money)) {
            $int_money = $money / 100;
            $int_money = sprintf("%.2f", $int_money);
        } else {
            $int_money = 0;
        }
        return $int_money;
    }

    /**
     * 将 decimal 类型的金额过滤成 int 金额
     * @param float $money
     * @return float|int
     */
    public static function escapeNumericMoney(float $money = 0)
    {
        if ($money <= 0) {
            return 0;
        }
        if (is_numeric($money)) {
            $int_money = ($money * 100);
            $int_money = ( float )($int_money);
        } else {
            $int_money = 0;
        }
        return $int_money;
    }
}