<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Service;

use Phauthentic\Presentation\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Maps the request automatically to the view DTO objects properties
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
interface RequestToTemplateMapperServiceInterface
{
    /**
     * Sets the template for the view object up based on the request information
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request Object
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @return \Phauthentic\Presentation\View\ViewInterface
     */
    public function mapRequestToView(ServerRequestInterface $request, ViewInterface $view): ViewInterface;

    /**
     * Gets the template path from the request data
     *
     * @return string
     */
    public function getTemplatePathFromRequest(ServerRequestInterface $request): string;

    /**
     * Gets the template name from the request
     *
     * @return string
     */
    public function getTemplateFromRequest(ServerRequestInterface $request): string;
}
