<?php

namespace RebelCode\Modular\Config;

use RebelCode\Modular\Config\ConfigInterface as Cfg;

/**
 * Validates a RebelCode module configuration.
 *
 * @since [*next-version*]
 */
class Validator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getValidationErrors($subject)
    {
        $errors = array();
        if (!is_array($subject)) {
            $errors[] = $this->__('Subject must be a map');

            return $errors;
        }

        $required = $this->_getRequiredKeys();
        foreach ($required as $_key) {
            if (!isset($subject[$_key])) {
                $errors[] = $this->__('Subject is missing required key "%1$s"', array($_key));
            }
        }

        if (isset($subject[Cfg::K_KEY]) && !$this->_isValidSlug($subject[Cfg::K_KEY])) {
            $errors[] = $this->__('The "%1$s" key does not contain a valid module slug', array(Cfg::K_KEY));
        }

        return $errors;
    }

    /**
     * Retrieves a list of keys that are required to be present in the config.
     *
     * @since [*next-version*]
     *
     * @return array The list of indices.
     */
    protected function _getRequiredKeys()
    {
        return array(
            Cfg::K_KEY,
        );
    }
}
