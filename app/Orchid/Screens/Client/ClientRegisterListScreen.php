<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Models\Register;
use App\Orchid\Layouts\Register\RegisterListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ClientRegisterListScreen extends Screen
{
    public $client;

    public function query(Client $client): iterable
    {
        $this->client = $client;
        $registers = Register::where('client_id', $client->id)->filters()->paginate(14);

        return [
            'registers' => $registers
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->firstname . ' ' . $this->client->lastname;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Regresar'))
                ->icon('bs.arrow-bar-left')
                ->href(route('platform.clients.view', $this->client)),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            RegisterListLayout::class,
        ];
    }
}
