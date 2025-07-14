<?php

use App\Enums\LocationEnum;

it('has correct enum values', function () {
    expect(LocationEnum::EU->value)->toBe('EUU');
    expect(LocationEnum::UA->value)->toBe('UAA');
});

it('returns correct label for EU', function () {
    expect(LocationEnum::EU->label())->toBe('EU part');
});

it('returns correct label for UA', function () {
    expect(LocationEnum::UA->label())->toBe('UA part');
});
