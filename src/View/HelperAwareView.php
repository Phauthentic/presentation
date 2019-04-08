<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Helper Aware View
 *
 * Some MVC Frameworks implement "view helpers". Objects that can be accessed
 * in the view layer to fulfill some view specific tasks that aren't application
 * logic.
 *
 * This class is simple extension to the default view object that takes a
 * PSR compatible container object from which we retrieve helper objects
 * through php's magic __get().
 */
class HelperAwareView extends View implements HelperAwareViewInterface
{
    /**
     * View Helper Container
     *
     * @var \Psr\Container\ContainerInterface;
     */
    protected $helpers;

    /**
     * Container namespace prefix
     *
     * @var string
     */
    protected $containerNamespacePrefix = '';

    /**
     * Constructor
     *
     * @param \Psr\Container\ContainerInterface $services
     */
    public function __construct(
        ContainerInterface $services,
        string $containerNamespacePrefix = ''
    ) {
        $this->helpers = $services;
        $this->containerNamespacePrefix = $containerNamespacePrefix;
    }

    /**
     * Gets the helper service container
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function helpers(): ContainerInterface
    {
        return $this->helpers;
    }

    /**
     * Magic getter
     *
     * @param string $name Name
     * @return mixed
     */
    public function __get($name)
    {
        if (!$this->helpers->has($name)) {
            return;
        }

        $helper = $this->helpers()->get($this->containerNamespacePrefix . $name);

        if ($helper instanceof ViewAwareInterface) {
            $helper->setView($this);
        }

        if (!is_object($helper)) {
        	throw new RuntimeException(sprintf('%s is not an object, %s given', $name, gettype($helper)));
        }
        return $helper;
    }
}
