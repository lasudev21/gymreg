<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class ClientPresenter extends Presenter
{
    public function fullName(): string
    {
        return $this->entity->firstName . ' ' . $this->entity->lastName;
    }
}
