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
 * 工具类
 * Class Utils
 * @package JoyceZ\ThinkLib\Utility
 */
class Utils
{


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