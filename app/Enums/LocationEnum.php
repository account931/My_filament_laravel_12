<?php
//->options([
    //ConfirmedEnum::Confirmed->value    => ConfirmedEnum::Confirmed->label() ,      //'1'  => 'Confirmed',
    //ConfirmedEnum::NotConfirmed->value => ConfirmedEnum::NotConfirmed->label(),   //'0'   => 'Not Confirmed',
                     
namespace App\Enums;

//
enum LocationEnum: string //int
{
    case EU     = 'EUU';
    case UA     = 'UAA';
    

    public function label(): string
    {
        return match($this) {
            self::EU    => 'EU part',
            self::UA    => 'UA part',
        };
    }
}