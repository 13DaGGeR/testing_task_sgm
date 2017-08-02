<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
	'id' => 'basic',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'components' => [
		'request' => [
		   'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
			'cookieValidationKey' => 'zTXjfaM_1bbIZdnc1MNAcaszsW4fbHE8',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => false,
			'enableSession' => false,
			'loginUrl'=>null,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
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
		'db' => $db,
		#/*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => true,
			'rules' => [
				[
					'class'=>'yii\rest\UrlRule',
					'controller'=>['user'],
					'extraPatterns'=>['GET logout'=>'logout'],
				],
				[
					'class'=>'yii\rest\UrlRule',
					'controller'=>['project'],
					'extraPatterns'=>['GET by-user/<id>'=>'get-by-user'],
				],
				[
					'class'=>'yii\rest\UrlRule',
					'controller'=>['task'],
					'extraPatterns'=>[
						'GET my-tasks'=>'my-tasks',
						'PATCH assign/<id>'=>'assign',
					],
				],
			],
		], #*/
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
			// uncomment the following to add your IP if you are not connecting from localhost.
			//'allowedIPs' => ['127.0.0.1', '::1'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

return $config;
