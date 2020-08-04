<?php

declare(strict_types=1);

namespace Ground\Enumeration\Exception;

use Exception;

final class DuplicateValuesException extends Exception implements EnumExceptionInterface
{
}
