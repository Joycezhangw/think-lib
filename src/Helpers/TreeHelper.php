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
 * 操作树节点
 * Class TreeHelper
 * @package JoyceZ\ThinkLib\Helpers
 */
class TreeHelper
{
    /**
     * 得到子级数组
     * @param array $list 原始一维数组
     * @param int $primaryValue 主键id值
     * @param string $primaryKey 主键名
     * @param string $parentName 父级主键名
     * @return array
     */
    public static function getChild(array $list, int $primaryValue, string $primaryKey = 'id', string $parentName = 'pid')
    {
        $newarr = [];
        foreach ($list as $value) {
            if (!isset($value[$primaryKey])) {
                continue;
            }
            if ($value[$parentName] == $primaryValue) {
                $newarr[$value[$primaryKey]] = $value;
            }
        }
        return $newarr;
    }

    /**
     * 读取指定节点的所有孩子节点
     * @param int $myid 节点ID
     * @param boolean $withself 是否包含自身
     * @return array
     */
    public static function getChildren(array $list, int $primaryValue, string $primaryKey = 'id', string $parentName = 'pid', $withself = false)
    {
        $newarr = [];
        foreach ($list as $value) {
            if (!isset($value[$primaryKey])) {
                continue;
            }
            if ($value[$parentName] == $primaryValue) {
                $newarr[] = $value;
                $newarr = array_merge($newarr, self::getChildren($list, $value[$primaryKey], $primaryKey, $parentName, $withself));
            } elseif ($withself && $value[$primaryKey] == $primaryValue) {
                $newarr[] = $value;
            }
        }
        return $newarr;
    }

    /**
     * 获取指定节点的父级数组
     * @param array $list 原始一维数组
     * @param int $primaryValue 主键id值
     * @param string $primaryKey 主键名
     * @param string $parentName 父级主键名
     * @return array
     */
    public static function getParent(array $list, int $primaryValue, string $primaryKey = 'id', string $parentName = 'pid')
    {
        $pid = 0;
        $newarr = [];
        foreach ($list as $value) {
            if (!isset($value[$primaryKey])) {
                continue;
            }
            if ($value[$primaryKey] == $primaryValue) {
                $pid = $value[$parentName];
                break;
            }
        }
        if ($pid) {
            foreach ($list as $value) {
                if ($value[$primaryKey] == $pid) {
                    $newarr[] = $value;
                    break;
                }
            }
        }
        return $newarr;
    }

    /**
     * 获取分类id所有父级分类
     * @param array $list 2维数组
     * @param int $primaryValue 指定id
     * @param string $primaryKey 主键标识
     * @param string $parentName 父类数组
     * @return array
     */
    public static function getParents(array $list, int $primaryValue, string $primaryKey = 'id', string $parentName = 'pid'): array
    {
        $parentid = 0;
        $newarr = [];
        foreach ($list as $value) {
            if (!isset($value[$primaryKey])) {
                continue;
            }
            if ($value[$primaryKey] == $primaryValue) {
                $newarr[] = $value;
                $parentid = $value[$parentName];
                break;
            }
        }
        if ($parentid) {
            $arr = self::getParents($list, $parentid, $primaryKey, $parentName);
            $newarr = array_merge($arr, $newarr);
        }
        return $newarr;
    }


    /**
     * 根据指定节点id值获取所有父级数组的id
     * @param array $list
     * @param int $primaryValue
     * @param string $primaryKey
     * @param string $parentName
     * @return array
     */
    public static function getParentsId(array $list, int $primaryValue, string $primaryKey = 'id', string $parentName = 'pid'): array
    {
        $parentlist = self::getParents($list, $primaryValue, $primaryKey, $parentName);
        $parentsids = [];
        foreach ($parentlist as $k => $v) {
            $parentsids[] = $v[$primaryKey];
        }
        return $parentsids;
    }

    /**
     * 格式化分类，生成一维数组 ,根据path 属性
     * @param array $list 数组
     * @param int $root 指定根节点
     * @param string $prefix 前缀标识
     * @param string $pk 主键标识
     * @param string $pid 父级标识
     * @param string $html 前缀字符
     * @return array
     */
    public static function listToTreeOne(array $list, int $root = 0, string $prefix = '', string $pk = 'id', string $pid = 'pid', string $html = 'html'): array
    {
        $tree = array();
        foreach ($list as $v) {
            if ($v[$pid] == $root) {
                if ($v[$pid] == 0) {
                    $level = 0;
                } else {
                    $level = count(self::getParentsId($list, $v[$pk], $pk, $pid));
                }

                $v[$html] = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $level);
                $v[$html] = $v[$html] ? ($v[$html] . $prefix) : $v[$html];
                $tree[] = $v;
                $level++;
                $tree = array_merge($tree, self::listToTreeOne($list, $v[$pk], $prefix, $pk, $pid, $html));
            }
        }
        return $tree;
    }

    /**
     * 格式化分类--生成多维数组 ，子数组放在child 属性中
     * @param array $list 数组
     * @param int $root 指定根节点
     * @param string $pk 主键标识
     * @param string $pid 父级标识
     * @param string $child 子级标识
     * @return array
     */
    public static function listToTreeMulti(array $list, int $root = 0, string $pk = 'id', string $pid = 'pid', string $child = 'children'): array
    {
        $tree = array();
        foreach ($list as $v) {
            if ($v[$pid] == $root) {
                $v[$child] = self::listToTreeMulti($list, $v[$pk], $pk, $pid, $child);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 格式化分类，生成多维数组的树
     * @param array $list 数组
     * @param int $root 指定根节点
     * @param string $pk 主键标识
     * @param string $pid 父级标识
     * @param string $child 子级标识
     * @return array
     */
    public static function listToTree(array $list, $root = 0, $pk = 'id', $pid = 'pid', $child = 'children'): array
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}