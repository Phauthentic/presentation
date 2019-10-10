<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View\Exception;

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
class ViewException extends RuntimeException
{
    public static function noLayoutSet()
    {
        return new self('No layout specified for view');
    }

    public static function noTemplateSet()
    {
        return new self('No template specified for view');
    }
}
