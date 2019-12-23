<?php

/*
 * This file is part of the ActiveCollab TemplateEngine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplateEngine;

use Exception;
use InvalidArgumentException;
use RuntimeException;

abstract class TemplateEngine implements TemplateEngineInterface
{
    private $attributes = [];
    private $templates_path;

    public function __construct(string $templates_path)
    {
        $this->setTemplatesPath($templates_path);
    }

    public function fetch(string $template, array $data = []): string
    {
        try {
            ob_start();
            $this->display($template, $data);

            return ob_get_clean();
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): TemplateEngineInterface
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttribute(string $key, $value): TemplateEngineInterface
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function getAttribute(string $key)
    {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    public function getTemplatesPath(): string
    {
        return $this->templates_path;
    }

    public function setTemplatesPath(string $templates_path): TemplateEngineInterface
    {
        $templates_path = rtrim($templates_path, '/');

        if (!is_dir($templates_path)) {
            throw new InvalidArgumentException("Templates path '$templates_path' does not exist");
        }

        $this->templates_path = rtrim($templates_path, '/');

        return $this;
    }

    public function getTemplatePath(string $template): string
    {
        $template_path = $this->templates_path . '/' . ltrim($template, '/');

        if (strpos($template_path, './')) {
            $template_path = realpath($template_path);

            if (empty($template_path)
                || $this->templates_path != mb_substr($template_path, 0, mb_strlen($this->templates_path))
            ) {
                throw new RuntimeException("Template '$template' does not exist");
            }
        }

        if (!is_file($template_path)) {
            throw new RuntimeException("Template '$template' does not exist");
        }

        return $template_path;
    }
}
