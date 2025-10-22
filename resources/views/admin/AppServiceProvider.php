<?php

namespace App\Providers;

use App\View\Components\jaringan\roll_out_plan_jartaplok_bwa;
use App\View\Components\jaringan\roll_out_plan_jartaplok_packet_switched;
use App\View\Components\jaringan\roll_out_plan_jartup_skkl;
use App\View\Components\jaringan\roll_out_plan_jartup_fo_ter;
use App\View\Components\jaringan\roll_out_plan_jartup_mw_link;
use App\View\Components\jaringan\roll_out_plan_jartup_visat;
use App\View\Components\jaringan\roll_out_plan_jartup_satelit;
use App\View\Components\jaringan\roll_out_plan_jarber_radio_trunking;
use App\View\Components\jaringan\roll_out_plan_jarber_satelit;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use App\View\Components\rencanausaha;
use App\View\Components\rencanausaha_v2;
use App\View\Components\rencanausaha_v3;
use App\View\Components\rencanausaha_v4;
use App\View\Components\rencanausaha_v5;
use App\View\Components\perizinan;
use App\View\Components\cakupanwilayahtelsus_skrk;
use App\View\Components\cakupanwilayahtelsus_skrt;
use App\View\Components\cakupanwilayahtelsus_skrd;
use App\View\Components\cakupanwilayahtelsus_sks;
use App\View\Components\cakupanwilayahtelsus_mtk;
use App\View\Components\fe_register_pt;
use App\View\Components\fe_register_pj;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Request;


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
     * skrk


     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        Blade::component('rencanausaha', rencanausaha::class);
        Blade::component('rencanausaha_v2', rencanausaha_v2::class);
        Blade::component('rencanausaha_v3', rencanausaha_v3::class);
        Blade::component('rencanausaha_v4', rencanausaha_v4::class);
        Blade::component('rencanausaha_v5', rencanausaha_v5::class);

        Blade::component('perizinan', perizinan::class);
        Blade::component('cakupanwilayahtelsus_skrk', cakupanwilayahtelsus_skrk::class);
        Blade::component('cakupanwilayahtelsus_skrt', cakupanwilayahtelsus_skrt::class);
        Blade::component('cakupanwilayahtelsus_skrd', cakupanwilayahtelsus_skrd::class);
        Blade::component('cakupanwilayahtelsus_sks', cakupanwilayahtelsus_sks::class);
        Blade::component('cakupanwilayahtelsus_mtk', cakupanwilayahtelsus_mtk::class);

        Blade::component('roll_out_plan_jartaplok_bwa', roll_out_plan_jartaplok_bwa::class);
        Blade::component('roll_out_plan_jartaplok_packet_switched', roll_out_plan_jartaplok_packet_switched::class);
        Blade::component('roll_out_plan_jartup_skkl', roll_out_plan_jartup_skkl::class);
        Blade::component('roll_out_plan_jartup_fo_ter', roll_out_plan_jartup_fo_ter::class);
        Blade::component('roll_out_plan_jartup_mw_link', roll_out_plan_jartup_mw_link::class);
        Blade::component('roll_out_plan_jartup_visat', roll_out_plan_jartup_visat::class);
        Blade::component('roll_out_plan_jartup_satelit', roll_out_plan_jartup_satelit::class);
        Blade::component('roll_out_plan_jarber_radio_trunking', roll_out_plan_jarber_radio_trunking::class);
        Blade::component('roll_out_plan_jarber_satelit', roll_out_plan_jarber_satelit::class);

        Blade::component('fe_register_pt', fe_register_pt::class);
        Blade::component('fe_register_pj', fe_register_pj::class);
        
        // TIMESTAMP INDONESIA
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        // END TIMESTAMP INDONESIA
        // FORCE HTTPS
    //    if (env('APP_ENV') !== 'local') {
    //    if (explode('://', Request::root())[0] == 'https') {
            URL::forceScheme('https');
    //    }
    if($this->app->environment('production')) {
        \URL::forceScheme('https');
    }
    }
}
