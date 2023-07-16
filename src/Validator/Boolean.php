<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * Bool
 *
 * Validate that an variable is a boolean value
 */
class Boolean extends Validator
{
    /**
     * @var bool
     */
    protected bool $loose = false;

    /**
     * Pass true to accept true and false strings and integers 0 and 1 as valid boolean values
     * This option is good for validating query string params.
     *
     * @param  bool  $loose
     */
    public function __construct(bool $loose = false)
    {
        $this->loose = $loose;
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
        return 'Value must be a valid boolean';
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
        return self::TYPE_BOOLEAN;
    }

    /**
     * Is valid
     *
     * Validation will pass when $value has a boolean value.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function isValid($value): bool
    {
        if ($this->loose && ($value === 'true' || $value === 'false')) { // Accept strings
            return true;
        }

        if ($this->loose && ($value === '1' || $value === '0')) { // Accept numeric strings
            return true;
        }

        if ($this->loose && ($value === 1 || $value === 0)) { // Accept integers
            return true;
        }

        if (\is_bool($value)) {
            return true;
        }

        return false;
    }
}
