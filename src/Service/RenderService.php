<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Service;

use Phauthentic\Presentation\Renderer\NativePHPRenderer;
use Phauthentic\Presentation\Renderer\RendererInterface;
use Phauthentic\Presentation\Renderer\WkhtmlToPdfRenderer;
use Phauthentic\Presentation\View\ViewInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

/**
 * Maps mime types to renderer implementations
 */
class RenderService implements RenderServiceInterface, ResponseRenderServiceInterface
{
    /**
     * Map of output types to renderers
     *
     * @var array
     */
    protected $rendererMap = [];

    /**
     * Response Factory
     *
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * Map of mime types to output types
     *
     * @var array
     */
    protected $mimeTypeMap = [
        // html
        'text/html' => NativePHPRenderer::class,
        'application/xhtml' => NativePHPRenderer::class,
        'application/xhtml+xml' => NativePHPRenderer::class,
        // json
        'application/json' => 'json',
        // xml
        'application/xml' => 'xml',
        // pdf
        'application/pdf' => WkhtmlToPdfRenderer::class
    ];

    protected $outputMimeType = 'text/html';

    /**
     * Constructor
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

	/**
     * Adds a renderer and maps it to an output type
     *
     * @return $this
     */
    public function addRenderer(string $outputType, RendererInterface $renderer): RenderServiceInterface
    {
        $this->rendererMap[$outputType] = $renderer;

        return $this;
    }

    /**
     * Validate Mime Type
     *
     * @param string $mimeType Mime Type
     * @return bool
     */
    protected function validateMimeType(string $mimeType): void
    {
        if (!preg_match('#^[-\w+]+/[-\w+]+$#', $mimeType)) {
            throw new RuntimeException('Invalid mime type string');
        }
    }

    /**
     * Maps a mime type to an output type
     *
     * @param string $mimeType Mime Type
     * @param string $renderAs Abbreviation for the renderer
     * @return $this
     */
    public function addMimeTypeMapping(string $mimeType, string $renderAs): RenderServiceInterface
    {
        $this->validateMimeType($mimeType);
        $this->mimeTypeMap[$mimeType] = $renderAs;

        return $this;
    }

    /**
     * Checks if the given mime type can be rendered as output
     *
     * @param string $type Content type to render
     * @return bool
     */
    public function canRender(string $type): bool
    {
        if (isset($this->mimeTypeMap[$type])) {
            $type = $this->mimeTypeMap[$type];
        }

        return isset($this->rendererMap[$type]);
    }

    /**
     * Renders the view to the response
     *
     * @param \Phauthentic\Presentation\Renderer\ViewInterface $view
     * @param string $renderAs Type of output to render
     * @return string
     */
    public function render(ViewInterface $view, ?string $renderAs = 'text/html'): string
    {
        if (!$this->canRender($renderAs)) {
            throw new RuntimeException(sprintf(
                'No renderer found for the requested output `%s`',
                $renderAs
            ));
        }

        return $this->rendererMap[$this->mimeTypeMap[$renderAs]]->render($view);
    }

    public function setOutputMimeType(string $mimeType): RenderServiceInterface
    {
        $this->outputMimeType = $mimeType;

        return $this;
    }

    /**
     * Gets a list of mime types the client accepts from the request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request Object
     * @return A list of mime types the client accepts
     */
    public function getMimeTypesFromRequest(ServerRequestInterface $request): array {
        $mimeTypes = $request->getHeader('Accept');

        if (empty($mimeTypes)) {
            throw new RuntimeException(
                'Could not get an accept header from the request'
            );
        }

        return $mimeTypes;
    }

    /**
     * @todo Should this return an immutable instance?
     */
    public function setOutputMimeTypeByRequest(ServerRequestInterface $request): self
    {
        $mimeTypes = $this->getMimeTypesFromRequest($request);

        foreach ($mimeTypes as $mimeType) {
            if ($this->canRender($mimeType)) {
                $this->outPutMimeType = $mimeType;

                return $this;
            }
        }

        throw new RuntimeException(sprintf(
            'No renderer found for the requested output `%s`',
            $mimeType
        ));
    }

    /**
     * Renders the output to the response object
     *
     * @param \Psr\Http\Message\ResponseInterface $response Response object
     * @param \Phauthentic\Presentation\Renderer\ViewInterface $view View DTO
     * @param string $outputMimeType Output format
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderToResponse(
        ResponseInterface $response,
        ViewInterface $view,
        ?string $outputMimeType = null
    ): ResponseInterface {
        $outputMimeType = $outputMimeType === null ? $this->outputMimeType : $outputMimeType;

        $stream = $response->getBody();
        $stream->write($this->render($view, $outputMimeType));

        return $response
            ->withBody($stream)
            ->withHeader('content-type', $outputMimeType);
    }

    /**
     * @param \Phauthentic\Presentation\Renderer\ViewInterface $view View DTO
     * @param string $outputMimeType Output format
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function renderResponse(
        ViewInterface $view,
        ?string $outputMimeType = null
    ): ResponseInterface {
        $response = $this->responseFactory->createResponse();

        return $this->renderToResponse($view, $outputMimeType);
    }
}

/*
$view = new View();
$renderService = new RenderService();
$templateMapperService = new RequestToTemplateMapperService();

$view = $templateMapperService->requestToViewTemplate($request, $view);

$response = $renderService
    ->addRenderer('html', new NativePhpRenderer())
    ->addMimeTypeMapping('text/html', 'html')
    ->addMimeTypeMapping('application/xhtml')
    ->addRenderer('json', new NativeJsonRenderer())
    ->addMimeTypeMapping('application/json', 'json')
    ->setOutputMimeTypeByRequest($request)
    ->renderToResponse($response, $view);
*/
