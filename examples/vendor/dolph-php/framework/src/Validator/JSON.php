<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

class JSON extends Validator
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Value must be a valid JSON string';
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
     * Returns validator type
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_OBJECT;
    }

    /**
     * @param  mixed  $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if (\is_array($value)) {
            return true;
        }

        if (\is_string($value)) {
            \json_decode($value);

            return \json_last_error() == JSON_ERROR_NONE;
        }

        return false;
    }
}
