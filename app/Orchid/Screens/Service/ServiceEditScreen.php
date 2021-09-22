<?php

namespace App\Orchid\Screens\Service;

use App\Http\Requests\Admin\PostRequest;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Orchid\Layouts\Service\EditLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ServiceEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */

    public $name = 'services.manage';

    protected Service $service;
    private bool $exist = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Service $service): array
    {
        $this->exist = $service->exists;
        $this->service = $service;
        return [
            'service' => $this->service
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
            Link::make(__('crud.cancel'))
                ->icon('action-undo')
                ->route('platform.services'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->confirm(__("crud.delete_confirm"))
                ->canSee($this->exist),

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
        return [
            EditLayout::class
        ];
    }

    public function save(Service $service, ServiceRequest $request): RedirectResponse
    {
        try {
            $service->fill($request->get('service'));
            $service->save();
            Toast::info(__("crud.update_success"));
            return redirect()->route('platform.services');
        }
        catch (\Exception $exception){
            Toast::error($exception->getMessage());
            return redirect()->back()->withInput();
        }

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
