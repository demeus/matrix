<?php

namespace App\Orchid\Layouts\Service;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class EditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('service.id')->type('hidden'),
            Input::make("service.title")->title(__("services.attributes.title"))->horizontal()->maxlength(255),
            Input::make("service.slug")->title(__("services.attributes.slug"))->horizontal(),
            Input::make("service.position")->type("number")->title(__("services.attributes.position"))->horizontal(),
            TextArea::make("service.description")->title(__("services.attributes.description"))->maxlength(
                255
            )->horizontal(),

            Cropper::make("services.image")
                ->horizontal()
                ->storage("images")
                ->title(__("services.attributes.image"))
                ->height(380),

            Quill::make("service.content")->title(__("services.attributes.content"))
                ->popover(
                    'Quill is a free, open source WYSIWYG editor built for the modern web.'
                ),

            CheckBox::make('service.active')
                ->sendTrueOrFalse()
                ->title('services.attributes.active')
                ->placeholder(__("services.attributes.active")),
        ];
    }
}
