<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

use Phauthentic\Presentation\View\Exception\ViewException;
use RuntimeException;

/**
 * View Data Transfer Object
 *
 * A Data Transfer Object that is passed from the application layer to a
 * renderer to render something.
 */
class View implements ViewInterface
{
    /**
     * View vars
     *
     * @var array
     */
    protected $viewVars = [];

    /**
     * Template Path
     *
     * @var string
     */
    protected $templatePath = '';

    /**
     * Layout Path
     *
     * @var string
     */
    protected $layoutPath = '';

    /**
     * Template
     *
     * @var string
     */
    protected $template = '';

    /**
     * Layout
     *
     * @var string
     */
    protected $layout = '';

    /**
     * Template File Extension
     *
     * @var string
     */
    protected $templateFileExtension = 'php';

    /**
     * @inheritDoc
     */
    public function setVars(array $vars, bool $merge = true): ViewInterface
    {
        if ($merge) {
            $this->viewVars = array_merge($this->viewVars, $vars);
        } else {
            $this->viewVars = $vars;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setVar(string $name, $value): ViewInterface
    {
        if (isset($this->viewVars[$name])) {
            trigger_error(
                sprintf('A variable `%s` is already set', $name),
                E_USER_NOTICE
            );
        }

        $this->viewVars[$name] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTemplate(string $template): ViewInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setLayout(string $layout): ViewInterface
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTemplatePath(string $path): ViewInterface
    {
        $this->templatePath = $path;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setLayoutPath(string $path): ViewInterface
    {
        $this->layoutPath = $path;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function template(): string
    {
        if (empty($this->template)) {
            throw ViewException::noTemplateSet();
        }

        return $this->template;
    }

    /**
     * @inheritDoc
     */
    public function layout(): string
    {
        if (empty($this->template)) {
            throw ViewException::noLayoutSet();
        }

        return $this->layout;
    }

    /**
     * @inheritDoc
     */
    public function templatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * @inheritDoc
     */
    public function layoutPath(): string
    {
        return $this->layoutPath;
    }

    /**
     * @inheritDoc
     */
    public function viewVars(): array
    {
        return $this->viewVars;
    }
}
