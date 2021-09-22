<?php

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Orchid\Layouts\Service\ListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ServiceListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'services.services';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'services' => Service::filters()->defaultSort(
                'position'
            )->paginate(20)
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('crud.add_a_new'))
                ->icon('plus')
                ->route('platform.services.create'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ListLayout::class
        ];
    }


    /**
     * @param Service $service
     * @return RedirectResponse
     *
     */
    public function remove(Service $service): RedirectResponse
    {
        $service->delete();
        Toast::info(__('crud.delete_confirmation_message'));
        return redirect()->route('platform.services');
    }
}
