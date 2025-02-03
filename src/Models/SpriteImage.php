<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/sprite
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @copyright Copyright (c) Others as mentioned in code
 * @link http://maslosoft.com/sprite/
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
	public string $basePath = '';

	/**
	 * Relative path to image, base for css class name
	 * @var SplFileInfo
	 */
	public SplFileInfo $info;

	/**
	 * Full path to file
	 * @var string
	 */
	public string $path = '';

	/**
	 * File size in bytes
	 * @var int
	 */
	public int $size = 0;

	/**
	 * Width in pixels
	 * @var int
	 */
	public int $width = 0;

	/**
	 * Height in pixels
	 * @var int
	 */
	public int $height = 0;

	/**
	 * Mime type
	 * @var string
	 */
	public string $mime = '';

	/**
	 * Image type based on mime data
	 * @var string
	 */
	public string $type = '';

	/**
	 * CSS sprite name
	 * @var string
	 */
	public string $name = '';

	/**
	 * Image checksum
	 * @var string
	 */
	public string $hash = '';

	/**
	 * Packages, to which this sprite belongs
	 * @var SpritePackageInterface[]
	 */
	public array $packages = [];

	/**
	 * Create sprite image data holder
	 * @param string      $path
	 * @param SplFileInfo $fileInfo
	 */
	public function __construct(string $path, SplFileInfo $fileInfo)
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
		$this->width = (int) $info[0];
		$this->height = (int) $info[1];
		$this->mime = $info['mime'];
		$this->type = explode('/', $this->mime)[1];

		// Assign css name
		$ext = $this->info->getExtension();

		// Replace path parts with `-`
		$name = str_replace(['/', '\\', '_'], '-', $this->info->getRelativePathname());

		// Remove leading `-`
		$name = ltrim($name, '-');

		// Remove double dashes
		$name = preg_replace('~-+~', '-', $name);

		// Remove file extension
		$name = preg_replace("~\.$ext$~", '', $name);

		// Replace dots with -
		$name = str_replace(".", '-', $name);

		$this->name = $name;
	}

	public function isSquare(): bool
	{
		return $this->width === $this->height;
	}

	/**
	 * Get full path to image
	 * @return string
	 */
	public function getFullPath(): string
	{
		return $this->info->getRealPath();
	}

// <editor-fold defaultstate="collapsed" desc="ArrayAccess implementation">

	/**
	 * Check if offset exists
	 * @param string $offset
	 * @return bool
	 */
	public function offsetExists($offset): bool
	{
		return isset($this->$offset);
	}

	/**
	 * Get offset value
	 * @param string $offset
	 * @return mixed
	 */
	public function offsetGet($offset): mixed
	{
		return $this->$offset;
	}

	/**
	 * Set offset value
	 * @param string $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value): void
	{
		$this->$offset = $value;
	}

	/**
	 * Unset offset value
	 * @param string $offset
	 */
	public function offsetUnset($offset): void
	{
		unset($this->$offset);
	}

// </editor-fold>
}
