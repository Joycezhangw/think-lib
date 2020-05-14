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

use think\captcha\Captcha;

/**
 * 工具类
 * Class Utils
 * @package JoyceZ\ThinkLib\Utility
 */
class Utils
{
    /**
     * 验证验证码是否正确
     * @param $value
     * @param string $id
     * @return bool
     */
    public static function captcha_check($value, $id = '')
    {
        $captcha= new Captcha((array) Config::pull('captcha'));
        return $captcha->check($value, $id);
    }

    /**
     *  重写ip2long，将ip地址转换为整型
     * @param string $ip
     * @return string
     */
    static function ip2long($ip = '127.0.0.1')
    {
        //ip2long可转换为整型，但会出现携带符号问题。需格式化为无符号的整型，利用sprintf函数格式化字符串。
        //然后用long2ip将整型转回IP字符串
        //MySQL函数转换(无符号整型，UNSIGNED)
        //INET_ATON('218.5.49.94');将IP转为整型 INET_NTOA(3657773406);将整型转为IP
        return sprintf('%u', ip2long($ip));
    }

    /**
     * 获取 header 中的 $Authorization
     * @param $Authorization
     * @return mixed|null
     */
    static function getBearerToken($Authorization) {
        if (!empty($Authorization)) {
            if (preg_match('/Bearer\s(\S+)/', $Authorization, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}