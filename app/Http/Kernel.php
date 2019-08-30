<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        //检查应用是否进入 维护模式
        // 见：https://learnku.com/docs/laravel/5.7/configuration#maintenance-mode
        \App\Http\Middleware\CheckForMaintenanceMode::class,

        //检查表单数据量是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        //对提交的请求参数进行 PHP 函数 trim（）处理
        \App\Http\Middleware\TrimStrings::class,

        //将参数中空字串转换为null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        //修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *中间件组，应用于 routes/web.php 路由文件中
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            //cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,

            //将cookie添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            //开启会话
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            //将系统的错误数据注册到视图变量 $error 中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            //检验 CSRF ，防止跨站请求伪造
            \App\Http\Middleware\VerifyCsrfToken::class,

            //处理路由绑定
            // 见：https://learnku.com/docs/laravel/5.7/routing#route-model-binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            //强制用户邮箱验证
            \App\Http\Middleware\EnsureEmailVerified::class,

            //记录用户最后活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class,
        ],

        //API 中间件组，应用于 route/api.php 路由文件
        //在RouteServicesProvider 中定义
        'api' => [
            //使用别名来调用中间件，
            //请见：https://learnku.com/docs/laravel/5.7/middleware#为路由分配中间件
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *中间件别名设置，允许你使用别名调用中间件，例如上面的 api 中间件组调用
     * @var array
     */
    protected $routeMiddleware = [
        //只有登录用户才能访问，我们在控制器的构造方法中大量使用
        'auth' => \App\Http\Middleware\Authenticate::class,

        // HTTP Basic  Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        //处理路由绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        //用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        //只有游客才能访问，在 register 和 login 请求中使用，只有未登录用户才能访问的页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        //签名认证，在找回密码章节中讲过
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        //访问节流，类似于 1分钟允许访问 10 次的请求，一般在API 中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        //Laravel 自带的强制用户邮箱认证的中间件
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    //设定中间件优先级，此数组定义了除全局中间件以外的中间件执行顺序，
    //可以看到 StartSession 永远是最开始执行的，因为StartSession 后，
    //我们才能在程序中使用 Auth 等用户认证功能。
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
