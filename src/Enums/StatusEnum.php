<?php

namespace App\Enums;

enum StatusEnum: int
{
    case BANNI = 0;
    case ACTIF = 1;
    case EN_ATTENTE_DE_VALIDATION = 2;
}
