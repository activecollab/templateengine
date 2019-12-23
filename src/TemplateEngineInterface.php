<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplateEngine;

interface TemplateEngineInterface
{
    public function display(string $template, array $data = []): TemplateEngineInterface;
    public function fetch(string $template, array $data = []): string;

    public function getAttributes(): array;
    public function setAttributes(array $attributes): TemplateEngineInterface;
    public function addAttribute(string $key, $value): TemplateEngineInterface;
    public function getAttribute(string $key);

    public function getTemplatesPath(): string;
    public function setTemplatesPath(string $templates_path): TemplateEngineInterface;
    public function getTemplatePath(string $template): string;
}
