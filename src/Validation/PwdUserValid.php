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

namespace JoyceZ\ThinkLib\Validation;

/**
 * 
 * Class PwdUserValid
 * @package JoyceZ\ThinkLib\Validation
 */
class PwdUserValid
{
    /**
     * 检测用户名的合法性
     * 匹配用户名只能含有数字、大小写字母、_
     * @param string $username
     * @return bool
     */
    public static function isUsernameHasIllegalChar(string $username)
    {
        return 0 < preg_match('/^[\dA-Za-z\_]+$/', $username);
    }

    /**
     * 检测用户名的合法性
     * 匹配用户名只能含有中文、数字、大小写字母
     * @param string $realName
     * @return bool
     */
    public static function isRealNameHasIllegalChar(string $realName)
    {
        return 0 < preg_match('/^[\x7f-\xff\dA-Za-z]+$/', $realName);
    }

    /**
     * 检测权限的合法性
     * 匹配权限ID只能由数组和英文逗号组成
     * @param string $str
     * @return bool
     */
    public static function isAuthsHasIllegalChar(string $str)
    {
        return 0 < preg_match('/^[\d,]+$/', $str);
    }

    /**
     * 检查用户的手机号码是否合法
     * @param string $mobile 用户手机
     * @return bool
     */
    public static function isMobileValid(string $mobile)
    {
        return 0 < preg_match('/^1\d{10}$/', $mobile);
    }

    /**
     * 验证密码的长度
     * @param string $password
     * @return bool
     */
    public static function checkPwdLength(string $password)
    {
        $pwdLen = strlen($password);
        if ($pwdLen < 6 || $pwdLen > 15) {
            return false;
        }
        return true;
    }

    /**
     * 判断密码是否符合以下标准
     * @param string $password
     * @return bool
     */
    public static function _complexCaculate(string $password)
    {
        $pwdLen = strlen($password);
        $complex = 0;
        $config = 15;
        for ($i = 0; $i < $pwdLen; $i++) {
            $ascii = ord($password[$i]);
            //必须含有小写字母 97-122
            if ($ascii >= 97 && $ascii <= 122) {
                if (0 == $complex || 1 != ($complex & 1)) $complex += 1;
                continue;
            }
            //必须含有大写字母 65-90
            if ($ascii >= 65 && $ascii <= 90) {
                if (0 == $complex || 2 != ($complex & 2)) $complex += 2;
                continue;
            }
            //必须含有数字 48-57
            if ($ascii >= 48 && $ascii <= 57) {
                if (0 == $complex || 4 != ($complex & 4)) $complex += 4;
                continue;
            }
            //必须含有符号 33-47/58-64/91-96/123-126
            if ((($ascii >= 33 && $ascii <= 47) || ($ascii >= 58 && $ascii <= 64) || ($ascii >= 91 && $ascii <= 96) || ($ascii >= 123 && $ascii <= 126))) {
                if (0 == $complex || 8 != ($complex & 8)) $complex += 8;
                continue;
            }
            //已经达到设置复杂度则跳出
            if ($config == $complex) break;
        }
        return $config != $complex;
    }

    /**
     * 判断获得密码强度
     *
     * @param string $pwd 密码强度
     * @return int 返回强度级别：(1：弱,2: 一般, 3： 强, 4：非常强)
     */
    public static function checkPwdStrong(string $pwd)
    {
        $array = array();
        $len = strlen($pwd);
        $i = 0;
        $mode = array('a' => 0, 'A' => 0, 'd' => 0, 'f' => 0);
        while ($i < $len) {
            $ascii = ord($pwd[$i]);
            if ($ascii >= 48 && $ascii <= 57) //数字
                $mode['d']++;
            elseif ($ascii >= 65 && $ascii <= 90) //大写字母
                $mode['A']++;
            elseif ($ascii >= 97 && $ascii <= 122) //小写
                $mode['a']++;
            else
                $mode['f']++;
            $i++;
        }
        /*全是小写字母或是大写字母或是字符*/
        if ($mode['a'] == $len || $mode['A'] == $len || $mode['f'] == $len) {
            return 2;
        }
        /*全是数字*/
        if ($mode['d'] == $len) {
            return 1;
        }

        $score = 0;
        /*大小写混合得分20分*/
        if ($mode['a'] > 0 && $mode['A'] > 0) {
            $score += 20;
        }
        /*如果含有3个以内（不包含0和3）数字得分10分,如果包括3个（含3个）以上得分20*/
        if ($mode['d'] > 0 && $mode['d'] < 3) {
            $score += 10;
        } elseif ($mode['d'] >= 3) {
            $score += 20;
        }
        /*如果含有一个字符得分10分，含有1个以上字符得分25*/
        if ($mode['f'] == 1) {
            $score += 10;
        } elseif ($mode['f'] > 1) {
            $score += 25;
        }
        /*同时含有：字母和数字 得25分；含有：字母、数字和符号 得30分；含有：大小写字母、数字和符号 得35分*/
        if ($mode['a'] > 0 && $mode['A'] > 0 && $mode['d'] > 0 && $mode['f'] > 0) {
            $score += 35;
        } elseif (($mode['a'] > 0 || $mode['A'] > 0) && $mode['d'] > 0 && $mode['f'] > 0) {
            $score += 30;
        } elseif (($mode['a'] > 0 || $mode['A'] > 0) && $mode['d'] > 0) {
            $score += 25;
        }
        if ($len < 3) $score -= 10;
        if ($score >= 60) {
            return 4;
        } elseif ($score >= 40) {
            return 3;
        } elseif ($score >= 20) {
            return 2;
        }
        return 1;
    }
}