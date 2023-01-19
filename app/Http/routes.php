<?php

Route::get('/please_change_password', ['as' => 'please_change_password', 'uses' => function() {
    return view('pages.please-change-password');
}]);
Route::get('/please_verification', ['as' => 'please_verification', 'uses' => function() {
    return view('pages.please-verification');
}]);

Route::get('/privacy_policy/en', ['as' => 'public.terms_en', 'uses' => 'PublicController@termsEn']);
Route::get('/privacy_policy/id', ['as' => 'public.terms_id', 'uses' => 'PublicController@termsId']);
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/facebook/callback', 'SocialAuthController@callback');
Route::get('/facebook/post', 'SocialAuthController@postToFacebook');
Route::get('/redirect/google', 'SocialAuthController@redirectGoogle');
Route::get('/callback/google', 'SocialAuthController@callbackGoogle');
/*
 * Routes API for official SIP
 */
Route::get('please_reset_password', 'FailedLoginController@resetPassword');
//Route::get('data_verification/', ['middleware' => ['auth'], 'as' => 'data_verification', 'uses' => 'FailedLoginController@dataVerification']);
//Route::post('data_verification/', ['middleware' => ['auth', 'csrf'], 'as' => 'store_data_verification', 'uses' => 'FailedLoginController@storeDataVerification']);
//Route::get('otp', ['middleware' => ['auth', 'csrf'], 'as' => 'request_otp', 'uses' => 'FailedLoginController@requestOtp']);

/*
 * ROUTES FOR MLM
 */
Route::post('api/registration', 'Api\RegistrationController@store');
Route::post('api/member/update', 'Api\RegistrationController@update');
Route::get('api/data/transactions/{service}', 'Api\DataTransactionsController@index');
Route::post('api/data/users/free', 'Api\UsersController@index');
Route::post('api/data/users/find', 'Api\UsersController@find');
Route::post('api/data/users/change_password', 'Api\UsersController@updatePassword');
Route::post('api/data/users/update_password', 'Api\UsersController@setPassword');
Route::post('api/data/users/confirm_update_password', 'Api\UsersController@confirmSetPassword');
Route::post('api/data/users/update_data', 'Api\UsersController@updateUser');
Route::get('api/charities', 'Api\CharityController@index');
Route::post('api/charities', 'Api\CharityController@store');


Route::get('activation', ['middleware' => 'guest', 'uses' => 'ReceiptsController@activation']);
Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
//Route::get('liat_logs_dongs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::auth();
Route::post('/login/otp', ['as' => 'login.otp', 'uses' => 'Auth\AuthController@getOtp']);

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
//Route::any('adminer', '\Miroc\LaravelAdminer\AdminerController@index');
Route::get('/sip/term', ['as' => 'sip.term', 'uses' => 'HomeController@term']);
Route::get('/sip/faq', ['as' => 'sip.faq', 'uses' => 'HomeController@faq']);
Route::get('/sip/announcements', ['as' => 'sip.news', 'uses' => 'HomeController@announcements']);
/*
 * Verification
 */
//Route::get('/authentication', ['as' => 'verification.authPage', 'middleware' => 'guest', 'uses' => 'VerificationController@authPage']);
//Route::post('/authentication', ['as' => 'verification.auth', 'middleware' => 'guest', 'uses' => 'Admin\AuthController@postLogin']);
//Route::get('/verification', ['as' => 'verification.phone_number', 'middleware' => 'auth', 'uses' => 'VerificationController@phoneNumberPage']);
//Route::post('/verification', ['as' => 'verification.post', 'middleware' => 'auth', 'uses' => 'VerificationController@verification']);
/*
 * Routes Airlines
 */
Route::get('/airlines', ['as' => 'airlines.index', 'uses' => 'AirlinesController@index']);
//Route::post('/airlines/get_schedule',['as'=>'airlines.get_schedule','uses'=>'AirlinesController@getSchedule']);
Route::post('/airlines/test_get_schedule', ['as' => 'airlines.test_get_schedule', 'uses' => 'AirlinesController@testGetSchedule']);
Route::post('/airlines/get_schedule_class', ['as' => 'airlines.get_schedule_class', 'uses' => 'AirlinesController@getScheduleClass']);
Route::post('/airlines/get_fare', ['as' => 'airlines.get_fare', 'uses' => 'AirlinesController@getFare']);
Route::post('/airlines/result', ['as' => 'airlines.result', 'uses' => 'AirlinesController@getPageResult']);
Route::post('/airlines/booking', ['as' => 'airlines.booking', 'uses' => 'AirlinesController@booking']);
Route::get('/airlines/cancel/{transaction_id}', ['as' => 'airlines.cancel', 'uses' => 'AirlinesController@cancelBooking']);
Route::post('/airlines/issued/{transaction_id}', ['as' => 'airlines.issued', 'uses' => 'AirlinesController@issued']);
Route::post('/airlines/booking_issued', ['as' => 'airlines.booking_issued', 'uses' => 'AirlinesController@bookingIssued']);
Route::post('/airlines/schedule/', ['as' => 'airlines.schedule', 'uses' => 'AirlinesController@schedule']);
Route::post('/airlines/all_schedule', ['as' => 'airlines.all_schedule', 'uses' => 'AirlinesController@allSchedule']);
Route::post('/airlines/all_schedule_class', ['as' => 'airlines.all_schedule_class', 'uses' => 'AirlinesController@allScheduleClass']);
Route::post('/airlines/all_fares', ['as' => 'airlines.all_fares', 'uses' => 'AirlinesController@allFares']);
//Route::get('/airlines/{id}/payment_method', ['as' => 'airlines.payment_method', 'uses' => 'AirlinesController@paymentMethod']);
//Route::post('/airlines/{id}/payment_method', ['as' => 'airlines.post_payment_method', 'uses' => 'AirlinesController@PostPaymentMethod']);
// Report routes
Route::get('/airlines/reports', ['as' => 'airlines.reports', 'uses' => 'AirlinesController@report']);
Route::get('/airlines/reports/{id}', ['as' => 'airlines.report_show', 'uses' => 'AirlinesController@showReport']);
Route::get('/airlines/checkin', ['as' => 'airlines.checkin', 'uses' => 'AirlinesController@checkin']);

// Receipts
Route::get('/airlines/receipt/{id}', ['as' => 'airlines.receipts', 'uses' => 'ReceiptsController@airlines']);
Route::get('/airlines/receipt/{id}/departure', ['as' => 'airlines.receipts_departure', 'uses' => 'ReceiptsController@airlinesDeparture']);
Route::get('/airlines/receipt/{id}/return', ['as' => 'airlines.receipts_return', 'uses' => 'ReceiptsController@airlinesReturn']);
Route::post('/airlines/{id}/mail', ['as' => 'airlines.send_mail', 'uses' => 'EmailsController@airlinesMail']);
Route::post('get_schedule', ['as' => 'airlines.vue', 'uses' => 'AirlinesController@vue']);
Route::post('get_class', ['as' => 'airlines.vue_2', 'uses' => 'AirlinesController@getScheduleClassPage']);
Route::post('schedule_class_int', ['as' => 'airlines.schedule_class_int', 'uses' => 'AirlinesController@allScheduleClassInt']);
/*
^ Routes Train
 */
Route::post('/trains/result_schedule', ['as' => 'trains.result_schedule', 'uses' => 'TrainsController@getPageSchedule']);
Route::post('/trains/get_schedule', ['as' => 'trains.get_schedule', 'uses' => 'TrainsController@getSchedule']);
Route::post('/trains/booking_form', ['as' => 'trains.booking_form', 'uses' => 'TrainsController@bookingForm']);
Route::post('/trains/set_seat', ['as' => 'trains.set_seat', 'uses' => 'TrainsController@getSeat']);
Route::post('/trains/done', ['as' => 'trains.booking_issued', 'uses' => 'TrainsController@bookingIssued']);
Route::get('/trains/reports', ['as' => 'trains.reports', 'uses' => 'TrainsController@report']);
Route::get('/trains/reports/{id}', ['as' => 'trains.report_show', 'uses' => 'TrainsController@showReport']);
Route::get('/trains/receipt/{id}', ['as' => 'trains.receipts', 'uses' => 'ReceiptsController@train']);
Route::get('/trains/receipt/{id}/departure', ['as' => 'trains.receipts_departure', 'uses' => 'ReceiptsController@trainDeparture']);
Route::get('/trains/receipt/{id}/return', ['as' => 'trains.receipts_return', 'uses' => 'ReceiptsController@trainReturn']);
/*
 * Routes Railink
 */
Route::post('/railinks/result_schedule', ['as' => 'railinks.result_schedule', 'uses' => 'RailinksController@getPageSchedule']);
Route::post('/railinks/get_schedule', ['as' => 'railinks.get_schedule', 'uses' => 'RailinksController@getSchedule']);
Route::post('/railinks/booking_form', ['as' => 'railinks.booking_form', 'uses' => 'RailinksController@bookingForm']);
Route::post('/railinks/set_seat', ['as' => 'railinks.set_seat', 'uses' => 'RailinksController@getSeat']);
Route::post('/railinks/done', ['as' => 'railinks.booking_issued', 'uses' => 'RailinksController@bookingIssued']);
Route::get('/railinks/reports', ['as' => 'railinks.reports', 'uses' => 'RailinksController@report']);
Route::get('/railinks/reports/{id}', ['as' => 'railinks.report_show', 'uses' => 'RailinksController@showReport']);
Route::get('/railinks/receipt/{id}', ['as' => 'railinks.receipts', 'uses' => 'ReceiptsController@railink']);

Route::post('/hotels/search', ['as' => 'hotels.search', 'uses' => 'HotelsController@getSearchPage']);
Route::post('/hotels/search_hotel', ['as' => 'hotels.search_hotel', 'uses' => 'HotelsController@search']);
Route::post('/hotels/search_hotel_by_keyword', ['as' => 'hotels.search_hotel_by_keyword', 'uses' => 'HotelsController@searchByKeyword']);
Route::post('/hotels/search_hotel_by_next', ['as' => 'hotels.search_hotel_by_next', 'uses' => 'HotelsController@searchByNext']);
Route::post('/hotels/search_hotel_sort', ['as' => 'hotels.search_hotel_sort', 'uses' => 'HotelsController@searchBySort']);
Route::post('/hotels/detail', ['as' => 'hotels.hotel_detail', 'uses' => 'HotelsController@hotelDetail']);
Route::post('/hotels/confirmation', ['as' => 'hotels.hotel_confirmation', 'uses' => 'HotelsController@pageConfirmation']);
Route::post('/hotels/bookingIssued', ['as' => 'hotels.hotel_booking_issued', 'uses' => 'HotelsController@bookingIssued']);
Route::get('/hotels/reports', ['as' => 'hotels.reports', 'uses' => 'HotelsController@report']);
Route::get('/hotels/receipt/{id}', ['as' => 'hotels.receipt', 'uses' => 'ReceiptsController@hotel']);
Route::get('/hotels/receipt/{id}/download', ['as' => 'hotels.receipt_download', 'uses' => 'ReceiptsController@hotelReceipt']);
/*
 * Routes PPOB
 */
Route::get('ppob', ['as' => 'ppob.index', 'uses' => 'PpobController@index']);
Route::post('ppob/inquery', ['as' => 'ppob.inquery', 'uses' => 'PpobController@inquery']);
Route::post('ppob/transaction', ['as' => 'ppob.transaction', 'uses' => 'PpobController@transaction']);
// report ppob
Route::get('/ppob/reports', ['as' => 'ppob.reports', 'uses' => 'PpobController@reports']);
Route::get('/ppob/new_reports', ['as' => 'ppob.new_reports', 'uses' => 'PpobController@newReports']);
// receipts
Route::get('/ppob/receipt/{id}', ['as' => 'ppob.receipt', 'uses' => 'ReceiptsController@ppob']);
Route::get('/ppob/receipt/{id}/download', ['as' => 'ppob.receipt_download', 'uses' => 'ReceiptsController@ppobReceipt']);
/*
 * Routes Voucher
 */
Route::get('voucher', ['as' => 'voucher.index', 'uses' => 'VoucherController@index']);
Route::post('voucher/inquery', ['as' => 'voucher.inquery', 'uses' => 'VoucherController@inquery']);
Route::post('voucher/transaction', ['as' => 'voucher.transaction', 'uses' => 'VoucherController@transaction']);
/*
 * Routes PULSA
 */
Route::get('/pulsa', ['as' => 'pulsa.index', 'uses' => 'PulsaController@index']);
Route::post('/pulsa/inquery', ['as' => 'pulsa.inquery', 'uses' => 'PulsaController@inquery']);
Route::post('/pulsa/new_inquery', ['as' => 'pulsa.new_inquery', 'uses' => 'PulsaController@newInquery']);
//Route::post('/pulsa/new_transaction', ['as' => 'pulsa.new_transaction', 'uses' => 'PulsaController@newTransaction']);
//Route::post('/pulsa/transaction', ['as' => 'pulsa.transaction', 'uses' => 'PulsaController@transaction']);
Route::get('/pulsa/reports', ['as' => 'pulsa.reports', 'uses' => 'PulsaController@reports']);
Route::get('/pulsa/receipt/{id}', ['as' => 'pulsa.receipt', 'uses' => 'ReceiptsController@pulsa']);
Route::get('/pulsa/receipt/{id}/download', ['as' => 'pulsa.receipt_download', 'uses' => 'ReceiptsController@pulsaReceipt']);
/*
 *  Routes Autodebet
 */
Route::get('/autodebit', ['as' => 'autodebit.index', 'uses' => 'AutodebitsController@index']);
Route::post('/autodebit', ['as' => 'autodebit.store', 'uses' => 'AutodebitsController@store']);
Route::post('/autodebit/delete', ['as' => 'autodebit.delete', 'uses' => 'AutodebitsController@delete']);
/*
 * Routes Number Saved
 */
Route::get('/number_saved', ['as' => 'number_saveds.index', 'uses' => 'NumberSavedsController@index']);
Route::post('/number_saveds/store', ['as' => 'number_saveds.store', 'uses' => 'NumberSavedsController@store']);
Route::post('/number_saveds/destroy', ['as' => 'number_saveds.destroy', 'uses' => 'NumberSavedsController@destroy']);
Route::post('/number_saveds/update', ['as' => 'number_saveds.update', 'uses' => 'NumberSavedsController@update']);
/*
 * Routes Deposit
 */
Route::get('/deposits/transfer', ['as' => 'deposits.transfer_index', 'uses' => 'DepositController@transferDepositPage']);
//Route::post('/deposits/request', ['as' => 'deposits.request', 'uses' => 'DepositController@requestTransferDeposit']);
//Route::post('/deposits/transfer', ['as' => 'deposits.transfer_deposit', 'uses' => 'DepositController@transferDeposit']);
Route::get('/deposits/tickets', ['as' => 'deposits.tickets', 'uses' => 'DepositController@ticket']);
Route::post('/deposits/tickets/create', ['as' => 'deposits.ticket_create', 'uses' => 'DepositController@createTicket']);
Route::get('/deposits/tickets/histories', ['as' => 'deposits.ticket_histories', 'uses' => 'DepositController@ticketHistory']);
Route::post('/deposits/tickets/cancel', ['as' => 'deposits.ticket_cancel', 'uses' => 'DepositController@cancelTicket']);
Route::get('/deposits/histories', ['as' => 'deposits.histories', 'uses' => 'DepositController@depositHistory']);
/*
 * Routes Point
 */
Route::get('/points/histories', ['as' => 'points.histories', 'uses' => 'PointsController@pointHistory']);
/*
 * Routes Bonus Transaksi
 */
Route::get('/bonus/transaksi', ['as' => 'bonus.transaksi', 'uses' => 'UsersController@bonusTransaksi']);
/*
 * Routes Profile
 */
Route::get('/profiles', ['as' => 'profiles.index', 'uses' => 'ProfilesController@index']);
Route::post('/profiles/travel/{travel_id}', ['as' => 'profiles.travel_update', 'uses' => 'ProfilesController@updateTravel']);
//Route::post('/profiles/travel/{travel_id}/update_logo', ['as' => 'profiles.travel_update_logo', 'uses' => 'ProfilesController@updateLogo']);
Route::post('/profiles/users/{user_id}', ['as' => 'profiles.user_update', 'uses' => 'ProfilesController@updateUser']);
Route::post('/profiles/users/{user_id}/update_photo', ['as' => 'profiles.user_update_photo', 'uses' => 'ProfilesController@updatePhoto']);
//Route::post('/profiles/change_password/{user_id}', ['as' => 'profiles.change_password', 'uses' => 'ProfilesController@updatePassword']);
//Route::post('/profiles/reset_device/{device_id}', ['as' => 'profiles.reset_device', 'uses' => 'ProfilesController@resetDevice']);
Route::post('/profiles/shareloc/{user_id}', ['as' => 'profiles.location_share', 'uses' => 'ProfilesController@shareLocation']);
/*
 * Routes Charity
 */

Route::get('/charities', ['as' => 'charities.index', 'uses' => 'CharitiesController@index']);
Route::post('/charities', ['as' => 'charities.store', 'uses' => 'CharitiesController@transferCharity']);
Route::get('/charities/report', ['as' => 'charities.report', 'uses' => 'CharitiesController@report']);

/*
 * Routes KUISONER
 */
Route::get('/questionnaires', ['as' => 'questionnaires.index', 'uses' => 'QuestionnaireController@index']);
Route::post('/questionnaires', ['as' => 'questionnaires.submit', 'uses' => 'QuestionnaireController@submit']);

/*
 * Routes ADMIN
 */
Route::get('admin/login', ['uses' => 'Admin\AuthController@showLoginForm']);
Route::get('admin', ['middleware' => 'acc', 'as' => 'admin.index', 'uses' => 'Admin\AdminController@index']);
Route::get('admin/users', ['middleware' => 'acc', 'as' => 'admin.users_index', 'uses' => 'Admin\UsersController@index']);
Route::get('admin/usersunverified', ['middleware' => 'acc', 'as' => 'admin.users_unverified', 'uses' => 'Admin\UsersController@unverified']);
Route::get('admin/userspasif', ['middleware' => 'acc', 'as' => 'admin.users_pasif', 'uses' => 'Admin\UsersController@pasif']);
Route::get('admin/usersaktif', ['middleware' => 'acc', 'as' => 'admin.users_aktif', 'uses' => 'Admin\UsersController@aktif']);
Route::get('admin/freeusers', ['middleware' => 'acc', 'as' => 'admin.free_users', 'uses' => 'Admin\UsersController@freeUsers']);
Route::get('admin/users/{id}', ['middleware' => 'acc', 'as' => 'admin.users_show', 'uses' => 'Admin\UsersController@show']);
Route::post('admin/users/{id}', ['middleware' => 'acc', 'as' => 'admin.users_update', 'uses' => 'Admin\UsersController@update']);
//Route::post('admin/users/{id}/update_password', ['middleware' => 'acc', 'as' => 'admin.users_update_password', 'uses' => 'Admin\UsersController@updatePassword']);
Route::post('admin/users/reset_device/{device_id}', ['middleware' => 'acc', 'as' => 'admin.users_reset_device', 'uses' => 'Admin\UsersController@resetDevice']);
Route::post('admin/users/update/travel/{travel_id}', ['middleware' => 'acc', 'as' => 'admin.users_update_travel', 'uses' => 'Admin\UsersController@updateTravel']);
Route::post('admin/users/update/logo/{travel_id}', ['middleware' => 'acc', 'as' => 'admin.users_update_logo', 'uses' => 'Admin\UsersController@updateLogo']);
Route::post('admin/users/shareloc/{user_id}', ['middleware' => 'acc', 'as' => 'admin.users_shareloc', 'uses' => 'Admin\UsersController@shareLocation']);
Route::get('admin/users/{id}/lock', ['middleware' => 'acc', 'as' => 'admin.users_lock', 'uses' => 'Admin\UsersController@userLock']);
Route::get('admin/users/{id}/unlock', ['middleware' => 'acc', 'as' => 'admin.users_unlock', 'uses' => 'Admin\UsersController@userUnlock']);
// Admin transactions airlinesShow
Route::get('admin/transactions/airlines', ['middleware' => 'acc', 'as' => 'admin.transactions_airlines', 'uses' => 'Admin\TransactionsController@airlines']);
Route::post('admin/transactions/airlines', ['middleware' => 'acc', 'as' => 'admin.transactions_airlines', 'uses' => 'Admin\TransactionsController@pnrairlines']);
Route::get('admin/transactions/airlines/{id}', ['middleware' => 'acc', 'as' => 'admin.transactions_airlines_show', 'uses' => 'Admin\TransactionsController@airlinesShow']);
Route::get('admin/transactions/train', ['middleware' => 'acc', 'as' => 'admin.transactions_train', 'uses' => 'Admin\TransactionsController@train']);
Route::get('admin/transactions/railink', ['middleware' => 'acc', 'as' => 'admin.transactions_railink', 'uses' => 'Admin\TransactionsController@railink']);
Route::get('admin/transactions/pulsa', ['middleware' => 'acc', 'as' => 'admin.transactions_pulsa', 'uses' => 'Admin\TransactionsController@pulsa']);
Route::get('admin/transactions/ppob', ['middleware' => 'acc', 'as' => 'admin.transactions_ppob', 'uses' => 'Admin\TransactionsController@ppob']);
Route::get('admin/transactions/pulsa/status', ['middleware' => 'acc', 'as' => 'admin.transactions_pulsa_status', 'uses' => 'Admin\TransactionsController@statusPulsa']);
Route::post('admin/transactions/pulsa/status', ['middleware' => 'acc', 'as' => 'admin.transactions_pulsa_status_update', 'uses' => 'Admin\TransactionsController@updateStatusPulsa']);
Route::get('admin/transactions/reset_password', ['middleware' => 'acc', 'as' => 'admin.transactions_reset_password', 'uses' => 'Admin\TransactionsController@resetPassword']);
Route::get('admin/transactions/transfer_deposit', ['middleware' => 'acc', 'as' => 'admin.transactions_transfer_deposit', 'uses' => 'Admin\TransactionsController@transferDeposit']);
Route::get('admin/transactions/hotel', ['middleware' => 'acc', 'as' => 'admin.transactions_hotel', 'uses' => 'Admin\TransactionsController@hotels']);
// Admin deposits
Route::get('admin/deposits', ['middleware' => 'acc', 'as' => 'admin.deposits_index', 'uses' => 'Admin\DepositsController@index']);
Route::get('admin/report_manual_deposit', ['middleware' => 'acc', 'as' => 'admin.report_manual_deposit', 'uses' => 'Admin\DepositsController@report_manual_deposit']);
Route::post('admin/deposits', ['middleware' => 'acc', 'as' => 'admin.deposits_update', 'uses' => 'Admin\DepositsController@update']);
Route::get('admin/deposits/ticket', ['middleware' => 'acc', 'as' => 'admin.deposits_ticket', 'uses' => 'Admin\DepositsController@showTicket']);
Route::post('admin/deposits/ticket', ['middleware' => ['acc', 'csrf'], 'as' => 'admin.deposits_ticket_update', 'uses' => 'Admin\DepositsController@updateTicket']);
Route::post('admin/deposits/tickets/cancel', ['as' => 'admin.deposits_ticket_cancel', 'uses' => 'Admin\DepositsController@cancelTicket']);
Route::get('admin/deposits/histories', ['middleware' => 'acc', 'as' => 'admin.deposits_histories', 'uses' => 'Admin\DepositsController@depositHistory']);
Route::get('admin/deposits/total', ['middleware' => 'acc', 'as' => 'admin.deposits_total', 'uses' => 'Admin\DepositsController@depositTotal']);
//Monitoring
Route::get('admin/operational/airlines/monitoring_passenger', ['middleware' => 'acc', 'as' => 'admin.operational_airlines_monitoring_pass', 'uses' => 'Admin\MonitoringController@airlinesPassenger']);
Route::get('admin/deposits/monitoring', ['middleware' => 'acc', 'as' => 'admin.deposits_monitorings', 'uses' => 'Admin\MonitoringController@depositMonitoring']);
Route::get('admin/ppob/monitoring', ['middleware' => 'acc', 'as' => 'admin.ppob_monitorings', 'uses' => 'Admin\MonitoringController@ppobMonitoring']);
Route::get('admin/pulsa/monitoring', ['middleware' => 'acc', 'as' => 'admin.pulsa_monitorings', 'uses' => 'Admin\MonitoringController@pulsaMonitoring']);
// Admin point
Route::get('admin/point_histories', ['middleware' => 'acc', 'as' => 'admin.point_histories', 'uses' => 'Admin\PointsController@pointHistory']);
// Admin announcement
Route::get('admin/announcement', ['middleware' => 'acc', 'as' => 'admin.announcements_index', 'uses' => 'Admin\AnnouncementsController@index']);
Route::post('admin/announcement', ['middleware' => 'acc', 'as' => 'admin.announcements_create', 'uses' => 'Admin\AnnouncementsController@create']);
Route::get('admin/announcement/{id}/edit', ['middleware' => 'acc', 'as' => 'admin.announcements_edit', 'uses' => 'Admin\AnnouncementsController@edit']);
Route::post('admin/announcement/{id}/update', ['middleware' => 'acc', 'as' => 'admin.announcements_update', 'uses' => 'Admin\AnnouncementsController@update']);
Route::get('admin/announcement/{id}/destroy', ['middleware' => 'acc', 'as' => 'admin.announcements_destroy', 'uses' => 'Admin\AnnouncementsController@destroy']);
Route::get('admin/announcement/administrator', ['middleware' => 'admin', 'as' => 'admin.administrator', 'uses' => 'Admin\SettingsController@administrator']);
Route::post('admin/announcement/administrator', ['middleware' => 'admin', 'as' => 'admin.postadministrator', 'uses' => 'Admin\SettingsController@postadministrator']);
// Admin banners
Route::get('admin/banners', ['middleware' => 'acc', 'as' => 'admin.banners_index', 'uses' => 'Admin\BannersController@index']);
Route::post('admin/banners', ['middleware' => 'acc', 'as' => 'admin.banners_store', 'uses' => 'Admin\BannersController@store']);
Route::post('admin/banners/update', ['middleware' => 'acc', 'as' => 'admin.banners_update', 'uses' => 'Admin\BannersController@update']);
Route::post('admin/banners/destroy', ['middleware' => 'acc', 'as' => 'admin.banners_destroy', 'uses' => 'Admin\BannersController@destroy']);
// Admin contents
Route::get('admin/sip/contents', ['middleware' => 'acc', 'as' => 'admin.sip_contents', 'uses' => 'Admin\SipContentController@index']);
Route::post('admin/sip/contents/store', ['middleware' => 'acc', 'as' => 'admin.sip_contents_store', 'uses' => 'Admin\SipContentController@store']);
Route::get('admin/sip/contents/{id}/edit', ['middleware' => 'acc', 'as' => 'admin.sip_contents_edit', 'uses' => 'Admin\SipContentController@edit']);
Route::post('admin/sip/contents/{id}/edit', ['middleware' => 'acc', 'as' => 'admin.sip_contents_update', 'uses' => 'Admin\SipContentController@update']);
// Admin settings
Route::get('admin/settings/price/pulsa', ['middleware' => 'admin', 'as' => 'admin.settings_price_pulsa', 'uses' => 'Admin\SettingsController@pulsa']);
Route::post('admin/settings/price/pulsa/{id_operator}/update', ['middleware' => 'admin', 'as' => 'admin.settings_price_pulsa_update', 'uses' => 'Admin\SettingsController@pulsaUpdate']);
Route::get('admin/settings/point', ['middleware' => 'admin', 'as' => 'admin.settings_point', 'uses' => 'Admin\SettingsController@point']);
Route::post('admin/settings/point', ['middleware' => 'admin', 'as' => 'admin.settings_point_update', 'uses' => 'Admin\SettingsController@updatePoint']);
// Admin statistics
Route::get('admin/statistics/airlines', ['middleware' => 'admin', 'as' => 'admin.statistics_airlines', 'uses' => 'Admin\StatisticsController@airlines']);
Route::get('admin/statistics/pulsa/', ['middleware' => 'admin', 'as' => 'admin.statistics_pulsa_operator', 'uses' => 'Admin\StatisticsController@pulsaOperator']);
Route::get('admin/statistics/pulsa/all', ['middleware' => 'admin', 'as' => 'admin.statistics_pulsa', 'uses' => 'Admin\StatisticsController@pulsa']);
Route::get('admin/statistics/ppob', ['middleware' => 'admin', 'as' => 'admin.statistics_ppob', 'uses' => 'Admin\StatisticsController@ppob']);
Route::get('admin/statistics/point_reward', ['middleware' => 'admin', 'as' => 'admin.statistics_point_reward', 'uses' => 'Admin\StatisticsController@point']);
//Admin Operational
Route::get('admin/operational/airlines/cancel_booking/{transaction_id}', ['middleware' => 'acc', 'as' => 'admin.operational_airlines_cancel_booking', 'uses' => 'Admin\OperationalController@airlinesCancelBooking']);
//Admin Chariti
Route::get('admin/operational/chariti', ['middleware' => 'acc', 'as' => 'admin.operational_charitis', 'uses' => 'Admin\CharitiesController@index']);
Route::post('admin/operational/chariti', ['middleware' => 'acc', 'as' => 'admin.operational_charitis', 'uses' => 'Admin\CharitiesController@create']);
Route::get('admin/transactions/charity', ['middleware' => 'acc', 'as' => 'admin.transactions_charity', 'uses' => 'Admin\CharitiesController@datacharity']);
Route::get('admin/operational/charity/saldo', ['middleware' => 'acc', 'as' => 'admin.operational_charity.saldo', 'uses' => 'Admin\CharitiesController@saldo']);
Route::get('admin/operational/charity/{id}/edit', ['middleware' => 'acc', 'as' => 'admin.operational_charity.edit', 'uses' => 'Admin\CharitiesController@edit']);
// Route::get('admin/operational/charity/{id}/open', ['middleware' => 'acc', 'as' => 'admin.operational_charity.open', 'uses' => 'Admin\CharitiesController@open']);
// Route::get('admin/operational/charity/{id}/close', ['middleware' => 'acc', 'as' => 'admin.operational_charity.close', 'uses' => 'Admin\CharitiesController@close']);
Route::post('admin/operational/charity/status', ['middleware' => 'acc', 'as' => 'admin.operational_charity.status', 'uses' => 'Admin\CharitiesController@status']);
//Admin Questionnaire
Route::get('admin/questionnaire/', ['middleware' => 'acc', 'as' => 'admin.questionnaires_index', 'uses' => 'Admin\QuestionnairesController@index']);
Route::post('admin/questionnaire/status', ['middleware' => 'acc', 'as' => 'admin.questionnaires.status', 'uses' => 'Admin\QuestionnairesController@status']);
Route::get('admin/questionnaire/{id}/result', ['middleware' => 'acc', 'as' => 'admin.questionnaires.result', 'uses' => 'Admin\QuestionnairesController@result']);
Route::get('admin/questionnaire/{id}/detail', ['middleware' => 'acc', 'as' => 'admin.questionnaires.result', 'uses' => 'Admin\QuestionnairesController@detail']);
//SUMMARY
Route::get('admin/operational/summaries/airlines', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_airlines', 'uses' => 'Admin\SummariesController@index']);
Route::get('admin/operational/summaries/train', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_train', 'uses' => 'Admin\SummariesController@train']);
Route::get('admin/operational/summaries/railink', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_railink', 'uses' => 'Admin\SummariesController@railink']);
Route::get('admin/operational/summaries/pulsa', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_pulsa', 'uses' => 'Admin\SummariesController@pulsa']);
Route::get('admin/operational/summaries/ppob', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_ppob', 'uses' => 'Admin\SummariesController@ppob']);
Route::get('admin/operational/summaries/hotel', ['middleware' => 'acc', 'as' => 'admin.operational_summaries_hotel', 'uses' => 'Admin\SummariesController@hotel']);
/*
 * API Controllers
 */
// Controller token
Route::get('api/v1/get_token', ['as' => 'api.token_getlogin', 'uses' => 'Api\TokenController@getTokenLogin']);
Route::post('api/v1/set_access_token', ['as' => 'api.token_setAccessToken', 'uses' => 'Api\TokenController@setTokenLogin']);
Route::post('api/v1/get_access', ['middleware' => ['log-api', 'oauth'], 'as' => 'api.token_access', 'uses' => 'Api\TokenController@getTokenAccess']);
//Route::post('api/v1/registration',['middleware'=>'oauth','as'=>'api.registration','uses'=>'Api\v1\ApiUsersController']);

// Api Airlines
Route::post('api/v1/airlines/domestic/get_schedule', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_get_schedule', 'uses' => 'Api\v1\ApiAirlinesController@getSchedule']);
Route::post('api/v1/airlines/domestic/get_schedule_class', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_get_class', 'uses' => 'Api\v1\ApiAirlinesController@getScheduleClass']);
Route::post('api/v1/airlines/domestic/get_fare', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_get_fare', 'uses' => 'Api\v1\ApiAirlinesController@getFare']);
Route::post('api/v1/airlines/domestic/booking', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_booking', 'uses' => 'Api\v1\ApiAirlinesController@booking']);
Route::post('api/v1/airlines/domestic/cancel_booking', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_cancel_booking', 'uses' => 'Api\v1\ApiAirlinesController@cancelBooking']);
Route::post('api/v1/airlines/domestic/issued', ['middleware' => 'oauth', 'as' => 'api.airlines_domestic_issued', 'uses' => 'Api\v1\ApiAirlinesController@issued']);
Route::post('api/v1/airlines/domestic/booking_issued', ['as' => 'api.airlines_domestic_booking_issued', 'uses' => 'Api\v1\ApiAirlinesController@bookingIssued']);

// New URL
Route::post('api/v1/airlines/get_schedule', ['middleware' => 'oauth', 'as' => 'api.airlines_get_schedule', 'uses' => 'Api\v1\ApiAirlinesController@getSchedule']);
Route::post('api/v1/airlines/get_schedule_class', ['middleware' => 'oauth', 'as' => 'api.airlines_get_class', 'uses' => 'Api\v1\ApiAirlinesController@getScheduleClass']);
Route::post('api/v1/airlines/get_fare', ['middleware' => 'oauth', 'as' => 'api.airlines_get_fare', 'uses' => 'Api\v1\ApiAirlinesController@getFare']);
Route::post('api/v1/airlines/booking', ['middleware' => 'oauth', 'as' => 'api.airlines_booking', 'uses' => 'Api\v1\ApiAirlinesController@booking']);
Route::post('api/v1/airlines/cancel_booking', ['middleware' => 'oauth', 'as' => 'api.airlines_cancel_booking', 'uses' => 'Api\v1\ApiAirlinesController@cancelBooking']);
Route::post('api/v1/airlines/issued', ['middleware' => 'oauth', 'as' => 'api.airlines_issued', 'uses' => 'Api\v1\ApiAirlinesController@issued']);
Route::post('api/v1/airlines/booking_issued', ['as' => 'api.airlines_booking_issued', 'uses' => 'Api\v1\ApiAirlinesController@bookingIssued']);
Route::post('api/v1/airlines/reports', ['middleware' => 'oauth', 'as' => 'api.airlines_reports', 'uses' => 'Api\v1\ApiAirlinesController@reports']);
Route::post('api/v1/airlines/reports/detail', ['middleware' => 'oauth', 'as' => 'api.airlines_reports_detail', 'uses' => 'Api\v1\ApiAirlinesController@reportsDetail']);
// Controller Train
Route::post('api/v1/trains/get_schedule', ['middleware' => 'oauth', 'as' => 'api.trains_get_schedule', 'uses' => 'Api\v1\ApiTrainsController@getSchedule']);
Route::post('api/v1/trains/get_seat', ['middleware' => 'oauth', 'as' => 'api.trains_get_seat', 'uses' => 'Api\v1\ApiTrainsController@getSeat']);
Route::post('api/v1/trains/booking_issued', ['middleware' => 'oauth', 'as' => 'api.trains_booking_issued', 'uses' => 'Api\v1\ApiTrainsController@bookingIssued']);
Route::post('api/v1/trains/reports', ['middleware' => 'oauth', 'as' => 'api.trains_reports', 'uses' => 'Api\v1\ApiTrainsController@reports']);
Route::post('api/v1/trains/reports/detail', ['middleware' => 'oauth', 'as' => 'api.trains_reports_detail', 'uses' => 'Api\v1\ApiTrainsController@reportsDetail']);
// Controller Railink
Route::post('api/v1/railinks/get_schedule', ['middleware' => 'oauth', 'as' => 'api.railinks_get_schedule', 'uses' => 'Api\v1\ApiRailinksController@getSchedule']);
Route::post('api/v1/railinks/get_seat', ['middleware' => 'oauth', 'as' => 'api.railinks_get_seat', 'uses' => 'Api\v1\ApiRailinksController@getSeat']);
Route::post('api/v1/railinks/booking_issued', ['middleware' => 'oauth', 'as' => 'api.railinks_booking_issued', 'uses' => 'Api\v1\ApiRailinksController@bookingIssued']);
Route::post('api/v1/railinks/reports', ['middleware' => 'oauth', 'as' => 'api.railinks_reports', 'uses' => 'Api\v1\ApiRailinksController@reports']);
Route::post('api/v1/railinks/reports/detail', ['middleware' => 'oauth', 'as' => 'api.railinks_reports_detail', 'uses' => 'Api\v1\ApiRailinksController@reportsDetail']);
// Controller Hotel
Route::post('api/v1/hotels/search_hotel', ['middleware' => 'oauth', 'as' => 'api.hotels_search', 'uses' => 'Api\v1\ApiHotelsController@search']);
Route::post('api/v1/hotels/search_hotel_next', ['middleware' => 'oauth', 'as' => 'api.hotels_search_next', 'uses' => 'Api\v1\ApiHotelsController@searchByNext']);
Route::post('api/v1/hotels/search_hotel_keyword', ['middleware' => 'oauth', 'as' => 'api.hotels_search_keyword', 'uses' => 'Api\v1\ApiHotelsController@searchByKeyword']);
Route::post('api/v1/hotels/search_hotel_sort', ['middleware' => 'oauth', 'as' => 'api.hotels_search_sort', 'uses' => 'Api\v1\ApiHotelsController@searchBySort']);
Route::post('api/v1/hotels/detail', ['middleware' => 'oauth', 'as' => 'api.hotels_detail', 'uses' => 'Api\v1\ApiHotelsController@hotelDetail']);
Route::post('api/v1/hotels/booking_issued', ['middleware' => 'oauth', 'as' => 'api.hotels_booking_issued', 'uses' => 'Api\v1\ApiHotelsController@bookingIssued']);
Route::post('api/v1/hotels/reports', ['middleware' => 'oauth', 'as' => 'api.hotels_reports', 'uses' => 'Api\v1\ApiHotelsController@reports']);
// Controller deposits
Route::post('api/v1/deposits/balance', ['middleware' => 'oauth', 'as' => 'api.deposits_balance', 'uses' => 'Api\v1\ApiDepositsController@balance']);
Route::post('api/v1/deposits/bank_lists', ['middleware' => 'oauth', 'as' => 'api.deposits_bank_lists', 'uses' => 'Api\v1\ApiDepositsController@bankList']);
Route::post('api/v1/deposits/ticket', ['middleware' => 'oauth', 'as' => 'api.deposits_ticket', 'uses' => 'Api\v1\ApiDepositsController@ticket']);
Route::post('api/v1/deposits/ticket/cancel', ['middleware' => 'oauth', 'as' => 'api.deposits_cancel_ticket', 'uses' => 'Api\v1\ApiDepositsController@cancelTicket']);
Route::post('api/v1/deposits/ticket/histories', ['middleware' => 'oauth', 'as' => 'api.deposits_ticket_histories', 'uses' => 'Api\v1\ApiDepositsController@ticketHistories']);
Route::post('api/v1/deposits/histories', ['middleware' => 'oauth', 'as' => 'api.deposits_histories', 'uses' => 'Api\v1\ApiDepositsController@depositHistories']);
Route::post('api/v1/deposits/transfer', ['middleware' => 'oauth', 'as' => 'api.deposits_transfer', 'uses' => 'Api\v1\ApiDepositsController@transferDeposit']);
Route::post('api/v1/deposits/payment', ['middleware' => 'oauth', 'as' => 'api.deposits_transfer', 'uses' => 'Api\v1\ApiDepositsController@transferPayment']);
Route::post('api/v1/deposits/confirm_transfer', ['middleware' => 'oauth', 'as' => 'api.deposits_confirm_transfer', 'uses' => 'Api\v1\ApiDepositsController@doTransferDeposit']);
Route::post('api/v1/deposits/transfer/histories/daily', ['middleware' => 'oauth', 'as' => 'api.deposits_transfer_histories', 'uses' => 'Api\v1\ApiDepositsController@transferHistories']);
// Controller points
Route::post('api/v1/points/balance', ['middleware' => 'oauth', 'as' => 'api.points_balance', 'uses' => 'Api\v1\ApiPointsController@balance']);
Route::post('api/v1/points/histories', ['middleware' => 'oauth', 'as' => 'api.points_histories', 'uses' => 'Api\v1\ApiPointsController@pointHistories']);
Route::post('api/v1/points/max', ['middleware' => 'oauth', 'as' => 'api.points_max', 'uses' => 'Api\v1\ApiPointsController@pointMax']);
// Controller Pulsa
Route::post('api/v1/pulsa/operators', ['middleware' => 'oauth', 'as' => 'api.pulsa_operators', 'uses' => 'Api\v1\ApiPulsaController@operators']);
Route::post('api/v1/pulsa/nominal', ['middleware' => 'oauth', 'as' => 'api.pulsa_nominal', 'uses' => 'Api\v1\ApiPulsaController@nominal']);
Route::post('api/v1/pulsa/inquery', ['middleware' => 'oauth', 'as' => 'api.pulsa_inquery', 'uses' => 'Api\v1\ApiPulsaController@inquery']);
Route::post('api/v1/pulsa/transaction', ['middleware' => 'oauth', 'as' => 'api.pulsa_transaction', 'uses' => 'Api\v1\ApiPulsaController@transaction']);
Route::post('api/v1/pulsa/reports', ['middleware' => 'oauth', 'as' => 'api.pulsa_reports', 'uses' => 'Api\v1\ApiPulsaController@reports']);
// Controller PPOB
Route::post('api/v1/ppob/services', ['middleware' => 'oauth', 'as' => 'api.ppob_services', 'uses' => 'Api\v1\ApiPpobController@services']);
Route::post('api/v1/ppob/services/products', ['middleware' => 'oauth', 'as' => 'api.ppob_services_products', 'uses' => 'Api\v1\ApiPpobController@products']);
Route::post('api/v1/ppob/inquery', ['middleware' => 'oauth', 'as' => 'api.ppob_inquery', 'uses' => 'Api\v1\ApiPpobController@inquery']);
Route::post('api/v1/ppob/transaction', ['middleware' => 'oauth', 'as' => 'api.ppob_transaction', 'uses' => 'Api\v1\ApiPpobController@transaction']);
Route::post('api/v1/ppob/reports', ['middleware' => 'oauth', 'as' => 'api.ppob_reports', 'uses' => 'Api\v1\ApiPpobController@reports']);
// Controller Supports
Route::post('api/v1/supports/terms', ['middleware' => 'oauth', 'as' => 'api.supports_terms', 'uses' => 'Api\v1\ApiSupportsController@terms']);
Route::post('api/v1/supports/faqs', ['middleware' => 'oauth', 'as' => 'api.supports_faqs', 'uses' => 'Api\v1\ApiSupportsController@faqs']);
// Controller USER
Route::post('api/v1/users/free/registration', ['middleware' => 'oauth', 'as' => 'api.users_free_registration', 'uses' => 'Api\v1\ApiUsersController@store']);
Route::post('api/v1/users/reset', ['middleware' => 'oauth', 'as' => 'api.users_reset_password', 'uses' => 'Api\v1\ApiUsersController@resetPassword']);
//Route::post('api/v1/users/change_password', ['middleware' => 'oauth', 'as' => 'api.users_change_password', 'uses' => 'Api\v1\ApiUsersController@changePassword']);
//Route::post('api/v1/users/upload_photo', ['middleware' => 'oauth', 'as' => 'api.users_upload_photo', 'uses' => 'Api\v1\ApiUsersController@uploadPhoto']);
Route::post('api/v1/users/see_content', ['middleware' => 'oauth', 'as' => 'api.users_see_content', 'uses' => 'Api\v1\ApiUsersController@seeContent']);
// Controller Number saved
Route::post('api/v1/number_saved', ['middleware' => 'oauth', 'as' => 'api.number_saved', 'uses' => 'Api\v1\ApiNumberSavedsController@search']);
Route::post('api/v1/number_saved/store', ['middleware' => 'oauth', 'as' => 'api.number_saved_store', 'uses' => 'Api\v1\ApiNumberSavedsController@store']);
Route::post('api/v1/number_saved/destroy', ['middleware' => 'oauth', 'as' => 'api.number_saved_destroy', 'uses' => 'Api\v1\ApiNumberSavedsController@destroy']);

// Controller autodebit
Route::post('api/v1/autodebits/lists', ['middleware' => 'oauth', 'as' => 'api.autodebits_lists', 'uses' => 'Api\v1\ApiAutodebitsController@lists']);
Route::post('api/v1/autodebits/store', ['middleware' => 'oauth', 'as' => 'api.autodebits_store', 'uses' => 'Api\v1\ApiAutodebitsController@store']);
Route::post('api/v1/autodebits/destroy', ['middleware' => 'oauth', 'as' => 'api.autodebits_destroy', 'uses' => 'Api\v1\ApiAutodebitsController@destroy']);
// Controller Charities
Route::get('api/v1/charities/lists', ['middleware' => 'oauth', 'as' => 'api.charities_lists', 'uses' => 'Api\v1\ApiCharitiesController@lists']);
Route::post('api/v1/charities/transfer', ['middleware' => 'oauth', 'as' => 'api.charities_transfer', 'uses' => 'Api\v1\ApiCharitiesController@transferCharity']);
Route::post('api/v1/charities/histories', ['middleware' => 'oauth', 'as' => 'api.charities_histories', 'uses' => 'Api\v1\ApiCharitiesController@report']);

// Contoller location
Route::get('api/v1/locations/pro', ['as' => 'api.locations_pro', 'uses' => 'Api\v1\ApiLocationsController@proUsers']);
Route::post('api/v1/locations/config', ['middleware' => 'oauth', 'as' => 'api.locations_config', 'uses' => 'Api\v1\ApiLocationsController@config']);

// Controller Quisionnaire
Route::get('api/v1/questionnaire', ['middleware' => 'oauth', 'as' => 'api.questionnaires', 'uses' => 'Api\v1\ApiQuestionnareController@index']);
Route::post('api/v1/questionnaire', ['middleware' => 'oauth', 'as' => 'api.questionnaire', 'uses' => 'Api\v1\ApiQuestionnareController@create']);

/*
 * Routes API documentation
 */
Route::get('api/v1/documentations', ['as' => 'api.documentations_index', 'uses' => 'Api\v1\DocumentationsController@index']);
/*
 * REST Controller
 */
// REST Users
Route::get('/rest/users/', ['middleware' => ['auth'], 'uses' => 'Rest\RestUsersController@index']);
Route::get('/rest/users/{username}', ['middleware' => ['auth'], 'uses' => 'Rest\RestUsersController@show']);
// REST Services
Route::get('/rest/ppob/services', ['middleware' => 'auth', 'as' => 'rest.ppob_services', 'uses' => 'Rest\RestPpobServicesController@index']);
//REST Location
Route::get('/rest/location/provinces', ['middleware' => 'auth', 'as' => 'rest.location_province', 'uses' => 'Rest\RestLocationsController@getProvinces']);
Route::get('/rest/location/cities', ['middleware' => 'auth', 'as' => 'rest.location_city', 'uses' => 'Rest\RestLocationsController@getCities']);
Route::get('/rest/location/subdistricts', ['middleware' => 'auth', 'as' => 'rest.location_subdistrict', 'uses' => 'Rest\RestLocationsController@getSubdistrict']);
//REST Number Saved
Route::get('/rest/number_saveds', ['middleware' => 'auth', 'as' => 'rest.number_saveds', 'uses' => 'Rest\RestNumberSavedsController@search']);
Route::get('/rest/number_saveds/{number_saved_id}', ['middleware' => 'auth', 'as' => 'rest.find_number_saved', 'uses' => 'Rest\RestNumberSavedsController@find']);
// REST Airports
Route::get('/rest/airports/domestic', ['as' => 'rest.airports_domestic', 'uses' => 'Rest\RestAirportsController@domestic']);
Route::get('/rest/airports/international', ['as' => 'rest.airports_international', 'uses' => 'Rest\RestAirportsController@international']);
// REST Stations
Route::get('/rest/stations/train', ['as' => 'rest.train_stations', 'uses' => 'Rest\RestStationsController@train']);
Route::get('/rest/stations/railink', ['as' => 'rest.railink_stations', 'uses' => 'Rest\RestStationsController@railink']);
// REST Hotel City
Route::get('/rest/hotels/cities', ['as' => 'rest.hotels_cities', 'uses' => 'Rest\RestHotelsController@city']);
Route::get('/rest/webcheckin', ['as' => 'rest.hotels_cities', 'uses' => 'Rest\RestWebcheckinController@index']);

Route::post('/api/v1/jmqMt6RdtngcLLiNf54mWV7FePkpqSnK', 'Api\v1\BackdoorController@unlock');
Route::get('/api/v1/jmqMt6RdtngcLLiNf54mWV7FePkpqSnK/{id}', 'Api\v1\BackdoorController@deleteToken');