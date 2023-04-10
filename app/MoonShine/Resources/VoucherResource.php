<?php

namespace App\MoonShine\Resources;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\Checkbox;
use Leeto\MoonShine\Fields\Date;
use Leeto\MoonShine\Fields\Select;
use Leeto\MoonShine\Fields\SwitchBoolean;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Actions\FiltersAction;

class VoucherResource extends Resource
{
	public static string $model = 'App\Models\Voucher';

	public static string $title = 'Сертификаты';

	public static string $subTitle = 'Список сертификатов';

    const TYPE = ['Скидка 50% на всю команду', 'Индивидуальная скидка на 1 участника 100%'];

	public function fields(): array
	{
        $teams = Team::all(['title', 'id'])->pluck('title', 'id')->toArray();

		return [
		    ID::make()->sortable(),
            Text::make(
                'Код сертификата',
                'code',
                fn ($item) => $item->code ?? Str::upper(Str::random(5)))->readonly(),
            BelongsTo::make('Команда', 'team_id', 'title')->nullable(),
            Select::make('Тип сертификата', 'type')
                ->options(self::TYPE),
            SwitchBoolean::make('Сертификат использован', 'is_used')
                ->readonly()
                ->canSave(fn() => !isset($this->item->is_used) || !(bool)$this->item->is_used)
                ->default(false),
            Date::make('Дата использования', 'day_used')->readonly()->nullable()
                ->hideOnDetail()
                ->hideOnForm()

        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['code'];
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
