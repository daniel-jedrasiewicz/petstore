<?php

namespace App\Enums;
enum PetStatus: string
{
    case Pending = 'pending';
    case Available = 'available';
    case Sold = 'sold';
}
