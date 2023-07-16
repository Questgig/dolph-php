<?php

namespace DolphPHP\Validator;

use DolphPHP\Validator;

/**
 * Text
 *
 * Validate that an variable is a valid text value
 */
class Text extends Validator
{
    const NUMBERS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    const ALPHABET_UPPER = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    const ALPHABET_LOWER = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    /**
     * @var int
     */
    protected int $length;

    /**
     * @var int
     */
    protected int $min;

    /**
     * @var string[]
     */
    protected array $allowList;

    /**
     * Text constructor.
     *
     * Validate text with maximum length $length. Use $length = 0 for unlimited length.
     * Optionally, provide allowList characters array $allowList to only allow specific character.
     *
     * @param  int  $length
     * @param  int  $min
     * @param  string[]  $allowList
     */
    public function __construct(int $length, int $min = 1, array $allowList = [])
    {
        $this->length = $length;
        $this->min = $min;
        $this->allowList = $allowList;
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
        $message = 'Value must be a valid string';

        if ($this->min === $this->length) {
            $message .= ' and exactly '.$this->length.' chars';
        } else {
            if ($this->min) {
                $message .= ' and at least '.$this->min.' chars';
            }

            if ($this->length) {
                $message .= ' and no longer than '.$this->length.' chars';
            }
        }

        if ($this->allowList) {
            $message .= ' and only consist of \''.\implode(', ', $this->allowList).'\' chars';
        }

        return $message;
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
     * Is valid
     *
     * Validation will pass when $value is text with valid length.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if (!\is_string($value)) {
            return false;
        }

        if (\mb_strlen($value) < $this->min) {
            return false;
        }

        if (\mb_strlen($value) > $this->length && $this->length !== 0) {
            return false;
        }

        if (\count($this->allowList) > 0) {
            foreach (\str_split($value) as $char) {
                if (! \in_array($char, $this->allowList)) {
                    return false;
                }
            }
        }

        return true;
    }
}
