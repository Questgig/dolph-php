<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * ArrayList
 *
 * Validate that an variable is a valid array value and each element passes given validation
 */
class Assoc extends Validator
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
        return 'Value must be a valid object.';
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
        return true;
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
        return self::TYPE_ARRAY;
    }

    /**
     * Is valid
     *
     * Validation will pass when $value is valid assoc array.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function isValid($value): bool
    {
        if (! \is_array($value)) {
            return false;
        }

        $jsonString = \json_encode($value);
        $jsonStringSize = \strlen($jsonString);

        if ($jsonStringSize > 65535) {
            return false;
        }

        return \array_keys($value) !== \range(0, \count($value) - 1);
    }
}
