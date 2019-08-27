<?php

use Spatie\Permission\Models\Role;

return [
    'title'  => '角色',
    'single' => '角色',
    'model'  => Role::class,

    'permissions' => function () {
        return Auth::user()->can('manage_users');
    },

    'columns' => [
        'id'         => [
            'title' => 'ID',
        ],
        'name'       => [
            'title' => '标识',
        ],
        'permission' => [
            'title'    => '权限',
            'output'   => function ($value, $model) {
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission) {
                    $result[] = $permission->name;
                }

                return empty($result) ? 'N/A' : implode($result, '|');
            },
            'sortable' => false,
        ],
        'operation'  => [
            'title'  => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
        ],
    ],

    'edit_fields' => [
        'name'       => [
            'title' => '标识',
        ],
        'permissions' => [
            'type'       => 'relationship',
            'title'      => '权限',
            'name_field' => 'name',
        ],
    ],

    'filters' => [
        'id'=>[
            'title'=>'ID',
        ],
        'name' =>[
            'title' => '标识',
        ],
    ],

    //新建编辑时的表单验证规则
    'rules' => [
        'name'=>'required|max:15|unique:roles,name',
    ],

    //表单验证错误时，定制错误消息
    'message'=>[
        'name.required'=>'标识不能为空',
        'name.unique'=>'标识已存在',
    ],


];
