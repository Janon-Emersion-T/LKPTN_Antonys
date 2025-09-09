<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('admin.categories');

    $component->assertSee('');
});
