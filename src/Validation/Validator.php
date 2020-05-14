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
 * 表达那验证
 * Class Validator
 * @package JoyceZ\ThinkLib\Validation
 */
class Validator
{

    //验证火车车次
    const TRAIN_NUMBER_REGEX = '/^[GCDZTSPKXLY1-9]\d{1,4}$/';

    //验证网址(支持端口和"?+参数"和"#+参数)
    const WEBSITE_FULL_REGEX = '/^(((ht|f)tps?):\/\/)?[\w-]+(\.[\w-]+)+([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?$/';

    //验证统一社会信用代码
    const SOCIETY_CREDIT_CODE_REGEX = '/^[0-9A-HJ-NPQRTUWXY]{2}\d{6}[0-9A-HJ-NPQRTUWXY]{10}$/';

    //验证linux文件夹路径
    const LINUX_FOLDER_PATH_REGEX = '/^\/(?:[^/]+\/)*$/';

    //验证linux文件路径
    const LINUX_FILE_PATH_REGEX = '/^\/(?:[^/]+\/)*[^/]+$/';

    //验证window下"文件"路径
    const WINDOWS_FILE_PATH_REGEX = '/^[a-zA-Z]:\\(?:\w+\\)*\w+\.\w+$/';

    //验证视频链接地址（视频格式可按需增删）
    const VIDEO_URL_REGEX = '/^https?:\/\/(.+\/)+.+(\.(swf|avi|flv|mpg|rm|mov|wav|asf|3gp|mkv|rmvb|mp4))$/i';

    //验证图片链接地址（图片格式可按需增删）
    const IMAGES_URL_REGEX = '/^https?:\/\/(.+\/)+.+(\.(gif|png|jpg|jpeg|webp|svg|psd|bmp|tif))$/i';

    //验证数字/货币金额（支持负数、千分位分隔符）
    const MONEY_ALL_REGEX = '/^-?\d+(,\d{3})*(\.\d{1,2})?$/';

    // 验证数字/货币金额 (只支持正数、不支持校验千分位分隔符)
    const MONEY_REGEX = '/(?:^[1-9]([0-9]+)?(?:\.[0-9]{1,2})?$)|(?:^(?:0){1}$)|(?:^[0-9]\.[0-9](?:[0-9])?$)/';

    //验证银行卡号（10到30位, 覆盖对公/私账户, 参考微信支付）
    const BANK_CARD_NUMBER_REGEX = '/^[1-9]\d{9,29}$/';

    //验证中文姓名
    const CHINESE_NAME_REGEX = '/^(?:[\u4e00-\u9fa5]{2,16})$/';

    //验证英文姓名
    const ENGLISH_NAME_REGEX = '/(^[a-zA-Z]{1}[a-zA-Z\s]{0,20}[a-zA-Z]{1}$)/';

    //验证车牌号(新能源)
    const LICENSE_PLATE_NUMBER_NER_REGEX = '/[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领 A-Z]{1}[A-HJ-NP-Z]{1}(([0-9]{5}[DF])|([DF][A-HJ-NP-Z0-9][0-9]{4}))$/';

    //验证车牌号(非新能源)
    const LICENSE_PLATE_NUMBER_NNER_REGEX = '/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领 A-Z]{1}[A-HJ-NP-Z]{1}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/';

    //验证车牌号(新能源+非新能源)
    const LICENSE_PLATE_NUMBER_REGEX = '/^(?:[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领 A-Z]{1}[A-HJ-NP-Z]{1}(?:(?:[0-9]{5}[DF])|(?:[DF](?:[A-HJ-NP-Z0-9])[0-9]{4})))|(?:[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领 A-Z]{1}[A-Z]{1}[A-HJ-NP-Z0-9]{4}[A-HJ-NP-Z0-9 挂学警港澳]{1})$/';

    //验证手机号中国(宽松), 只要是13,14,15,16,17,18,19开头即可
    const MOBILE_RELAXED_REGEX = '/^(?:(?:\+|00)86)?1[3-9]\d{9}$/';

    //验证手机号中国(严谨), 根据工信部2019年最新公布的手机号段
    const MOBILE_STRICT_REGEX = '/^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-7|9])|(?:5[0-3|5-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[1|8|9]))\d{8}$/';

    //验证手机号中国(最宽松), 只要是1开头即可, 如果你的手机号是用来接收短信, 优先建议选择这一条
    const MOBILE_MOST_RELAXED_REGEX = '/^(?:(?:\+|00)86)?1\d{10}$/';

    //验证手机号，不加+86
    const MOBILE_REGEX = '/^1[345789][0-9]{9}$/';

    //验证日期，例：2020-04-05
    const DATE_REGEX = '/^\d{4}(-)(1[0-2]|0?\d)\1([0-2]\d|\d|30|31)$/';

    //验证email(邮箱)
    const EMAIL_REGEX = '/^[a-zA-Z0-9.!#$%&\'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';

    //验证座机电话(国内),如: 0591-88888888
    const LAND_LINE_TELEPHONE_REGEX = '/\d{3}-\d{8}|\d{4}-\d{7}/';

    //验证身份证号(1代,15位数字)
    const ID_CARD_OLD_REGEX = '/^\d{8}(0\d|10|11|12)([0-2]\d|30|31)\d{3}$/';

    //验证身份证号(2代,18位数字),最后一位是校验位,可能为数字或字符X
    const ID_CARD_NEW_REGEX = '/^\d{6}(18|19|20)\d{2}(0\d|10|11|12)([0-2]\d|30|31)\d{3}[\dXx]$/';

    //身份证号, 支持1/2代(15位/18位数字)
    const ID_CARD_REGEX = '/(^\d{8}(0\d|10|11|12)([0-2]\d|30|31)\d{3}$)|(^\d{6}(18|19|20)\d{2}(0\d|10|11|12)([0-2]\d|30|31)\d{3}(\d|X|x)$)/';

    //验证护照（包含香港、澳门）
    const PASSPORT_REGEX = '/(^[EeKkGgDdSsPpHh]\d{8}$)|(^(([Ee][a-fA-F])|([DdSsPp][Ee])|([Kk][Jj])|([Mm][Aa])|(1[45]))\d{7}$)/';

    // 验证帐号是否合法(字母开头，允许5-16字节，允许字母数字下划线组合
    const WEB_ACCOUNT_NUMBER_REGEX = '/^[a-zA-Z]\w{4,15}$/';

    // 验证中文/汉字
    const CHINESE_CHARACTER_REGEX = '/^(?:[\u3400-\u4DB5\u4E00-\u9FEA\uFA0E\uFA0F\uFA11\uFA13\uFA14\uFA1F\uFA21\uFA23\uFA24\uFA27-\uFA29]|[\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879][\uDC00-\uDFFF]|\uD869[\uDC00-\uDED6\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF34\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0])+$/';

    //验证小数
    const DECIMAL_REGEX = '/^\d+\.\d+$/';

    //验证数字
    const NUMBER_REGEX = '/^\d{1,}$/';

    // 验证html标签(宽松匹配)
    const HTML_TAGS_REGEX = '/<(\w+)[^>]*>(.*?<\/\1>)?/';

    //验证数字和字母组成
    const NUMBER_STRING_REGEX = '/^[A-Za-z0-9]+$/';

    //验证数字的id组
    const VALID_TAGS_IDS = "/([0-9]+){1,}/";

    /**
     * 验证火车车次
     * @param string $value
     * @return bool
     */
    public static function isTrainNumber(string $value)
    {
        return 0 < preg_match(self::TRAIN_NUMBER_REGEX, $value);
    }

    /**
     * 验证网址(支持端口和"?+参数"和"#+参数)
     * @param string $value
     * @return bool
     */
    public static function isRightWebsite(string $value)
    {
        return 0 < preg_match(self::WEBSITE_FULL_REGEX, $value);
    }

    /**
     * 验证统一社会信用代码
     * @param string $value
     * @return bool
     */
    public static function isSocietyCreditCode(string $value)
    {
        return 0 < preg_match(self::SOCIETY_CREDIT_CODE_REGEX, $value);
    }

    /**
     * 验证某个字段的值是否为纯数字（采用ctype_digit验证，不包含负数和小数点）
     * @param $value
     * @return bool
     */
    public static function isPositiveInteger($value)
    {
        return ctype_digit($value);
    }

    /**
     * 验证linux文件夹路径
     * @param string $value
     * @return bool
     */
    public static function isLinuxFolderPath(string $value)
    {
        return 0 < preg_match(self::LINUX_FOLDER_PATH_REGEX, $value);
    }

    /**
     * 验证linux文件路径
     * @param string $value
     * @return bool
     */
    public static function isLinuxFilePath(string $value)
    {
        return 0 < preg_match(self::LINUX_FILE_PATH_REGEX, $value);
    }

    /**
     * 验证window下"文件"路径
     * @param string $value
     * @return bool
     */
    public static function isWindowsFilePath(string $value)
    {
        return 0 < preg_match(self::WINDOWS_FILE_PATH_REGEX, $value);
    }

    /**
     * 验证视频链接地址（视频格式可按需增删）
     * @param string $value
     * @return bool
     */
    public static function isVideoUrl(string $value)
    {
        return 0 < preg_match(self::VIDEO_URL_REGEX, $value);
    }

    /**
     * 验证图片链接地址（图片格式可按需增删）
     * @param string $value
     * @return bool
     */
    public static function isImageUrl(string $value)
    {
        return 0 < preg_match(self::IMAGES_URL_REGEX, $value);
    }

    /**
     * 验证数字/货币金额（支持负数、千分位分隔符）
     * @param $value
     * @return bool
     */
    public static function isMoneyAll($value)
    {
        return 0 < preg_match(self::MONEY_ALL_REGEX, $value);
    }

    /**
     * 验证数字/货币金额 (只支持正数、不支持校验千分位分隔符)
     * @param $value
     * @return bool
     */
    public static function isMoney($value)
    {
        return 0 < preg_match(self::MONEY_REGEX, $value);
    }

    /**
     * 验证银行卡号（10到30位, 覆盖对公/私账户, 参考微信支付）
     * @param string $value
     * @return bool
     */
    public static function isBankCardNumber(string $value)
    {
        return 0 < preg_match(self::BANK_CARD_NUMBER_REGEX, $value);
    }

    /**
     * 验证中文姓名
     * @param string $value
     * @return bool
     */
    public static function isChineseName(string $value)
    {
        return 0 < preg_match(self::CHINESE_NAME_REGEX, $value);
    }

    /**
     * 验证英文姓名
     * @param string $value
     * @return bool
     */
    public static function isEnglishName(string $value)
    {
        return 0 < preg_match(self::ENGLISH_NAME_REGEX, $value);
    }

    /**
     * 验证车牌号(新能源)
     * @param string $value
     * @return bool
     */
    public static function isLicensePlateNumberNER(string $value)
    {
        return 0 < preg_match(self::LICENSE_PLATE_NUMBER_NER_REGEX, $value);
    }

    /**
     * 验证车牌号(非新能源)
     * @param string $value
     * @return bool
     */
    public static function isLicensePlateNumberNNER(string $value)
    {
        return 0 < preg_match(self::LICENSE_PLATE_NUMBER_NNER_REGEX, $value);
    }

    /**
     * 验证车牌号(新能源+非新能源)
     * @param string $value
     * @return bool
     */
    public static function isLicensePlateNumber(string $value)
    {
        return 0 < preg_match(self::LICENSE_PLATE_NUMBER_REGEX, $value);
    }

    /**
     * 验证手机号中国(严谨), 根据工信部2019年最新公布的手机号段
     * @param string $value
     * @return bool
     */
    public static function isMobileStrict(string $value)
    {
        return 0 < preg_match(self::MOBILE_STRICT_REGEX, $value);
    }

    /**
     * 验证手机号中国(宽松), 只要是13,14,15,16,17,18,19开头即可
     * @param string $value
     * @return bool
     */
    public static function isMobileRelaxed(string $value)
    {
        return 0 < preg_match(self::MOBILE_RELAXED_REGEX, $value);
    }

    /**
     * 验证手机号中国(最宽松), 只要是1开头即可, 如果你的手机号是用来接收短信, 优先建议选择这一条
     * @param string $value
     * @return bool
     */
    public static function isMobileMostRelaxed(string $value)
    {
        return 0 < preg_match(self::MOBILE_MOST_RELAXED_REGEX, $value);
    }

    /**
     * 验证手机号，不验证+86
     * @param string $value
     * @return bool
     */
    public static function isMobile(string $value)
    {
        return 0 < preg_match(self::MOBILE_REGEX, $value);
    }


    /**
     * 验证日期是否合法，例：2020-04-01
     * @param string $value
     * @return bool
     */
    public static function isDate(string $value)
    {
        return 0 < preg_match(self::DATE_REGEX, $value);
    }

    /**
     * 验证邮箱地址
     * @param string $value
     * @return bool
     */
    public static function isEmail(string $value)
    {
        return 0 < preg_match(self::EMAIL_REGEX, $value);
    }

    /**
     * 验证座机电话(国内),如: 0591-88888888
     * @param string $value
     * @return bool
     */
    public static function isLandLineTelephone(string $value)
    {
        return 0 < preg_match(self::LAND_LINE_TELEPHONE_REGEX, $value);
    }

    /**
     * 验证身份证号(1代,15位数字)
     * @param string $value
     * @return bool
     */
    public static function isIDCardOld(string $value)
    {
        return 0 < preg_match(self::ID_CARD_OLD_REGEX, $value);
    }

    /**
     * 验证身份证号(2代,18位数字),最后一位是校验位,可能为数字或字符X
     * @param string $value
     * @return bool
     */
    public static function isIDCardNew(string $value)
    {
        return 0 < preg_match(self::ID_CARD_NEW_REGEX, $value);
    }

    /**
     * 身份证号, 支持1/2代(15位/18位数字)
     * @param string $value
     * @return bool
     */
    public static function isIDCard(string $value)
    {
        return 0 < preg_match(self::ID_CARD_REGEX, $value);
    }

    /**
     * 验证护照（包含香港、澳门）
     * @param string $value
     * @return bool
     */
    public static function isPassport(string $value)
    {
        return 0 < preg_match(self::PASSPORT_REGEX, $value);
    }

    /**
     * 验证帐号是否合法(字母开头，允许5-16字节，允许字母数字下划线组合
     * @param string $value
     * @return bool
     */
    public static function isWebAccount(string $value)
    {
        return 0 < preg_match(self::WEB_ACCOUNT_NUMBER_REGEX, $value);
    }

    /**
     * 验证中文/汉字
     * @param string $value
     * @return bool
     */
    public static function isChineseCharacter(string $value)
    {
        return 0 < preg_match(self::CHINESE_CHARACTER_REGEX, $value);
    }

    /**
     * 验证小数
     * @param $value
     * @return bool
     */
    public static function isDecimal($value)
    {
        return 0 < preg_match(self::DECIMAL_REGEX, $value);
    }

    /**
     * 验证数字
     * @param $value
     * @return bool
     */
    public static function isNumber($value)
    {
        return 0 < preg_match(self::NUMBER_REGEX, $value);
    }

    /**
     * 验证是否是正数
     *
     * @param int $number 需要被验证的数字
     * @return bool 如果数字大于0则返回true否则返回false
     */
    public static function isPositive($number)
    {
        return is_numeric($number) && 0 < $number;
    }

    /**
     * 验证是否是负数
     *
     * @param int $number 需要被验证的数字
     * @return bool 如果数字小于于0则返回true否则返回false
     */
    public static function isNegative($number)
    {
        return is_numeric($number) && 0 > $number;
    }

    /**
     * 验证是否是非负数
     *
     * @param int $number 需要被验证的数字
     * @return bool 如果大于等于0的整数数字返回true，否则返回false
     */
    public static function isNonNegative($number)
    {
        return is_numeric($number) && 0 <= $number;
    }

    /**
     * 验证是否是合法的客户端脚本
     *
     * @param string $string 待验证的字串
     * @return bool 如果是合法的客户端脚本则返回true，否则返回false
     */
    public static function isScript(string $string)
    {
        return 0 < preg_match('/<script(?:.*?)>(?:[^\x00]*?)<\/script>/', $string);
    }

    /**
     *  验证html标签(宽松匹配)
     * @param string $value
     * @return bool
     */
    public static function isHtmlTags(string $value)
    {
        return 0 < preg_match(self::HTML_TAGS_REGEX, $value);
    }

}