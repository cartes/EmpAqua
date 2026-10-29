<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\OfferController as OfferController;
use App\Http\Controllers\UserController as UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BusinessController; 

Route::get('/', "Controller@index")->name('/');
Route::get('/home', 'Controller@index')->name('home');


Route::get('/register', function () {
    return view('user.register');
})->name('register');
Route::get('/terms', function () {
    return view('terminos');
})->name('terms');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/resetPasswordForm', function () {
    return view('user.resetPas');
})->name('resetPasswordForm');
Route::get('/resetPasswordBusinessForm', function () {
    return view('business.resetPas');
})->name('resetPasswordBusinessForm');
Route::post('/resetPassword', 'AcoountController@resetPassword')->name('resetPassword');
Route::post('/resetBusinessPassword', 'AcoountController@resetBusinessPassword')->name('resetBusinessPassword');
Route::post('/sendNewPassword', 'AcoountController@changePassword')->name('sendNewPasswword');
Route::post('/sendNewBusinessPassword', 'AcoountController@changeBusinessPassword')->name('sendNewBusinessPasswword');
Route::get('/password/reset/{token}', 'AcoountController@showForm');
Route::get('/passwordBusiness/reset/{token}', 'AcoountController@showBusinessForm');

Route::post('/login', 'UserController@login')->middleware('throttle:10,1')->name('login');
Route::post('/logout', 'UserController@logout')->name('logout');
Route::post('/store', 'UserController@store')->name('store');
Route::get('/prices', function () {
    return view("prices");
})->name('prices');
Route::get('/about', function () {
    return view("about");
})->name('about');

Route::get('/contacto', "ContactController@getContactPage")->name('contactPage');
Route::post("/contacto", "ContactController@saveContact")->name('contact');


Route::group(["prefix" => "profile"], function () {
    Route::group(["middleware" => ["redhome"]], function () {
        Route::get('/', 'ProfileController@index')->name('profile');
        Route::get('/view', 'ProfileController@view')->name('profile.view');
        Route::put('profile/update', 'ProfileController@update')->name('profile.update');
        Route::put('profile/salary', 'ProfileController@salary')->name('profile.salary');
        Route::put('profile/contact', 'ProfileController@contact')->name('profile.contact');
        Route::get('/experience/{id}', [ProfileController::class, 'getExperience'])->name('profile.getExperience');
        Route::put('profile/experience', 'ProfileController@experience')->name('profile.experience');
        Route::put('profile/experience/update', [ProfileController::class, 'updateExperience'])->name('profile.experience.update');
        Route::post('profile/education', 'ProfileController@education')->name('profile.education');
        Route::put('profile/education/update', [ProfileController::class, 'updateEducation'])->name('profile.education.update');
        Route::get('/profile/education/{id}', [ProfileController::class, 'editEducation'])->name('profile.education.edit');
        Route::put('profile/objectives', 'ProfileController@objectives')->name('profile.objectives');
        Route::put('profile/languages', 'ProfileController@languages')->name('profile.languages');
        Route::post('profile/references', "ProfileController@references")->name("profile.references");
        Route::put('/profile/references/', [ProfileController::class, 'updateReference'])->name('profile.references.update');
        Route::get('/profile/references/{id}', [ProfileController::class, 'editReference'])->name('profile.references.edit');
        Route::put('profile/skills', 'ProfileController@skills')->name('profile.skills');
        Route::match(['put', 'post'], 'profile/resume', 'ProfileController@resume')->name('profile.resume');
        Route::post('/api/eraseFile', 'ProfileController@eraseFile')->name('profile.eraseFile');
    }); //
    Route::delete('/api/eraseExp', [ProfileController::class, 'eraseExp'])->middleware('redhome');
    Route::delete('/api/eraseEducation', [ProfileController::class, 'eraseEducation'])->middleware('redhome');
    Route::delete('/api/eraseReference', [ProfileController::class, 'eraseReference'])->middleware('redhome');
    Route::delete('/api/eraseSkill', [ProfileController::class, 'eraseSkill'])->middleware('redhome');
    
});

Route::prefix('posts')->group(function () {
    Route::get('create', 'PostController@postCreateForm')->name('post.create')->middleware(['redhome']);
    Route::put('register', 'PostController@register')->name('post.register')->middleware(['redhome']);
});

Route::prefix('business')->group(function () {
    Route::get('/show_admin/{id}/', [BusinessController::class, 'show_superadmin'])->name('business.showadmin');
    Route::get('index', 'BusinessController@index')->name('business.index');
    Route::get('/login', 'BusinessController@index');
    Route::post('/login', 'BusinessController@login')->middleware('throttle:10,1')->name('business.login');
    Route::post('register', 'BusinessController@register')->name('business.register');
    Route::get('profile', 'BusinessController@profileIndex')->name('business.profile')->middleware(['redhome']);
    Route::put('update', 'BusinessController@updateProfile')->name('business.update')->middleware('business');
    Route::get('edit', 'BusinessController@edit')->name('business.edit')->middleware('business');
    Route::get('/{id}/file', 'BusinessController@file')->name("business.file");
    Route::post('/pass_change', 'BusinessController@change_passw')->name('business.passchange')->middleware('business');
    Route::get('/pass_form', function () {
        return view('business.migrated');
    })->name('business.passform');
    Route::get('/roles', 'BusinessController@list')->name('business.roles')->middleware(['admin']);
    Route::post('/list_membership', 'BusinessController@list_membership')->name('business.membership')->middleware('admin');
    Route::get('/getMembers', 'BusinessController@ajax')->name('members.roles')->middleware('admin');
});

Route::prefix('offer')->group(function () {
    Route::get('/{offer}/postulate', 'OfferController@postulate')->name('offer.postulate');
    Route::get('/index', 'OfferController@index')->name('offer.admin')->middleware(['redhome']);
    Route::get('/list', 'OfferController@list')->name('offer.list');
    Route::get( '/featured', [OfferController::class, 'list_featured'])->name('offer.featured');
    Route::get('/{offer}/edit', 'OfferController@detail')->name('offer.detail')->middleware('business');
    Route::post('/create', 'OfferController@create')->name('offer.create')->middleware('business');
    Route::post("/{offer}/store", [OfferController::class, 'store'])->name("offer.store")->middleware('business');
    Route::post("/{offer}/unpublish", [OfferController::class, 'unpublish'])->name("offer.unpublish")->middleware('business');
    Route::post("/{offer}/republish", [OfferController::class, 'republishState'])->name("offer.republish")->middleware('business');
    Route::delete("/{offer}/destroy", "OfferController@destroy")->name("offer.delete")->middleware('business');
    Route::get("/show/{slug}/{search?}", "OfferController@show")->name("offer.show");
    Route::get('/{slug}/candidates', 'OfferController@candidates')->name('offer.candidates')->middleware(['redhome']);
    Route::post('/candidate/update-status', [OfferController::class, 'updateCandidateStatus'])->name('candidate.updateStatus')->middleware('business');
    Route::get('/{slug}/allCandidates', [OfferController::class, 'all_candidates'])->name('offer.allcandidates')->middleware(['redhome']);
    Route::post('/allCandidatesData', [OfferController::class, 'all_candidates_data'])->name('offer.all_data')->middleware(['redhome']);
    # Route::post('/selectCandidate', [OfferController::class, 'all_candidates_data'])->name("offer.select_candidate")->middleware(['redhome']);
    Route::put('/{slug}/republish', 'OfferController@republish')->name('offer.republish')->middleware('business');
    Route::get('/{slug}/getajax', 'OfferController@ajax')->name('offer.ajax');
    Route::post('/featured/', 'OfferController@featured')->name('offer.featured')->middleware('business');
    Route::post('/favorite/', [OfferController::class, 'favorite'])->name('offer.favorite');
    Route::post('/addFavoriteCandidate', [OfferController::class, 'addFavoriteCandidate'])->name('offer.addFavorite')->middleware('business');
});

Route::prefix('role')->group(function () {
    Route::put('/edit/{id}', 'RoleController@edit')->name('role.edit')->middleware('admin');
});

Route::prefix('user')->group(function () {
    Route::get('/offers', "UserController@showoffers")->name('user.offers')->middleware(['redhome']);
    Route::get('/favorites/', [UserController::class, 'favorites'])->name('user.favorites')->middleware('redhome');
    Route::get('/alerts', 'UserController@alerts')->name("user.alerts")->middleware(['redhome']);
});

Route::prefix('userfile')->group(function () {
    Route::get('/file/{id}/{offer?}', "UserController@file")->name('user.file')->middleware(['redhome']);

});

Route::prefix('message')->group(function () {
    Route::post('/show', "MessageController@show")->name("message.show")->middleware(['redhome']);
    Route::post('/send', "MessageController@send")->name("message.send")->middleware(['redhome']);
    Route::post('/reply', "MessageController@reply")->name("message.reply")->middleware(['redhome']);
});
Route::post('/search', 'SearchController@result')->name('search');

Route::get('/newsletter', [NewsletterController::class, 'show']);
