<?php

declare(strict_types=1);

namespace App\Common\Domain\Exception;

enum ErrorCode:string
{
   case INCORRECT_UUID = 'INCORRECT_UUID';

}
