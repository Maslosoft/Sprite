MSprite
=======

Icon sprite generator

Install with composer:

~~~
composer require maslosoft/m-sprite dev-master
~~~

Configure it:

~~~php
	 // application components
	 'components' => [
	 ...
		  'sprite' => [
				'class' => 'vendor.maslosoft.m-sprite.MSprite',
				'cssIconClass' => 'icon',
				'imageFolderPath' => [
					 realpath(dirname(__FILE__) . '/../../www/css/icons')
				]
		  ],
		...
~~~
