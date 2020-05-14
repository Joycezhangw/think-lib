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
 * url 相关类
 *
 * Class UrlHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class UrlHelper
{
    /**
     * 获取当前域名
     * @param string $path 当前绝对路径，前缀需要斜杠
     * @return string
     */
    public static function asset($path = '')
    {
//        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
//        return $http_type . $_SERVER['HTTP_HOST'] . $path;
        return request()->domain() . $path;
    }
}