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

namespace JoyceZ\ThinkLib\Http;


use JoyceZ\ThinkLib\Helpers\ResultHelper;
use think\Request;

class FormRequest extends Request
{
    /**
     *  批量验证
     *
     * @var bool
     */
    protected $batch = false;

    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();

//        $this->validate();
    }

    /**
     * 获取全部请求参数
     * @param null $keys
     * @return mixed
     */
    public function all($keys = null)
    {
        return $this->param($keys);
    }

    /**
     * 表单验证
     * @return array|bool|mixed
     */
    public function validate()
    {
        if (method_exists($this, 'rules')) {
            try {
                $validate = app('validate');
                // 批量验证
                if ($this->batch) {
                    $validate->batch($this->batch);
                }
                //自定义提示信息，如果没有message(),就按 rules 定义字段名称抛出错误提示信息，如果两者都没有，那么就抛出tp框架默认提示
                $validate->message($this->message());
                // 验证
                if (!$validate->check($this->param(), $this->rules())) {
                    return ResultHelper::returnFormat($validate->getError(), -1);
                }
            } catch (\Exception $e) {
                return ResultHelper::returnFormat($e->getMessage(), -1);
            }
        }
        return ResultHelper::returnFormat('success', 200);
    }
}