<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('/');
Route::get('/home', HomeController::class)->name('home');

Route::view('/register', 'user.register')->name('register');
Route::view('/terms', 'terminos')->name('terms');
Route::view('/faq', 'faq')->name('faq');
Route::view('/prices', 'prices')->name('prices');
Route::view('/about', 'about')->name('about');

Route::view('/resetPasswordForm', 'user.resetPas')->name('resetPasswordForm');
Route::view('/resetPasswordBusinessForm', 'business.resetPas')->name('resetPasswordBusinessForm');

Route::controller(AccountController::class)->group(function () {
    Route::post('/resetPassword', 'resetPassword')->name('resetPassword');
    Route::post('/resetBusinessPassword', 'resetBusinessPassword')->name('resetBusinessPassword');
    Route::post('/sendNewPassword', 'changePassword')->name('sendNewPasswword');
    Route::post('/sendNewBusinessPassword', 'changeBusinessPassword')->name('sendNewBusinessPasswword');
    Route::get('/password/reset/{token}', 'showForm');
    Route::get('/passwordBusiness/reset/{token}', 'showBusinessForm');
});

Route::post('/login', [UserController::class, 'login'])->middleware('throttle:10,1')->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/store', [UserController::class, 'store'])->name('store');

Route::get('/contacto', [ContactController::class, 'getContactPage'])->name('contactPage');
Route::post('/contacto', [ContactController::class, 'saveContact'])->name('contact');

Route::prefix('profile')->middleware('redhome')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::get('/view', 'view')->name('profile.view');
    Route::put('profile/update', 'update')->name('profile.update');
    Route::put('profile/salary', 'salary')->name('profile.salary');
    Route::put('profile/contact', 'contact')->name('profile.contact');
    Route::get('/experience/{id}', 'getExperience')->name('profile.getExperience');
    Route::put('profile/experience', 'experience')->name('profile.experience');
    Route::put('profile/experience/update', 'updateExperience')->name('profile.experience.update');
    Route::post('profile/education', 'education')->name('profile.education');
    Route::put('profile/education/update', 'updateEducation')->name('profile.education.update');
    Route::get('/profile/education/{id}', 'editEducation')->name('profile.education.edit');
    Route::put('profile/objectives', 'objectives')->name('profile.objectives');
    Route::put('profile/languages', 'languages')->name('profile.languages');
    Route::post('profile/references', 'references')->name('profile.references');
    Route::put('/profile/references/', 'updateReference')->name('profile.references.update');
    Route::get('/profile/references/{id}', 'editReference')->name('profile.references.edit');
    Route::put('profile/skills', 'skills')->name('profile.skills');
    Route::match(['put', 'post'], 'profile/resume', 'resume')->name('profile.resume');
    Route::post('/api/eraseFile', 'eraseFile')->name('profile.eraseFile');
    Route::delete('/api/eraseExp', 'eraseExp');
    Route::delete('/api/eraseEducation', 'eraseEducation');
    Route::delete('/api/eraseReference', 'eraseReference');
    Route::delete('/api/eraseSkill', 'eraseSkill');
});

Route::prefix('posts')->middleware('redhome')->group(function () {
    Route::get('create', [PostController::class, 'postCreateForm'])->name('post.create');
});

Route::prefix('business')->controller(BusinessController::class)->group(function () {
    Route::get('/show_admin/{id}/', 'show_superadmin')->name('business.showadmin');
    Route::get('index', 'index')->name('business.index');
    Route::get('/login', 'index');
    Route::post('/login', 'login')->middleware('throttle:10,1')->name('business.login');
    Route::post('register', 'register')->name('business.register');
    Route::get('profile', 'profileIndex')->name('business.profile')->middleware('redhome');
    Route::put('update', 'updateProfile')->name('business.update')->middleware('business');
    Route::get('edit', 'edit')->name('business.edit')->middleware('business');
    Route::get('/{id}/file', 'file')->name('business.file');
    Route::post('/pass_change', 'change_passw')->name('business.passchange')->middleware('business');
    Route::view('/pass_form', 'business.migrated')->name('business.passform');
    Route::get('/roles', 'list')->name('business.roles')->middleware('admin');
    Route::post('/list_membership', 'list_membership')->name('business.membership')->middleware('admin');
    Route::get('/getMembers', 'ajax')->name('members.roles')->middleware('admin');
});

Route::prefix('offer')->controller(OfferController::class)->group(function () {
    Route::get('/{offer}/postulate', 'postulate')->name('offer.postulate');
    Route::get('/index', 'index')->name('offer.admin')->middleware('redhome');
    Route::get('/list', 'list')->name('offer.list');
    Route::get('/featured', 'list_featured')->name('offer.featured');
    Route::get('/{offer}/edit', 'detail')->name('offer.detail')->middleware('business');
    Route::post('/create', 'create')->name('offer.create')->middleware('business');
    Route::post('/{offer}/store', 'store')->name('offer.store')->middleware('business');
    Route::post('/{offer}/unpublish', 'unpublish')->name('offer.unpublish')->middleware('business');
    Route::post('/{offer}/republish', 'republishState')->name('offer.republish')->middleware('business');
    Route::delete('/{offer}/destroy', 'destroy')->name('offer.delete')->middleware('business');
    Route::get('/show/{slug}/{search?}', 'show')->name('offer.show');
    Route::get('/{offer}/candidates', 'candidates')->name('offer.candidates')->middleware('redhome');
    Route::post('/candidate/update-status', 'updateCandidateStatus')->name('candidate.updateStatus')->middleware('business');
    Route::get('/{offer}/allCandidates', 'all_candidates')->name('offer.allcandidates')->middleware('redhome');
    Route::post('/allCandidatesData', 'all_candidates_data')->name('offer.all_data')->middleware('redhome');
    Route::put('/{offer}/republish', 'republish')->name('offer.republish')->middleware('business');
    Route::get('/{offer}/getajax', 'ajax')->name('offer.ajax');
    Route::post('/featured/', 'featured')->name('offer.featured')->middleware('business');
    Route::post('/favorite/', 'favorite')->name('offer.favorite');
    Route::post('/addFavoriteCandidate', 'addFavoriteCandidate')->name('offer.addFavorite')->middleware('business');
});

Route::put('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('admin');

Route::prefix('user')->middleware('redhome')->controller(UserController::class)->group(function () {
    Route::get('/offers', 'showoffers')->name('user.offers');
    Route::get('/favorites/', 'favorites')->name('user.favorites');
    Route::get('/alerts', 'alerts')->name('user.alerts');
});

Route::get('/userfile/file/{user}/{offer?}', [UserController::class, 'file'])->name('user.file')->middleware('redhome');

Route::prefix('message')->middleware('redhome')->controller(MessageController::class)->group(function () {
    Route::post('/show', 'show')->name('message.show');
    Route::post('/send', 'send')->name('message.send');
    Route::post('/reply', 'reply')->name('message.reply');
});

Route::post('/search', [SearchController::class, 'result'])->name('search');

Route::get('/newsletter', [NewsletterController::class, 'show']);
