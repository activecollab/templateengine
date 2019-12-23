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
    protected $templates_path;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->templates_path = dirname(__DIR__) . '/templates';
    }
}
