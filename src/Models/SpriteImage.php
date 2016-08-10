<?php

/**
 * This software package is licensed under `AGPL, Commercial` license[s].
 *
 * @package maslosoft/sprite
 * @license AGPL, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Sprite\Models;

use ArrayAccess;
use Maslosoft\Sprite\Interfaces\SpritePackageInterface;
use Symfony\Component\Finder\SplFileInfo;
use UnexpectedValueException;

/**
 * SpriteImage
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SpriteImage implements ArrayAccess
{

	/**
	 * Base path for image
	 * @var string
	 */
	public $basePath = '';

	/**
	 * Relative path to image, base for css class name
	 * @var SplFileInfo
	 */
	public $info = '';

	/**
	 * Full path to file
	 * @var string
	 */
	public $path = '';

	/**
	 * File size in bytes
	 * @var int
	 */
	public $size = 0;

	/**
	 * Width in pixels
	 * @var int
	 */
	public $width = 0;

	/**
	 * Height in pixels
	 * @var int
	 */
	public $height = 0;

	/**
	 * Mime type
	 * @var string
	 */
	public $mime = '';

	/**
	 * Image type based on mime data
	 * @var string
	 */
	public $type = '';

	/**
	 * CSS sprite name
	 * @var string
	 */
	public $name = '';

	/**
	 * Image checksum
	 * @var string
	 */
	public $hash = '';

	/**
	 * Packages, to which this sprite belongs
	 * @var SpritePackageInterface[]
	 */
	public $packages = [];

	/**
	 * Create sprite image data holder
	 * @param string $path
	 * @param SplFileInfo $fileInfo
	 */
	public function __construct($path, SplFileInfo $fileInfo)
	{
		$this->basePath = $path;
		$this->info = $fileInfo;

		// Assign fileinfo variables
		$this->path = $this->info->getPathname();
		$this->size = $this->info->getSize();

		// Assign image data
		$info = getimagesize($this->path);
		if (!is_array($info))
		{
			throw new UnexpectedValueException("The image '$this->path' is not a correct image format.");
		}
		$this->hash = sha1(file_get_contents($this->getFullPath()));
		$this->width = $info[0];
		$this->height = $info[1];
		$this->mime = $info['mime'];
		$this->type = explode('/', $this->mime)[1];

		// Assign css name
		$ext = $this->info->getExtension();

		// Replace path parts with `-`
		$name = str_replace(['/', '\\', '_'], '-', $this->info->getRelativePathname());

		// Remove leading `-`
		$name = preg_replace('~^-*~', '', $name);

		// Remove double dashes
		$name = preg_replace('~-+~', '-', $name);

		// Remove file extension
		$name = preg_replace("~\.$ext$~", '', $name);

		// Replace dots with -
		$name = preg_replace('~\.~', '-', $name);

		$this->name = $name;
	}

	/**
	 * Get full path to image
	 * @return string
	 */
	public function getFullPath()
	{
		return $this->info->getRealPath();
	}

// <editor-fold defaultstate="collapsed" desc="ArrayAccess implementation">

	/**
	 * Check if offset exists
	 * @param string $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->$offset);
	}

	/**
	 * Get offset value
	 * @param string $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->$offset;
	}

	/**
	 * Set offset value
	 * @param string $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->$offset = $value;
	}

	/**
	 * Unset offset value
	 * @param string $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->$offset);
	}

// </editor-fold>
}
