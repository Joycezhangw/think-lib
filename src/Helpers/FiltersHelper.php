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
 * 字符串过滤类
 * Class FiltersHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class FiltersHelper
{
    /**
     * 将图片中的相对路径换成绝对路径，在小程序中使用，将所有物理路径的图片转成url路径图片
     * @param string $html_content
     * @return string|string[]|null
     */
    static function richTextAbsoluteUrl($html_content = '')
    {

        $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
        $content = preg_replace($pregRule, '<img src="' . UrlHelper::asset('${1}') . '" style="max-width:100%;height:auto;display:block">', $html_content);

        return $content;
    }

    /**
     * 表单提交字符过滤
     * @param $string
     * @return string|string[]|null
     */
    static function stringFilter($string)
    {
        $regArr = array(
            "/\s+/", //过滤多余空白
            //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤
            "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU", //过滤javascript的on事件
        );
        $tarr = array(
            " ",
            " ", //如果要直接清除不安全的标签，这里可以留空
            " ",
        );
        $string = preg_replace($regArr, $tarr, $string);
        return $string;
    }

    /**
     * 过滤提交字符串，不含空格
     * @param string $string
     * @return string|string[]|null
     */
    static function stringSpecialHtmlFilter(string $string)
    {
        $regArr = array(
            //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤
            "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU", //过滤javascript的on事件
        );
        $tarr = array(
            " ", //如果要直接清除不安全的标签，这里可以留空
            " ",
        );
        $string = preg_replace($regArr, $tarr, $string);
        return $string;
    }

    /**
     * 友好显示学员运动积分排名
     * @param int $num
     * @return int|string
     */
    static function filterRank($num = 0)
    {
        if ($num >= 10000) {
            return round($num / 10000 * 100) / 100 . ' W';
        } elseif ($num >= 1000) {
            return round($num / 1000 * 100) / 100 . ' K';
        } else {
            return $num;
        }
    }


    /**
     * 过滤手机号中间几位数
     * @param $mobile
     * @return string
     */
    function filterMobile($mobile)
    {
        return substr($mobile, 0, 5) . "****" . substr($mobile, 9, 2);
    }

    /**
     * 将数组转为string 并带有引号
     * @param array $data
     * @return string
     */
    public static function arrayToString(array $data)
    {
        return "'" . join("','", $data) . "'";
    }

    /**
     * 将 [script|link|style] 标签过滤掉
     * @param $string
     * @return string|string[]|null
     */
    public static function replaceHTML(string $string)
    {
        $preg = "/<script[\s\S]*?<\/script>/i";
        $str = preg_replace($preg, "", $string);
        $preg = "/<link[\s\S]*?<\/link>/i";
        $str = preg_replace($preg, "", $string);
        $preg = "/<style[\s\S]*?<\/style>/i";
        $str = preg_replace($preg, "", $string);
        return $str;
    }

    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $str 字符串
     * @param int $head 左侧保留位数
     * @param int $foot 右侧保留位数
     * @return string 格式化后的string
     */
    public static function subStrCut(string $str, $head = 1, $foot = 1)
    {
        $strLen = mb_strlen($str, 'UTF-8');
        $firstStr = mb_substr($str, 0, $head, 'UTF-8');
        $lastStr = mb_substr($str, -$foot, $foot, 'UTF-8');
        return $strLen == 2 ? $firstStr . str_repeat('*', 3) : $firstStr . str_repeat("*", 3) . $lastStr;
    }

    /**
     * 生成图片url地址
     * @param string $img
     * @param string $default
     * @return string
     */
    public static function buildImageUri(string $img = '', string $default = '')
    {
        if (!empty ($img)) {
            if (preg_match('/(http:\/\/)|(https:\/\/)/i', $img)) {
                return $img; // 直接粘贴地址
            } else {
                return UrlHelper::asset($img);
            }
        } else {
            if (empty ($default)) {
                return UrlHelper::asset('/static/images/default-avatar.png');
            } else {
                if (preg_match('/(http:\/\/)|(https:\/\/)/i', $default)) {
                    return $default; // 直接粘贴地址
                } else {
                    return UrlHelper::asset($default);
                }
            }
        }
    }
}