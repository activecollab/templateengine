<?php

/*
 * This file is part of the ActiveCollab TemplateEngine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplateEngine\Test;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $templates_path;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->templates_path = dirname(__DIR__) . '/templates';
    }
}
