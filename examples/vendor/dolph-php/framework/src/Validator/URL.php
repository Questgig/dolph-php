<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * URL
 *
 * Validate that an variable is a valid URL
 *
 * @package Appwrite\Network\Validator
 */
class URL extends Validator
{
    protected array $allowedSchemes;

    /**
     * @param array $allowedSchemes
     */
    public function __construct(array $allowedSchemes = [])
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    /**
     * Get Description
     *
     * Returns validator description
     *
     * @return string
     */
    public function getDescription(): string
    {
        if (!empty($this->allowedSchemes)) {
            return 'Value must be a valid URL with following schemes (' . \implode(', ', $this->allowedSchemes) . ')';
        }

        return 'Value must be a valid URL';
    }

    /**
     * Is valid
     *
     * Validation will pass when $value is valid URL.
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid($value): bool
    {
        if (\filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        if (!empty($this->allowedSchemes) && !\in_array(\parse_url($value, PHP_URL_SCHEME), $this->allowedSchemes)) {
            return false;
        }

        return true;
    }

    /**
     * Is array
     *
     * Function will return true if object is array.
     *
     * @return bool
     */
    public function isArray(): bool
    {
        return false;
    }

    /**
     * Get Type
     *
     * Returns validator type.
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_STRING;
    }
}
