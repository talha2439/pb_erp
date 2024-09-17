<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use PSpell\Config;

class SettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $settingsData = $this->settings();
        config([
            'setting.site_name' => $settingsData->site_name ?? "" ,
            'setting.site_url'=> $settingsData->site_url ?? "",
            'setting.favicon' => $settingsData->favicon ?? "",
            'setting.logo' => $settingsData->logo ?? "" ,
            'setting.light_logo' => $settingsData->light_logo ?? "",
            'setting.meta_title' => $settingsData->meta_title ?? "",
            'setting.meta_description' => $settingsData->meta_description ?? "",
            'setting.meta_keywords' => $settingsData->meta_keywords ?? "",
        ]);
        env('APP_URL' , $settingsData->site_url ?? "");
    }
    public function settings(){
        if(Schema::hasTable('settings')){
            $settings = Setting::latest()->first();
            if(!empty($settings)){
                return $settings;
            }
            else{
                return false;
            }
        }
    }
}


