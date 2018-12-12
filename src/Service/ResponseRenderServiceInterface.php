<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Service\Service;

use Phauthentic\Presentation\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Response Render Service Interface
 */
interface ResponseRenderServiceInterface
{
    /**
     * Renders the output to the response object
     *
     * @param \Psr\Http\Message\ResponseInterface $response Response object
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @param string $outputType Output format
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderToResponse(ResponseInterface $response, ViewInterface $view, ?string $outputType): ResponseInterface;

    /**
     * Gets a list of mime types the client accepts from the request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request Object
     * @return A list of mime types the client accepts
     */
    public function getMimeTypesFromRequest(ServerRequestInterface $request): array;
}
