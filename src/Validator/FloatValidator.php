<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * Float
 *
 * Validate that an variable is a float
 */
class FloatValidator extends Validator
{
    /**
     * @var bool
     */
    protected bool $loose = false;

    /**
     * Pass true to accept float strings as valid float values
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
        return 'Value must be a valid float';
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
        return self::TYPE_FLOAT;
    }

    /**
     * Is valid
     *
     * Validation will pass when $value is float.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if ($this->loose) {
            if (! \is_numeric($value)) {
                return false;
            }
            $value = $value + 0;
        }
        if (! \is_float($value) && ! \is_int($value)) {
            return false;
        }

        return true;
    }
}
