<?php

namespace App\Support\Macros;

use Illuminate\Database\Eloquent\Builder;

/**
 * sql查询扩展配合工具
 */
class BuilderMacroSqlTools
{
    /**
     * 获取绑定参数预处理  支持用in查询
     * @param string $sql  //sql语句
     * @param array $bindings //绑定参数
     * @return array
     */
    public static function getInBindingsPreprocessing(string $sql, array $bindings): array
    {
        foreach ($bindings as $key => $value) {
            if (is_array($value)){
                $bindings_arr = [];
                foreach ($value as $k =>$v){
                    if(!empty($v)) {
                        $bindings_arr[$key.$k] = $v;
                    }
                }
                unset($bindings[$key]);
                # 1. 将绑定参数的值 重新赋值给bindings
                $bindings = array_merge($bindings,$bindings_arr);
                # 2. 将绑定参数 sql片段 替换到sql内
                $sql = str_replace($key,implode(',:',array_keys($bindings_arr)),$sql);
            }
        }
        return [$sql,$bindings];
    }
}
