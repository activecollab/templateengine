<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\TemplateEngine\TemplateEngine;

use ActiveCollab\TemplateEngine\TemplateEngine;

/**
 * @package ActiveCollab\TemplateEngine\TemplateEngine
 */
class PhpTemplateEngine extends TemplateEngine
{
    /**
     * {@inheritdoc}
     */
    public function &display($template, array $data = [])
    {
        $this->protectedIncludeScope($this->getTemplatePath($template), array_merge($this->getAttributes(), $data));

        return $this;
    }

    /**
     * @param string $template
     * @param array  $data
     */
    protected function protectedIncludeScope($template, array $data)
    {
        extract($data);
        include $template;
    }
}
