<?php

declare(strict_types=1);

namespace Ground\Enumeration;

use BadMethodCallException;
use Ground\Enumeration\Exception\DuplicateValuesException;
use Ground\Enumeration\Exception\NotAllStringOrIntValuesTypeException;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use Ground\Enumeration\Exception\NotValidEnumerationValueException;
use Throwable;

use function array_flip;
use function array_key_exists;
use function array_unique;
use function count;
use function get_class;
use function in_array;
use function is_a;
use function is_int;
use function is_string;
use function lcfirst;
use function sprintf;
use function substr;

abstract class AbstractEnumeration
{
    /**
     * @var int|string
     */
    private $value;

    /**
     * @return int[]|string[]
     */
    abstract public static function getValues(): array;

    /**
     * @param int|string $value
     * @return static
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    final public static function createByValue($value)
    {
        return new static($value);
    }

    /**
     * @param string $name
     * @return static
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    final public static function createByName(string $name)
    {
        return self::createByValue(self::getValueByName($name));
    }

    /**
     * @param string $name
     * @param mixed[] $arguments
     * @return static
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    final public static function __callStatic(string $name, array $arguments)
    {
        return self::createByName($name);
    }

    /**
     * @param int|string $value
     * @return boolean
     */
    final public static function contains($value): bool
    {
        return in_array($value, static::getValues(), true);
    }

    /**
     * @param int|string $value
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    final public function __construct($value)
    {
        if (!$this->isUniqueValues()) {
            throw new DuplicateValuesException(
                sprintf(
                    'There duplicate values in enumeration "%s"',
                    static::class
                )
            );
        }

        if (!$this->isValuesStringOrInt()) {
            throw new NotAllStringOrIntValuesTypeException(
                sprintf(
                    'Values must be string or int type in enumeration "%s"',
                    static::class
                )
            );
        }

        if (!static::contains($value)) {
            throw new NotValidEnumerationValueException(
                sprintf(
                    '"%s" is not a valid value for enumeration "%s"',
                    $value,
                    static::class
                )
            );
        }

        $this->value = $value;
    }

    /**
     * @param string|int $value
     * @return static|null
     */
    final public static function tryCreateByValue($value)
    {
        try {
            return self::createByValue($value);
        } catch (Throwable $exception) {
            return null;
        }
    }

    /**
     * @return int|string
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return array_flip(static::getValues())[$this->getValue()];
    }

    /**
     * @param self $other
     * @return bool
     */
    final public function eq(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    /**
     * @param self[] $enumerations
     * @return bool
     */
    final public function isContainedIn(array $enumerations): bool
    {
        foreach ($enumerations as $item) {
            if (!is_a($item, get_class($this))) {
                continue;
            }

            if ($this->eq($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @param mixed[] $arguments
     * @return bool
     * @throws BadMethodCallException
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    final public function __call(string $name, array $arguments): bool
    {
        $action = substr($name, 0, 2);

        switch ($action) {
            case 'is':
                return
                    $this->getValue()
                    ===
                    self::createByName(lcfirst(substr($name, 2)))->getValue();

                break;
        }

        throw new BadMethodCallException(
            sprintf(
                'Enumeration method with name "%s" not found',
                $action
            )
        );
    }

    /**
     * @return string
     */
    final public function __toString(): string
    {
        return (string)$this->getValue();
    }

    /**
     * @param string $name
     * @return string|int
     * @throws NotValidEnumerationNameException
     */
    private static function getValueByName(string $name)
    {
        if (!array_key_exists($name, static::getValues())) {
            throw new NotValidEnumerationNameException(
                sprintf(
                    '"%s" is not a valid name for enumeration "%s"',
                    $name,
                    static::class
                )
            );
        }

        return static::getValues()[$name];
    }

    /**
     * @return bool
     */
    private function isUniqueValues(): bool
    {
        return count(static::getValues()) === count(array_unique(static::getValues()));
    }

    /**
     * @return bool
     */
    private function isValuesStringOrInt(): bool
    {
        foreach (static::getValues() as $value) {
            if (!is_int($value) && !is_string($value)) {
                return false;
            }
        }

        return true;
    }
}
