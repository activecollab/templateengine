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
}
