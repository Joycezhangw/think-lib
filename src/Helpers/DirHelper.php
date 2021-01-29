<?php
// +----------------------------------------------------------------------
// | 通用类包
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.hmall.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: joyecZhang <zhangwei762@163.com>
// +----------------------------------------------------------------------

namespace JoyceZ\ThinkLib\Helpers;

/**
 * 目录操作工具助手
 * Class DirHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class DirHelper
{
    /**
     * 将路径 \ 转化为 /
     * @param string $path 路径
     * @return string|string[]
     */
    public static function dirPath(string $path)
    {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }

    /**
     * 创建目录
     * @param string $path 路径
     * @param int $mode 权限
     * @return bool
     */
    public static function dirCreate(string $path, $mode = 0777)
    {
        if (is_dir($path)) return true;
        $path = static::dirPath($path);
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for ($i = 0; $i < $max; $i++) {
            $cur_dir .= $temp[$i] . '/';
            if (@is_dir($cur_dir)) continue;
            @mkdir($cur_dir, $mode, true);
            @chmod($cur_dir, $mode);
        }
        return is_dir($path);
    }

    /**
     * 拷贝目录及下面所有文件
     * @param string $from_dir 原路径
     * @param string $to_dir 目标路径
     * @return bool 如果目标路径不存在则返回false，否则为true
     */
    public static function dirCopy(string $from_dir, string $to_dir)
    {
        $from_dir = static::dirPath($from_dir);
        $to_dir = static::dirPath($to_dir);
        if (!is_dir($from_dir)) return false;
        if (!is_dir($to_dir)) static::dirCreate($to_dir);
        $list = glob($from_dir . '*');
        if (!empty($list)) {
            foreach ($list as $item) {
                $path = $to_dir . basename($item);
                if (is_dir($item)) {
                    static::dirCopy($item, $path);
                } else {
                    copy($item, $path);
                    @chmod($path, 0777);
                }
            }
        }
        return true;
    }

    /**
     * 删除目录及目录下面的所有文件
     * @param string $path 路径
     * @return bool 如果成功则返回 true，失败则返回 false
     */
    public static function dirDelete(string $path)
    {
        $path = static::dirPath($path);
        if (!is_dir($path)) return false;
        $list = glob($path . '*');
        foreach ($list as $item) {
            is_dir($item) ? static::dirDelete($item) : @unlink($item);
        }
        return @rmdir($path);
    }

}