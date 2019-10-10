<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;
use SimpleXMLElement;

/**
 * Simple XML Renderer
 *
 * @link https://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
 */
class SimpleXMLRenderer implements RendererInterface
{
    /**
     * XML Root Node
     *
     * @var string
     */
    protected $rootNode = '<?xml version="1.0"?><data></data>';

    /**
     * Constructor
     *
     * @param null|string $rootNode Root Node
     */
    public function __construct(?string $rootNode = null)
    {
        if ($rootNode) {
            $this->rootNode = $rootNode;
        }
    }

    /**
     * Sets the Root Node
     *
     * @param string $rootNode Root Node
     * @return $this
     */
    public function setRootNode(string $rootNode): self
    {
        $this->rootNode = $rootNode;

        return $this;
    }

    /**
     * Get simple XML Element
     *
     * @return \SimpleXMLElement
     */
    protected function getSimpleXmlElement(): SimpleXMLElement
    {
        return new SimpleXMLElement($this->rootNode);
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $view): string
    {
        $view->viewVars();
        $xml = $this->getSimpleXmlElement();

        $this->arrayToXml($view->viewVars(), $xml);

        return $xml->asXML();
    }

    /**
     * Array to XML
     *
     * @return void
     */
    protected function arrayToXml(array $data, SimpleXMLElement &$xmlData): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xmlData->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                } else {
                    $this->arrayToXml($value, $xmlData);
                }
            } else {
                $xmlData->addChild("$key", "$value");
            }
        }
    }
}
