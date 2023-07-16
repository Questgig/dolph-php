<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

class HexColor extends Validator
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Value must be a valid Hex color code';
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

    /**
     * @param  mixed  $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if (\is_string($value) && \preg_match('/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value)) {
            return true;
        }

        return false;
    }
}
