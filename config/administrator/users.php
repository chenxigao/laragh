<?php

use App\Models\User;

return [
    //页面标题
    'title'       => '用户',

    //模型单数，用作页面新建 $single
    'single'      => '用户',

    //数据模型，用作用户的  CRUD
    'model'       => User::class,

    //设置当前页面的访问权限，通过 返回布尔值来控制权限
    //返回 true 即表示通过权限验证，false 则表示无权限访问并从 menu中隐藏
    'permission'  => function () {
        return Auth::user()->can('manage_contents');
    },

    //字段负责渲染数据表格，由无数的列组成
    'columns'     => [
        //列的标识，这是一个最小化列信息配置的例子，读取是模型里对应的属性值，如：$model->id
        'id',
        'avatar' => [
            //数据表格里的名称，默认会使用列标识
            'title'    => '头像',

            //默认情况下，会直接 输出数据，你也可以用output选项来定制输出内容
            'output'   => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" width="40">';
            },

            //是否允许排序
            'sortable' => false,
        ],

        'name' => [
            'title'    => '用户名',
            'sortable' => false,
            'output'   => function ($name, $model) {
                return '<a href="/users/' . $model->id . '" target=_blank>' . $name . '</a>';
            },
        ],

        'email' => [
            'title' => '邮箱',
        ],

        'operation' => [
            'title'    => '管理',
            'sortable' => false,
        ],

    ],

    //模型表单设置项
    'edit_fields' => [
        'name'     => [
            'title' => '用户名',
        ],
        'email'    => [
            'title' => '邮箱',
        ],
        'password' => [
            'title' => '密码',

            //表单使用 input 类型password
            'type'  => 'password',
        ],
        'avatar'   => [
            'title'    => '用户头像',

            //设置表单条目的类型，默认的type类型是 input
            'type'     => 'image',

            //图片上传必须设置图片存放路径
            'location' => public_path() . '/uploads/images/avatars/',
        ],
        'roles'    => [
            'title'      => '用户角色',

            //指定的数据类型为关联模型
            'type'       => 'relationship',

            //关联模型的字段，用来做关联显示
            'name_field' => 'name',
        ],
    ],

    //数据过滤设置
    'filters'     => [
        'id' => [
            //过滤表单条目显示名称
            'title' => '用户 ID',
        ],

        'name'  => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => '邮箱',
        ],

    ],
];