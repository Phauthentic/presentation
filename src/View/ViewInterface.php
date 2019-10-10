<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

/**
 * Interface for data transfer objects (DTOs) to pass the data that needs to be
 * rendered to the renderer
 */
interface ViewInterface
{
    /**
     * Sets multiple view vars
     *
     * @param  array $vars Variables to set
     * @param bool $merge Merge with existing vars
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setVars(array $vars, bool $merge = true): ViewInterface;

    /**
     * Sets a single view variable
     *
     * @param  string $name
     * @param  mixed  $value
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setVar(string $name, $value): ViewInterface;

    /**
     * Sets the template path
     *
     * @param string
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setTemplatePath(string $path): ViewInterface;

    /**
     * Sets the template to be rendered
     *
     * @param string $template Template file or name
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setTemplate(string $template): ViewInterface;

    /**
     * Sets the layout
     *
     * @param string
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setLayout(string $layout): ViewInterface;

    /**
     * Sets the layout path
     *
     * @param string
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function setLayoutPath(string $path): ViewInterface;

    /**
     * Gets the template
     *
     * @return string
     */
    public function template(): string;

    /**
     * Gets the layout
     *
     * @return string
     */
    public function layout(): string;

    /**
     * Gets the layout path
     *
     * @return string
     */
    public function templatePath(): string;

    /**
     * Gets the layout
     *
     * @return string
     */
    public function layoutPath(): string;

    /**
     * Gets the view vars
     *
     * @return array
     */
    public function viewVars(): array;
}
