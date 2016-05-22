<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\TemplateEngine\Test;

use ActiveCollab\TemplateEngine\TemplateEngine\PhpTemplateEngine;

/**
 * @package ActiveCollab\TemplateEngine\Test
 */
class PhpTemplateEnginetTest extends TestCase
{
    /**
     * @var PhpTemplateEngine
     */
    private $template_engine;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->template_engine = new PhpTemplateEngine($this->templates_path);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Templates path 'this one does not exist' does not exist
     */
    public function testExceptionOnMissingTemplatesDir()
    {
        new PhpTemplateEngine('this one does not exist');
    }

    /**
     * @expectedException \RuntimeException
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
        $this->assertInternalType('array', $this->template_engine->getAttributes());

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
        $this->assertEquals(file_get_contents($this->template_engine->getTemplatePath('no-attributes.php')), $this->template_engine->fetch('no-attributes.php'));
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
}
