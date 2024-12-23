<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
//header("Access-Control-Allow-Origin: *");
$router->get('/', function () {
    echo "Ok";
});

$router->group(
    ['prefix' => 'api'],
    function ($router) {
        $router->post('/login', ['uses' => 'LicenseController@login']);
        $router->post('/check', ['uses' => 'LicenseController@check']);
        $router->post('/register', ['uses' => 'LicenseController@register']);
        $router->post('/forgot_password', ['uses' => 'LicenseController@forgotPassword']);
        $router->get('/email_confirm', ['uses' => 'LicenseController@emailConfirm']);
        $router->get('/get_settings', ['uses' => 'SettingsController@getSettings']);
		$router->get('/kutuphane', ['uses' => 'SettingsController@kutuphane']);
        $router->get('/get_settings2', ['uses' => 'SettingsController@getSettings2']);
        $router->get('/get_news', ['uses' => 'SettingsController@getNews']);
        $router->get('/youtube', ['uses' => 'SettingsController@getYoutube']);
        $router->get('/sozler', ['uses' => 'SettingsController@sozler']);
         $router->post('/updateDuyuru', ['uses' => 'SettingsController@updateDuyuru']);
         $router->post('/updateSms', ['uses' => 'SettingsController@updateSms']);
         // $router->get('/deneme', ['uses' => 'LicenseController@getUserlog']);
		 // $router->post('/{id}', ['uses' => 'LicenseController@updateLicense']);
         $router->post('/updateWhatsapp', ['uses' => 'SettingsController@updateWhatsapp']);
        $router->put('/update_credit', ['uses' => 'LicenseController@updateCredit']);
    }
);

$router->group(
    ['prefix' => 'api', 'middleware' => 'admin_check'],
    function ($router) {
        $router->get('/', ['uses' => 'LicenseController@getLicenses']);
        
        $router->get('/{id}', ['uses' => 'LicenseController@getLicenseById']);
        $router->get('/mc/{code}', ['uses' => 'LicenseController@getLicenseByMachineCode']);
        $router->post('/', ['uses' => 'LicenseController@createLicense']);
        $router->put('/{id}', ['uses' => 'LicenseController@updateLicense']);
        $router->put('/addition/{id}', ['uses' =>'LicenseController@updateAddition']);
        $router->delete('/{id}', ['uses' => 'LicenseController@destroyLicense']);
        $router->post('/change_password', ['uses' => 'LicenseController@changePasswordLicense']);
    }
);
