<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\TemplateEngine\TemplateEngine;

use ActiveCollab\TemplateEngine\TemplateEngine;
use RuntimeException;

/**
 * @package ActiveCollab\Controller\Response\ViewResponse
 */
class PhpTemplateEngine extends TemplateEngine
{
    /**
     * {@inheritdoc}
     */
    public function &display($template, array $data = [])
    {
        $template_path = $this->getTemplatePath($template);

        if (!is_file($template_path)) {
            throw new RuntimeException("Template '$template' does not exist");
        }
        $this->protectedIncludeScope($template_path, array_merge($this->getAttributes(), $data));

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
