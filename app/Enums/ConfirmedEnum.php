<?php
//->options([
    //ConfirmedEnum::Confirmed->value    => ConfirmedEnum::Confirmed->label() ,      //'1'  => 'Confirmed',
    //ConfirmedEnum::NotConfirmed->value => ConfirmedEnum::NotConfirmed->label(),   //'0'   => 'Not Confirmed',
                     
namespace App\Enums;

//
enum ConfirmedEnum: string
{
    case Confirmed     = '1';
    case NotConfirmed  = '0';
    

    public function label(): string
    {
        return match($this) {
            self::Confirmed    => 'Confirmed2',
            self::NotConfirmed => 'Not Confirmed2',
        };
    }
}