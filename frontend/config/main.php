<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;dbname=yii2advanced',
            'username' => 'root',
            'password' => 'root',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            // ИЗМЕНЕНО, ЧТОБЫ У USER БЫЛА СОБСТВЕННАЯ МОДЕЛЬ НА frontend\models\User
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/user/signup' => '/user/default/signup',
                '/user/login' => '/user/default/login',
                'profile/edit' => 'user/profile/edit',
                'profile/view/<id:\d+>' => 'user/profile/view',
                'vacancy/view/<id:\d+>' => 'vacancy/view',
                'vacancy/<page:\d+>' => 'vacancy/index',
                'vacancy/' => 'post/index',
                'resume/view/<id:\d+>' => 'resume/view',
                'resume/<page:\d+>' => 'resume/index',
                'resume/' => 'post/index',
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        
    ],
    'params' => $params,
];
