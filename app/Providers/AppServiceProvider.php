<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

use App\Filament\Resources;
use Filament\Resources\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder->groups([
                NavigationGroup::make('')
                ->collapsible(false)
                ->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->activeIcon('heroicon-s-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                        ->url(route('filament.pages.dashboard')
                    ),
                ]),
                NavigationGroup::make('Master Data')
                    ->collapsible(true)
                    ->items([
                        ...Resources\BagianResource::getNavigationItems(),
                        ...Resources\UserResource::getNavigationItems(),
                        ...Resources\KategoriSuratResource::getNavigationItems()
                    ]),
                NavigationGroup::make('Surat')
                    ->collapsible(false)
                    ->items([
                        ...Resources\SuratMasukResource::getNavigationItems()
                    ]),
                NavigationGroup::make('Laporan')
                    ->collapsible(false)
                    ->items([
                        
                    ]),
            ]);
        });
    }
}
