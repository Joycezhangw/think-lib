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

namespace JoyceZ\ThinkLib\Helpers;

/**
 * 格式化数据返回
 * Class ResultHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class ResultHelper
{
    const CODE_SUCCESS = 200;//正确执行后的返回码
    const CODE_WARNING = -1;//逻辑警告，自定义 message 说明，请结合 Enum\ResultCodeEnum 后端结合使用

    /**
     * 逻辑层 返回 array 数据格式，在api中，要使用 tp6 中的 json() 函数转 json ，laravel 中api自动转json
     * @param string $msg 提示信息
     * @param int $code 状态码 200:一切都ok，-1：逻辑返回错误信息，其他状态码可再定制
     * @param array $data 返回数据
     * @return array
     */
    public static function returnFormat(string $msg = 'success', $code = self::CODE_SUCCESS, $data = []): array
    {
        list($ret['code'], $ret['message']) = [$code, trim($msg)];
        $ret['data'] = $data;
        return $ret;
    }
}