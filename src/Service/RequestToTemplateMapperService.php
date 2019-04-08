<?php
declare(strict_types=1);

namespace Phauthentic\Presentation\Service;

use Phauthentic\Presentation\View\View;
use Phauthentic\Presentation\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Maps the request automatically to the view DTO objects properties
 *
 * You must configure your router or in some middleware some request attributes.
 * The defaults are `module`, `component` and `action`.
 *
 * module:
 *  A module is a plugin or a whole - separate - module of the application. This
 *  request attribute can be empty! It's optional!
 *
 * component:
 *  A component would be in the MVC context a "controller". It can be also thougt
 *  as a request handling object. No matter if it handles a single or multiple
 *  different requests
 *
 * action:
 *  An action is the actual method or name of the handler that gets called
 *
 * Examples:
 *
 * URL: /my/module/example/view/1
 *  - Module: /my/module
 *  - Component: /example
 *  - Action: /view
 *
 * Will be composed to:
 *  - {basePath}/{module}/{component}/{action}
 *  - /var/www/my-app/resources/templates/my/module/example/view.tpl
 */
class RequestToTemplateMapperService implements RequestToTemplateMapperServiceInterface
{

    /**
     * Default view class
     *
     * @var string
     */
    protected $viewClass = View::class;

    /**
     * Config
     *
     * @var array
     */
    protected $config = [
        'module' => 'module', // "plugin", "extension"
        'component' => 'component', // "controller", "handler"
        'action' => 'action',
        'triggerWarnings' => false
    ];

    /**
     * Constructor
     *
     * @param \Psr\Http\Message\ServerRequestInterface
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * Sets the template for the view object up based on the request information
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request Object
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function mapRequestToView(ServerRequestInterface $request, ViewInterface $view): ViewInterface
    {
        $view->setTemplatePath($this->getTemplatePathFromRequest($request));
        $view->setTemplate($this->getTemplateFromRequest($request));

        return $view;
    }

    /**
     * Gets the template path from the request data
     *
     * @return string
     */
    public function getTemplatePathFromRequest(ServerRequestInterface $request): string
    {
        $module = (string)$request->getAttribute('module');
        $component = (string)$request->getAttribute('component');

        $module = empty($module) ? '' : $module;
        $component = empty($component) ? 'default' : $component;

        if (empty($component)) {
            trigger_error(
                sprintf('Could not get the template path from the request data. The request attribute `%s` was not found.', $this->config['component']),
                E_USER_WARNING
            );
        }

        if (!empty($module)) {
            return $module . DIRECTORY_SEPARATOR . $component;
        }

        return $component;
    }

    /**
     * Gets the template name from the request
     *
     * @return string
     */
    public function getTemplateFromRequest(ServerRequestInterface $request): string
    {
        $action = (string)$request->getAttribute('action');

        if (empty($action)) {
            return 'default';
            trigger_error(
                sprintf('Could not get the template name from the request data. The request attribute `%s` was not found.', $this->config['action']),
                E_USER_WARNING
            );
        }

        return $action;
    }
}
