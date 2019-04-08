<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\Renderer\Exception\MissingTemplateException;
use Phauthentic\Presentation\View\ViewInterface;

/**
 * AbstractBaseRenderer
 */
abstract class AbstractBaseRenderer implements RendererInterface
{
    /**
     * Root folder for the template files
     *
     * @var string
     */
    protected $templateRoot = '';

    /**
     * Template Folders
     *
     * @var array
     */
    protected $templateFolders = [];

    /**
     * Template file extension
     *
     * @var string
     */
    protected $extension = 'php';

    /**
     * Constructor
     *
     * @var string $templateRoot
     */
    public function __construct(string $templateRoot)
    {
        $this->templateRoot = $templateRoot;
    }

    /**
     * @inheritDoc
     */
    public function setTemplateRoot(string $root): self
    {
        $this->templateRoot = $root;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTemplateExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Gets the template extension
     *
     * @return string
     */
    public function getTemplateExtension(): string
    {
        return $this->extension;
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
     * Gets the template file from the view DTO object
     *
     * @param \Phauthentic\Presentation\View\ViewInterface
     * @return string
     */
    public function getTemplateFile(ViewInterface $view): string
    {
        $path = $view->getTemplatePath();
        $path = $this->sanitizePath($path);

        $template = $this->templateRoot . DIRECTORY_SEPARATOR . $path . $view->getTemplate() . '.' . $this->extension;

        if (!is_file($template)) {
            throw new MissingTemplateException('Template file missing: ' . $template);
        }

        return $template;
    }

    /**
     * Renders something
     *
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @return string
     */
    abstract public function render(ViewInterface $view): string;
}
