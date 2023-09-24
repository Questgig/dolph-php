<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * Numeric
 *
 * Validate that an variable is numeric
 */
class Numeric extends Validator
{
    /**
     * Get Description
     *
     * Returns validator description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Value must be a valid number';
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
        return self::TYPE_MIXED;
    }

    /**
     * Is valid
     *
     * Validation will pass when $value is numeric.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if (! \is_numeric($value)) {
            return false;
        }

        return true;
    }
}
