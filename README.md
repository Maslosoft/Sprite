MSprite
=======

Icon sprite generator

Install with composer:

~~~sh
composer require "maslosoft/sprite:*"
~~~

Configure it:

~~~php
	 // application components
	 'components' => [
	 ...
		  'sprite' => [
				'class' => Maslosoft\Sprite\Generator::class,
				'cssIconClass' => 'icon',
				'imageFolderPath' => [
					 realpath(dirname(__FILE__) . '/../../www/css/icons')
				]
		  ],
		...
~~~
