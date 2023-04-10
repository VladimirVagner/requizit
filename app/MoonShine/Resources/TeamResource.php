<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\Phone;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class TeamResource extends Resource
{
	public static string $model = 'App\Models\Team';

	public static string $title = 'Команды';

    public static string $subTitle = 'Список команд';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            Text::make('Название', 'title'),
            Text::make('Имя', 'contact_name'),
            Phone::make('Телефон', 'contact_phone')->mask('+7 (999) 999-99-99'),
        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
