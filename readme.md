# Presentation

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/Phauthentic/presentation/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/Phauthentic/presentation/)
[![Code Quality](https://img.shields.io/scrutinizer/g/Phauthentic/presentation/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/Phauthentic/presentation/)

**WORK IN PROGRESS - NOT READY FOR PRODUCTION!**

A framework and library agnostic presentation layer implementation. The purpose of this is to provide a data transfer object to make your application independent from the underlying rendering implementation.

This library uses a view object that will carry all the information from where ever to the renderer objects, that will read the information and render the desired output depending on the underlying library and implementation. It is pretty easy so switch the rendering sub system with this approach and everything is strict typed as well.
 
## Installation

You can install this library using [composer](http://getcomposer.org):

```
composer require phauthentic/presentation
```

## Example

This is a very basic example to illustrate the separation of concerns and passing a view to a renderer. You should use your DI container and factories to implement this in a way it won't require you to instantiate the objects manually and use them in the correct layers of your architecture. 

```php
use Phauthentic/Presentation/Renderer/SimplePHPRender;
use Phauthentic/Presentation/Renderer/TwigRenderer;
use Phauthentic/Presentation/View/View;

$view = (new View())
    // Set a single view var
    ->setViewVar('title', 'Hey there')
    // Set multiple view vars
    ->setViewVars([
        'author' => 'Its me',
        'text' => 'Lorem Ipsum...'
    ])
    // This will render <template-root>/Articles/view.php
    ->setTemplatePath('Articles')
    ->setTemplate('view'); 

// Plain php renderer
$renderer = new SimplePHPRender();
$output = $renderer->renderView($view);

// Twig
$loader = new \Twig\Loader\FilesystemLoader('/your/template-root/folder');
$twig = new \Twig\Environment($loader, [
    'cache' => sys_get_temp_dir(),
]);
        
$renderer = new TwigRenderer($twig);
$output = $renderer->renderView($view);

// ...any other renderer you want
```

## View Factory

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

## Copyright & License

Licensed under the [MIT license](LICENSE.txt).

Copyright (c) [Phauthentic](https://github.com/Phauthentic)
