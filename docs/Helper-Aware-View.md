# Helper Aware View

Some template systems and frameworks use so called "view helpers" or simply "helpers" or a similar name, to describe utility objects for the view layer that should deal explicitly with just presentation related logic.

`HelperAwareView` provides a very simple way to archive this and make any object you like available in the view. 

```php
$view = new HelperAwareView($yourContainer);
```

We won't restrict you on what you get from it, but it is highly recommended to a pattern. Our suggested pattern is `presentation.view.helpers.<name>`. For your convenience we've implemented a way to make this possible without typing a lot:

```php
$view = new HelperAwareView(
    $yourContainer,
    'presentation.view.helpers'
);
```
