Maslosoft Sprite
=======

Icon sprite generator

Install with composer:

~~~
composer require maslosoft/sprite
~~~

Yii Config:

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
