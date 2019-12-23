<?php

/*
 * This file is part of the Active Collab Template Engine project.
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

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Templates path 'this one does not exist' does not exist
     */
    public function testExceptionOnMissingTemplatesDir()
    {
        new PhpTemplateEngine('this one does not exist');
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Template 'not found' does not exist
     */
    public function testExceptionOnMissingTemplate()
    {
        $this->template_engine->fetch('not found');
    }

    /**
     * Test attribute management.
     */
    public function testAttributeManagement()
    {
        $this->assertIsArray($this->template_engine->getAttributes());

        $this->template_engine->addAttribute('one', 1)->addAttribute('two', 2);
        $this->assertEquals(['one' => 1, 'two' => 2], $this->template_engine->getAttributes());

        $this->template_engine->setAttributes(['three' => 3, 'four' => 4]);
        $this->assertEquals(['three' => 3, 'four' => 4], $this->template_engine->getAttributes());
    }

    /**
     * Test with no data to render.
     */
    public function testNoDataRender()
    {
        $this->assertEquals(
            file_get_contents(
                $this->template_engine->getTemplatePath('no-attributes.php')
            ),
            $this->template_engine->fetch('no-attributes.php')
        );
    }

    /**
     * Test renderer with data forwarded to the template.
     */
    public function testDataRender()
    {
        $rendered_content = $this->template_engine->fetch('/mail/hello.php', ['first_name' => 'John']);

        $this->assertStringEndsWith("\n", $rendered_content);
        $rendered_content = trim($rendered_content);
        $this->assertEquals($rendered_content, 'Hello John.');
    }

    /**
     * Test template display.
     */
    public function testDisplay()
    {
        ob_start();
        $this->template_engine->display('/mail/hello.php', ['first_name' => 'John']);
        $rendered_content = ob_get_clean();

        $this->assertStringEndsWith("\n", $rendered_content);
        $rendered_content = trim($rendered_content);
        $this->assertEquals($rendered_content, 'Hello John.');
    }

    /**
     * Test removal of leading slash from a template name.
     */
    public function testRemovalOfLeadingSlashes()
    {
        $this->assertEquals(
            "$this->templates_path/mail/hello.php",
            $this->template_engine->getTemplatePath('///////mail/hello.php')
        );
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Template '../danger/danger-zone.php' does not exist
     */
    public function testSandboxingToTemplatesDir()
    {
        $this->template_engine->fetch('../danger/danger-zone.php');
    }
}
