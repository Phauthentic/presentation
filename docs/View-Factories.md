# View Factories

Because the template and template path is very different determined by different frameworks and libraries it is recommended to implement your own factory to map your requests route parameters to your template path and template file if you don't want to manually take care of this.

Be aware that this is just a made up example, that assumes you have a `controller` and `action` query param in your server request!
```php
use Phauthentic/Presentation/View/View;
use Phauthentic/Presentation/View/ViewInterface;
use Psr/HttpMessage/ServerRequestInterface;

class MyViewFactory implements ViewFactoryInterface
{
    protected $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function buildView(): ViewInterface
    {
        $view = new View();

        // Do whatever you need here to determine your template path and template file
        // For example:
        $queryParams = $this->request->getQueryParams();
        if (isset($queryParams['controller']) {
            $view->setTemplateFolder((string)$queryParams['controller']);
        }
        if (isset($queryParams['action']) {
            $view->setTemplate((string)$queryParams['action']);
        }

        return $view;
    }
}
```

This is just one way to do it! There are many different use cases and ways to do this, be creative and do whatever suits *your* application the best!
