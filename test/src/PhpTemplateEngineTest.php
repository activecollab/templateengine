<?php

/*
 * This file is part of the ActiveCollab TemplateEngine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplateEngine\Test;

use ActiveCollab\TemplateEngine\TemplateEngine\PhpTemplateEngine;
use InvalidArgumentException;
use RuntimeException;

class PhpTemplateEngineTest extends TestCase
{
    /**
     * @var PhpTemplateEngine
     */
    private $template_engine;

    public function setUp(): void
    {
        parent::setUp();

        $this->template_engine = new PhpTemplateEngine($this->templates_path);
    }

    public function testExceptionOnMissingTemplatesDir()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Templates path 'this one does not exist' does not exist");

        new PhpTemplateEngine('this one does not exist');
    }

    public function testExceptionOnMissingTemplate()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Template 'not found' does not exist");

        $this->template_engine->fetch('not found');
    }

    public function testAttributeManagement()
    {
        $this->assertIsArray($this->template_engine->getAttributes());

        $this->template_engine->addAttribute('one', 1)->addAttribute('two', 2);
        $this->assertEquals(['one' => 1, 'two' => 2], $this->template_engine->getAttributes());

        $this->template_engine->setAttributes(['three' => 3, 'four' => 4]);
        $this->assertEquals(['three' => 3, 'four' => 4], $this->template_engine->getAttributes());
    }

    public function testNoDataRender()
    {
        $this->assertEquals(
            file_get_contents(
                $this->template_engine->getTemplatePath('no-attributes.php')
            ),
            $this->template_engine->fetch('no-attributes.php')
        );
    }

    public function testDataRender()
    {
        $rendered_content = $this->template_engine->fetch('/mail/hello.php', ['first_name' => 'John']);

        $this->assertStringEndsWith("\n", $rendered_content);
        $rendered_content = trim($rendered_content);
        $this->assertEquals($rendered_content, 'Hello John.');
    }

    public function testDisplay()
    {
        ob_start();
        $this->template_engine->display('/mail/hello.php', ['first_name' => 'John']);
        $rendered_content = ob_get_clean();

        $this->assertStringEndsWith("\n", $rendered_content);
        $rendered_content = trim($rendered_content);
        $this->assertEquals($rendered_content, 'Hello John.');
    }

    public function testRemovalOfLeadingSlashes()
    {
        $this->assertEquals(
            "$this->templates_path/mail/hello.php",
            $this->template_engine->getTemplatePath('///////mail/hello.php')
        );
    }

    public function testSandboxingToTemplatesDir()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Template '../danger/danger-zone.php' does not exist");

        $this->template_engine->fetch('../danger/danger-zone.php');
    }
}
