<?php

/*
 * This file is part of the ActiveCollab TemplateEngine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplateEngine\TemplateEngine;

use ActiveCollab\TemplateEngine\TemplateEngine;
use ActiveCollab\TemplateEngine\TemplateEngineInterface;
use InvalidArgumentException;

class PhpTemplateEngine extends TemplateEngine
{
    public function display(string $template, array $data = []): TemplateEngineInterface
    {
        $this->protectedIncludeScope(
            $this->getTemplatePath($template),
            array_merge(
                $this->getAttributes(),
                $data
            )
        );

        return $this;
    }

    protected function protectedIncludeScope($template, array $data)
    {
        extract($data);
        include $template;
    }

    protected function sanitize(mixed $str): string
    {
        if ($str === null)  {
            return '';
        }

        if (is_scalar($str) || (is_object($str) && method_exists($str, '__toString'))) {
            $str = preg_replace(
                '/&(?!#(?:[0-9]+|x[0-9A-F]+);?)/si',
                '&amp;',
                (string) $str,
            );

            return str_replace(['<', '>', '"'], ['&lt;', '&gt;', '&quot;'], $str);
        }

        throw new InvalidArgumentException('$str needs to be scalar value');
    }
}
