<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\TemplateEngine;

/**
 * @package ActiveCollab\Controller\Response
 */
interface TemplateEngineInterface
{
    /**
     * Renders a template and prints the output to the output buffer.
     *
     * @param  string $template
     * @param  array  $data
     * @return $this
     */
    public function &display($template, array $data = []);

    /**
     * Renders a template and returns the result as a string.
     *
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function fetch($template, array $data = []);

    /**
     * Get the attributes for the renderer.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set the attributes for the renderer.
     *
     * @param  array $attributes
     * @return $this
     */
    public function &setAttributes(array $attributes);

    /**
     * Add an attribute.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function &addAttribute($key, $value);

    /**
     * Retrieve an attribute.
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Get the template path.
     *
     * @return string
     */
    public function getTemplatesPath();

    /**
     * Set the template path.
     *
     * @param  string $templates_path
     * @return $this;
     */
    public function &setTemplatesPath($templates_path);

    /**
     * Return a path of a given template.
     *
     * @param  string $template
     * @return string
     */
    public function getTemplatePath($template);
}
