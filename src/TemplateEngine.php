<?php

/*
 * This file is part of the Active Collab Template Engine project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\TemplateEngine;

use Exception;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Controller\Response
 */
abstract class TemplateEngine implements TemplateEngineInterface
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var string
     */
    private $templates_path;

    /**
     * @param string $templates_path
     */
    public function __construct($templates_path)
    {
        $this->setTemplatesPath($templates_path);
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($template, array $data = [])
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

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function &setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function &addAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($key)
    {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplatesPath()
    {
        return $this->templates_path;
    }

    /**
     * {@inheritdoc}
     */
    public function &setTemplatesPath($templates_path)
    {
        $templates_path = rtrim($templates_path, '/');

        if (!is_dir($templates_path)) {
            throw new InvalidArgumentException("Templates path '$templates_path' does not exist");
        }

        $this->templates_path = rtrim($templates_path, '/');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplatePath($template)
    {
        return $this->templates_path . '/' . $template;
    }
}
