<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

use App\Filament\Resources;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;

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
    public function boot(User $user)
    {
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
        });
        // Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
        //     return $builder->groups([
        //         NavigationGroup::make('')
        //         ->collapsible(false)
        //         ->items([
        //             NavigationItem::make('Dashboard')
        //                 ->icon('heroicon-o-home')
        //                 ->activeIcon('heroicon-s-home')
        //                 ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
        //                 ->url(route('filament.pages.dashboard')
        //             ),
        //         ]),
        //         NavigationGroup::make('Master Data')
        //             ->collapsible(true)
        //             ->items([
        //                 ...Resources\BagianResource::getNavigationItems(),
        //                 ...Resources\UserResource::getNavigationItems(),
        //                 ...Resources\KategoriSuratResource::getNavigationItems()
        //             ]),
        //         NavigationGroup::make('Surat')
        //             ->collapsible(false)
        //             ->items([
        //                 ...Resources\SuratMasukResource::getNavigationItems()
        //             ]),
        //         NavigationGroup::make('Laporan')
        //             ->collapsible(false)
        //             ->items([
                        
        //             ]),
        //         NavigationGroup::make('Pengaturan')
        //             ->collapsible(false)
        //             ->items([
        //                 ...Resources\RoleResource::getNavigationItems(),
        //                 ...Resources\PermissionResource::getNavigationItems()
        //             ])->visible(function () {
        //                 if (Auth::check() && Auth::user()->hasRoles('admin')) {
        //                     return true;
        //                 }

        //                 return false;
        //             }),
        //     ]);
        // });
    }
}
