<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Decorations\Column;
use Leeto\MoonShine\Decorations\Grid;
use Leeto\MoonShine\Fields\BelongsToMany;
use Leeto\MoonShine\Fields\Date;
use Leeto\MoonShine\Fields\Number;
use Leeto\MoonShine\Fields\Select;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Fields\Url;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Decorations\Block;
use Leeto\MoonShine\Actions\FiltersAction;

class GameResource extends Resource
{
	public static string $model = 'App\Models\Game';

	public static string $title = 'Игры';

	public static string $subTitle = 'Управление графиком игр';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    const TYPE_GAME = ['Классика', 'НЕклассика', 'КМИ', 'Музыкальный', 'Кино', 'Тематический'];

	public function fields(): array
	{
		return [
            Grid::make([
                Column::make([
                    Block::make('Основная информация', [
                        ID::make()->sortable(),
                        Text::make('Заголовок', 'title'),
                        Select::make('Тип игры', 'type')->options(self::TYPE_GAME),
                        Url::make('Ссылка на презентацию', 'url_presentation'),
                        Date::make('Дата игры', 'day_event')->format('d.m.Y'),
                        Text::make('Место проведения', 'place'),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make('Финансы', [
                        Number::make('Расход', 'expense'),
                        Number::make('Доход', 'revenue'),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make('Команды', [
                        BelongsToMany::make('Список команд', 'teams', 'title')
                            ->hideOnIndex(),
                        BelongsToMany::make('Количество команд', 'teams', 'title')
                            ->showOnIndex()
                            ->hideOnForm()
                            ->hideOnDetail()
                            ->onlyCount(),
                    ]),
                ])->columnSpan(12)
            ]),

        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
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
