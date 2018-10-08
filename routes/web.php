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

Route::get('/', function () {

	if(Auth::guest())
		return view('landing');
	   
	return redirect('/home');
    
});


Route::get('/user/verify/{token}', 'UserController@verifyUser');
Route::get('/user-signup', 'UserController@ShowRegisterForm');
Route::post('/user-signup', 'UserController@UserSignup')->name('user.signup');
Route::get('/user-login', 'Auth\UserLoginController@ShowLoginForm');
Route::post('/user-login', 'Auth\UserLoginController@doLogin')->name('user.login');
Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');



Route::get('admin/', function () {
    if(Auth::guest())
	   return view('admin.login');

	return redirect('admin/home');
});

Route::get('admin/login', function () { 
	if(Auth::guest())
	   return view('admin.login');

    return redirect('admin/home');
});

Route::post('/admin/login', 'Auth\AdminLoginController@index')->name('adminlogin');
Route::get('/admin/change_password', 'Auth\AdminChangePasswordController@showChangePasswordForm')->name('admin.change_password');
Route::post('/admin/change_password', 'Auth\AdminChangePasswordController@changePassword')->name('admin.change_password');


// Permission routes
Route::get('/admin/permission', 'Admin\PermissionController@index')->name('admin.permission');
Route::post('/admin/add-permission', 'Admin\PermissionController@addPermission')->name('admin.addpermission');
Route::post('/admin/update-permission', 'Admin\PermissionController@updatePermission')->name('admin.update-permission');
Route::post('admin/trash', 'Admin\PermissionController@trash')->name('admin.trash');
Route::get('/admin/permissionlist', 'Admin\PermissionController@permissionList')->name('admin.permissionlist');
Route::get('/admin/get-permission-record/{id}','Admin\PermissionController@getRecord')->name('admin.get-permission-record');
Route::get('/admin/get-permission','Admin\PermissionController@getPermissions')->name('admin.get-permission');

// Roles routes
Route::get('/admin/roles', 'Admin\RolesController@index')->name('admin.roles');
Route::get('/admin/role-list', 'Admin\RolesController@roleList')->name('admin.role-list');
Route::post('admin/destory-role', 'Admin\RolesController@destory')->name('admin.destory-role');
Route::post('/admin/update-roles', 'Admin\RolesController@update')->name('admin.update-roles');
Route::post('/admin/add-role', 'Admin\RolesController@store')->name('admin.add-role');
Route::get('/admin/get-role-record/{id}','Admin\RolesController@getRecord')->name('admin.get-roles-record');

// Roles routes
Route::get('/admin/users', 'Admin\UsersController@index')->name('admin.users');
Route::get('/admin/user-list', 'Admin\UsersController@list')->name('admin.user-list');
Route::get('/admin/get-roles','Admin\RolesController@getRoles')->name('admin.get-roles');
Route::post('/admin/add-user', 'Admin\UsersController@store')->name('admin.add-user');




// User signup

// End user signup


//Route::get('/admin/login', ['middleware' => 'auth', 'uses' => 'Auth\AdminLoginController@index']);

//Route::get('/account/sign-out', array(
//		'as' => 'account-sign-out',
//		'uses' => 'AccountController@getSignOut'
//	));

//Route::post('admin/login', 'HomeController@index')->name('home');

Route::post('admin/login', 'Auth\AdminLoginController@postLogin')->name('adminlogin');


Auth::routes();
// Auth routes comments
/*Route::get('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);*/

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);


//Route::get('ad/logout', 'Auth\AdminLoginController@adminLogout')->name('adminlogout');
Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('adminlogout');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    //Route::get('upload', ['as' => 'upload', 'uses' => 'MediaController@index']);
    Route::post('/document/store', ['as'=>'document.store','uses'=>'ServiceController@documentStore']);
	Route::post('/document/delete',['as'=>'document.delete','uses'=>'ServiceController@fileDestroy']);
	Route::post('/company-logo/upload',['as'=>'company-logo.upload','uses'=>'ServiceController@logoStore']);
	
	Route::post('/service/info', ['as'=>'service.info','uses'=>'ServiceController@storeServiceInfo']);

	//Route::get('/company-profile/user',['as'=>'company-profile.user','uses'=>'ServiceController@getUserCompanyProfile']);
	Route::get('/company-profile/user','ServiceController@getUserCompanyProfile')->name('user.company-profile');
	Route::get('/shared-services-to-user','ServiceController@getForUserSharedService')->name('user.services-by-users');
	Route::get('/get-services-from-user','ServiceController@getServicesFromOtherUser')->name('user.services-for-users');
	Route::get('/search-service-subscriber','ServiceController@searchSubscriberServices')->name('user.search-services-subscriber');
	Route::get('/search-service-from-user','ServiceController@searchUserServices')->name('user.search-user-services-invited');
	Route::post('/leave-service-from-user','ServiceController@leaveService')->name('user.leave-service');
	Route::post('/delete-service-from-user','ServiceController@deleteService')->name('user.delete-service');
	Route::post('/company-info/user','ServiceController@storeCompanyinfo')->name('user.company-information');
	Route::post('/service/invited-user', ['as'=>'service.user-list','uses'=>'ServiceDetailController@getServiceInvitedUserList']);
	Route::post('/service/update-user-access', ['as'=>'update.user-access','uses'=>'ServiceDetailController@updateUserWithAccess']);
	Route::post('/service/remove-user-access', ['as'=>'remove.user-access','uses'=>'ServiceDetailController@removeUserWithAccess']);
	Route::post('/service/check-existing-invitation', ['as'=>'user.check-before','uses'=>'ServiceDetailController@checkExistingInvitedUser']);
	Route::post('/service/service-document-list',['as'=>'service.service-document-list','uses'=>'ServiceDetailController@getServiceDocList']);
	Route::post('/service/document-list', ['as'=>'service.document-list','uses'=>'ServiceDetailController@getServiceDocumentList']);

	Route::get('/service-detail/{id}/detail','ServiceDetailController@index');
	Route::post('/service-detail/invite', ['as'=>'user.invite','uses'=>'ServiceDetailController@inviteUsers']);
});



// Save service Inofrmation

Route::get('/admin/home', 'Admin\HomeController@index')->name('adminhome');


//Route::get('/admin/home', 'Admin\HomeController@index')->name('admin.home');
