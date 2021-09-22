<?php

namespace App\Orchid\Layouts\Service;

use App\Models\Service;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class ListLayout extends Table
{
    protected $target = 'services';


    protected function columns(): array
    {
        return [
            TD::make('position', 'Position')->width('100px')->sort(),
            TD::make('title', __('services.attributes.title'))
                ->sort()
                ->cantHide()
                ->render(function (Service $service) {
                    return Link::make($service->title)
                        ->route('platform.services.edit', $service->id);
                }),

            TD::make('slug', 'slug')->sort(),

            TD::make('active', 'Active')->render(function (Service $service) {
                return $service->active === true
                    ? '<i class="text-success">●</i> Active'
                    : '<i class="text-danger">●</i> Not active';
            })->sort(),

            TD::make('actions', __("crud.actions"))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Service $service) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                                   Link::make(__("crud.edit"))
                                       ->icon('pencil')
                                       ->route('platform.services.edit', $service),

                                   Button::make(__('Delete'))
                                       ->icon('trash')
                                       ->confirm(__("crud.delete_confirm"))
                                       ->method('remove', [
                                           'id' => $service->id,
                                       ]),
                               ]);
                }),
        ];
    }
}
