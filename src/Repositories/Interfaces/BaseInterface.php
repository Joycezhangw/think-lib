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


namespace JoyceZ\ThinkLib\Repositories\Interfaces;

/**
 * Repositories 设计模式，逻辑容器仓库接口 
 * Interface BaseInterface
 * @package JoyceZ\ThinkLib\Repositories\Interfaces
 */
interface BaseInterface
{
    /**
     * 根据主键id获取单条数据
     * @param int $id 主键id
     * @return mixed
     */
    public function getByPkId(int $id);

    /**
     * 根据条件，获取一条指定字段数据
     * @param array $columns 查询字段
     * @param array $condition 查询条件
     * @return mixed
     */
    public function first(array $condition, array $columns = ['*']);


    /**
     * 没有查找到数据，抛出异常
     * @param array $condition
     * @return mixed
     */
    public function findOneOrFail(array $condition);

    /**
     * 获取全部数据
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    /**
     * 获取全部数据，不支持链表查询
     * @param array $condition 查询条件
     * @param array $columns 显示字段
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(array $condition = [], $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * 创建一条数据，不联表状态
     * @param array $attributes
     * @return mixed
     */
    public function doCreate(array $attributes);

    /**
     * 根据主键id，更新一条数据
     * @param array $attributes 要更新的字段
     * @param int $id 更新主键值
     * @return mixed
     */
    public function doUpdateById(array $attributes, int $id);

    /**
     * 根据主键删除id
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * 分页查询，不支持链表查询
     * @param array $condition 查询条件
     * @param array $orderBy 多个字段的排序
     * @param array $columns 只查询某些字段
     * @param int $limit 每页显示数量
     * @return mixed
     */
    public function paginate(array $condition = [], array $orderBy = [], array $columns = ['*'], $limit = 15);

    /**
     * 根据主键，更新某个字段，模型要指定主键名
     * @param int $id 主键id值
     * @param string $filedName 字段名称
     * @param string $fieldValue 字段值
     * @return mixed
     */
    public function doUpdateFieldById(int $id, string $filedName, string $fieldValue);

    /**
     * 统计数量
     * @param array $condition
     * @param string $pkId
     * @return mixed
     */
    public function count(array $condition = [], string $pkId = '');

}