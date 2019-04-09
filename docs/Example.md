# Example

This is a **very basic example** to illustrate the separation of concerns and passing a view to a renderer. You should use your DI container and factories to implement this in a way it won't require you to instantiate the objects manually and use them in the correct layers of your architecture. 

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
