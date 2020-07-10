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

namespace JoyceZ\ThinkLib\Repositories;


use JoyceZ\ThinkLib\Repositories\Interfaces\BaseInterface;
use think\Model;

/**
 * Repositories 设计模式，实现逻辑容器仓库接口
 * Class BaseRepository
 * @package JoyceZ\ThinkLib\Repositories
 */
abstract class BaseRepository implements BaseInterface
{
    /**
     * 当前仓库模型
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 根据条件，获取一条指定字段数据
     * @param array $columns
     * @param array $condition
     * @return array|mixed|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function first(array $condition, array $columns = ['*'])
    {
        return $this->model->where($condition)->field($columns)->find();
    }

    /**
     * 根据主键查询一条数据
     * @param int $id
     * @return array|mixed|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByPkId(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * 没有查找到数据，抛出异常
     * @param array $condition
     * @return array|mixed|\think\db\concern\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function findOneOrFail(array $condition)
    {
        return $this->model->where($condition)->findOrFail();
    }

    /**
     * 根据条件，获取全部数据
     *
     * @param array $condition 查询条件
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function all(array $condition = [], $columns = ['*'], string $orderBy = '', string $sortBy = 'asc')
    {
        $orderBy = $orderBy ?? $this->model->getPk();
        return $this->model->where($condition)->order($orderBy, $sortBy)->field($columns)->select();
    }


    /**
     * 根据主键id，删除一条数据
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        if (intval($id) <= 0) {
            return false;
        }
        return $this->model->destroy($id);
    }

    /**
     * 新增一条数据
     * @param array $attributes
     * @return mixed|Model
     */
    public function doCreate(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * 根据主键id，更新一条数据
     * @param array $attributes 要更新的字段
     * @param int $id 更新主键值
     * @return mixed|Model
     */
    public function doUpdateById(array $attributes, int $id)
    {
        $pkId = $this->model->getPk() ?? 'id';
        return $this->model->update($attributes, [$pkId => $id]);
    }

    /**
     * 分页查询，不支持链表查询
     * @param array $condition 查询条件
     * @param array $orderBy 多个字段的排序
     * @param array $columns 只查询某些字段
     * @param int $limit
     * @return mixed|\think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function paginate(array $condition = [], array $orderBy = [], array $columns = ['*'], $limit = 15)
    {
        return $this->model->field($columns)->where($condition)->order(['order', $orderBy])->paginate($limit);
    }

    /**
     * 根据主键修改某个字段的值
     * @param int $id 主键值
     * @param string $filedName 字段名
     * @param string $fieldValue 字段值
     * @return mixed|Model
     */
    public function doUpdateFieldById(int $id, string $filedName, string $fieldValue)
    {
        $pkId = $this->model->getPk() ?? 'id';
        return $this->model->update([$filedName => $fieldValue])->where($pkId, $id);
    }

    /**
     * 根据条件，统计数量
     * @param array $condition
     * @param string $pkId
     * @return int|mixed
     */
    public function count(array $condition = [], string $pkId = '')
    {
        $pkField = $pkId == '' ? $this->model->getPk() : $pkId;
        return $this->model->where($condition)->count($pkField);
    }
}