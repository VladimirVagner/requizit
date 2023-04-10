<?php

namespace App\Providers;

use App\MoonShine\Resources\GameResource;
use App\MoonShine\Resources\TeamResource;
use App\MoonShine\Resources\VoucherResource;
use Illuminate\Support\ServiceProvider;
use Leeto\MoonShine\MoonShine;
use Leeto\MoonShine\Menu\MenuGroup;
use Leeto\MoonShine\Menu\MenuItem;
use Leeto\MoonShine\Resources\MoonShineUserResource;
use Leeto\MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuGroup::make(__('moonshine::ui.resource.system'), [
                MenuItem::make(__('moonshine::ui.resource.admins_title'), new MoonShineUserResource())
                    ->icon('users'),
                MenuItem::make(__('moonshine::ui.resource.role_title'), new MoonShineUserRoleResource())
                    ->icon('bookmark'),
            ]),

            GameResource::class,
            TeamResource::class,
            VoucherResource::class,
//
//            MenuItem::make(__('moonshine::ui.resource.teams'), new MoonShineUserRoleResource())
//                ->badge(fn() => 'Check'),
//
//            MenuItem::make(__('moonshine::ui.resource.voucher'), new MoonShineUserRoleResource())
        ]);
    }
}
