Maslosoft Sprite
=======

Icon sprite generator

Install with composer:

~~~sh
composer require "maslosoft/sprite:*"
~~~

When using with Yii can be configured like that:

~~~php
	 // application components
	 'components' => [
	 ...
		  'sprite' => [
				'class' => Maslosoft\Sprite\Generator::class,
				'iconCssClass' => 'icon',
				'paths' => [
					 realpath(dirname(__FILE__) . '/../../www/css/icons')
				]
		  ],
		...
~~~
