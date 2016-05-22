# Template Engine

[![Build Status](https://travis-ci.org/activecollab/templateengine.svg?branch=master)](https://travis-ci.org/activecollab/templateengine)

This package offers a single interface for interaction with multiple template engines. It ships with simple PHP template engine built in:

```php
$template_engine = new PhpTemplateEngine('/path/to/templates/dir');

// Set attributes that will be passed to all templates. Method chaining is supported.
$template_engine->setAttributes([
    'app_name' => 'My Awesome App',
    'app_version' => '1.0.0',
])->addAttribute('app_env', 'staging');

// Render template to output buffer
$template_engine->display('/mail/hello.php', ['first_name' => 'John'])

// Render template and return return output as a string
$output = $template_engine->fetch('/mail/hello.php', ['first_name' => 'John'])
```

## Template Sandboxing

Templates are sandboxed, and can be placed only in templates directory that is specified when engine is constructed. If you try to use a template that is not in this directory, template engine will throw a `\RuntimeException`:

```php
$template_engine->fetch('/example/../../../../etc/passwd'); // Will throw an exception
```
