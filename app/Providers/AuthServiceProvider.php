<?php

namespace App\Providers;

use App\Models\Bagian;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Surat\Kategori;
use App\Models\Surat\Keluar;
use App\Models\Surat\Masuk;
use App\Models\User;
use App\Policies\BagianPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SuratKategoriPolicy;
use App\Policies\SuratKeluarPolicy;
use App\Policies\SuratMasukPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Masuk::class => SuratMasukPolicy::class,
        Bagian::class => BagianPolicy::class,
        Kategori::class => SuratKategoriPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Keluar::class => SuratKeluarPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
