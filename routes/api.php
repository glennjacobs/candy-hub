<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Channels
 */
Route::resource('channels', 'ChannelController', [
    'except' => ['index', 'edit', 'create']
]);


/**
 * Products
 */
Route::resource('products', 'ProductController', [
    'except' => ['index', 'edit', 'create']
]);

/**
 * Product families
 */
Route::resource('product-families', 'ProductFamilyController', [
    'except' => ['index', 'edit', 'create']
]);

/**
 * Attribute Groups
 */
Route::put('attribute-groups/order', 'AttributeGroupController@reorder');
Route::resource('attribute-groups', 'AttributeGroupController', [
    'except' => ['edit', 'create']
]);

/**
 * Attributes
 */
Route::put('attributes/order', 'AttributeController@reorder');
Route::resource('attributes', 'AttributeController', [
    'except' => ['edit', 'create']
]);

/**
 * Languages
 */
Route::resource('languages', 'LanguageController', [
    'except' => ['edit', 'create']
]);

/**
 * Currencies
 */
Route::resource('currencies', 'CurrencyController', [
    'except' => ['edit', 'create']
]);

/**
 * Taxes
 */
Route::resource('taxes', 'TaxController', [
    'except' => ['edit', 'create']
]);

/**
 * Plugins
 */
Route::post('/plugins/install', 'PluginController@postInstall');

/**
 * Users
 */
Route::get('users/current', 'UserController@getCurrentUser');
Route::resource('users', 'UserController', [
    'except' => ['edit', 'create']
]);

/**
 * Pages
 */
Route::get('/pages/{channel}/{lang}/{slug?}', 'PageController@show');
Route::resource('pages', 'PageController', [
    'except' => ['edit', 'create']
]);

/**
 * Layouts
 */
$this->resource('layouts', 'LayoutController', [
    'except' => ['edit', 'create']
]);
