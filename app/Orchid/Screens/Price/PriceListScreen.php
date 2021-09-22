<?php

namespace App\Orchid\Screens\Price;

use App\Models\Price;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PriceListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'prices.index';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'services' => Service::where("active", true)->orderBy("position")->get(),
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
            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return $this->getServicesPrice();
    }


    public function save(Request $request): RedirectResponse
    {
        try {
            foreach ($request->get('service') ?? [] as $service_id => $values) {
                Service::where('id', $service_id)->update(['price' => $values]);

            }
            Toast::info(__("crud.update_success"));
            return redirect()->back();
        } catch (\Exception $exception) {
            Toast::info($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }


    private function getServicesPrice(): array
    {
        $matrix = [];
        foreach ($this->query()['services'] as $service) {
            $matrix[$service->id] =
                Layout::rows(
                    [
                        Matrix::make('service.'.$service->id)
                            ->columns(
                                [
                                    'Title' => 'title',
                                    'Price' => 'price',
                                ]
                            )
                            ->value($service->price)
                            ->fields(
                                [
                                    'title' => Input::make()->name("title"),
                                    'price' => Input::make()->name("price"),
                                ]
                            )

                    ]
                )->title($service->title);
        }
        return $matrix;
    }
}
