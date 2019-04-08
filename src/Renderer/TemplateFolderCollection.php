<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\Renderer\Exception\MissingTemplateFolderException;
use ArrayIterator;
use Phauthentic\Presentation\Renderer\Exception\MissingTemplateException;
use Phauthentic\Presentation\View\ViewInterface;
use IteratorAggregate;
use Traversable;

/**
 * AbstractBaseRenderer
 */
class TemplateFolderCollection implements IteratorAggregate
{
    /**
     * Folders
     *
     * @var array
     */
    protected $folders = [];

    /**
     * Constructor
     *
     * @param array $folders Folders
     */
    public function __construct(array $folders)
    {
        foreach ($folders as $folder) {
            $this->add($folder);
        }
    }

    /**
     * Adds a folder
     *
     * @param string $folder Folder
     * @return $this
     */
    public function add(string $folder)
    {
        $folder = $this->sanitizePath($folder);

        if (!is_dir($folder)) {
            throw new MissingTemplateFolderException(sprintf(
                'The folder %s does not exist or is not a folder',
                $folder
            ));
        }

        $this->folders[] = $folder;
    }

    /**
     * Sanitizes the template path
     *
     * @param string $path
     * @return string
     */
    public function sanitizePath(string $path): string
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            $path = str_replace('/', '\\', $path);
        } else {
            $path = str_replace('\\', '/', $path);
        }

        if (substr($path, 0, -1) !== '\\') {
            $path .= '\\';
        }

        return $path;
    }

    /**
     * Retrieve an external iterator
     *
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->folders);
    }
}
