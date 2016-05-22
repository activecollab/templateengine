# Template Engine

[![Build Status](https://travis-ci.org/activecollab/templateengine.svg?branch=master)](https://travis-ci.org/activecollab/templateengine)

This package offers a single interface for interaction with multiple template engines. It ships with simple PHP template engine built in:

```php
$template_engine = new PhpTemplateEngine('/path/to/templates/dir');

// Render template to output buffer
$template_engine->display('/mail/hello.php', ['first_name' => 'John'])

// Render template and return return output as a string
$output = $template_engine->fetch('/mail/hello.php', ['first_name' => 'John'])
```
