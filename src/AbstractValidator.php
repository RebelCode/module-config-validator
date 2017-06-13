<?php

namespace RebelCode\Modular\Config;

use Dhii\Validation\AbstractValidatorBase;

/**
 * Common functionality for RebelCode config validators.
 *
 * @since [*next-version*]
 */
abstract class AbstractValidator extends AbstractValidatorBase
{
    /**
     * Determines whether a string is a valid slug.
     *
     * The slug must be 1 or more characters long, and must start with an
     * alphanumeric character, optionally followed by a combination of such
     * chars and a hyphen. Lowercase only. Optionally can have a vendor
     * prefix, i.e. `vendor/package-name`.
     *
     * @since [*next-version*]
     *
     * @param string $string The string to determine the validity of.
     * @return bool True if string is a valid slug; false otherwise.
     */
    protected function _isValidSlug($string)
    {
        $expr =
    '!^'
        . '[a-z0-9]+'    # Must start with any number of lowercase alphanumeric chars
        . '(?:'          # Followed optionally by a hyphen and more lowercase alphanumeric chars
            . '-'
            . '[a-z0-9]+'
        . ')*'
        . '(?:'          # Optional module suffix of the same format
            . '/'           # The vendor/module separator
            . '[a-z\d]+'
            . '(?:'
                . '-'
                . '[a-z0-9]+'
            . ')*'
        . ')?'
    . '$!';

        return (bool) preg_match($expr, $string);
    }

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since [*next-version*]
     * @see sprintf()
     * @see _translate()
     *
     * @param string $string The format string to translate.
     * @param array  $args   Placeholder values to replace in the string.
     *
     * @return string The translated string.
     */
    protected function __($string, $args = array())
    {
        array_unshift($args, $string);
        $result = call_user_func('sprintf', $args);

        return $result;
    }

    /**
     * Translates a string.
     *
     * @since [*next-version*]
     *
     * @param string $string The string to translate.
     *
     * @return string The translated string.
     */
    protected function _translate($string)
    {
        return $string;
    }
}
