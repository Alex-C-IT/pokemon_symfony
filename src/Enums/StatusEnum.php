<?php

namespace App\Enums;

enum Status: int
{
    case BANNI = 0;
    case ACTIF = 1;
    case ADMINISTRATEUR = 2;
}
