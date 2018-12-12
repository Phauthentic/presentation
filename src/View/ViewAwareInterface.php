<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

/**
 * ViewAware Interface
 */
interface ViewAwareInterface
{
    /**
     * Set view
     *
     * @return $this
     */
    public function setView(ViewInterface $view): self;

    /**
     * Gets the view object
     *
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function getView(): ViewInterface;
}
