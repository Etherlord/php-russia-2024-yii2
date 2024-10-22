<?php

declare(strict_types=1);

namespace app\infrastructure;

enum EnvType
{
    case BOOL;
    case INT;
    case FLOAT;
    case ALPHABETIC_STRING;
    case URL;
}
