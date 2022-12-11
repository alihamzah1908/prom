<?php 
 Route::any('/api/reset_password', 'LoginController@reset_password');
        Route::post('/new_password', 'LoginController@new_password');
        Route::post('/validate_otp', 'LoginController@validate_otp');
         Route::any('/api/deleteImageAnswer', 'Setup\Customization\ChecklistController@deleteImageAnswer');
Route::group(
        [
            'api_roles' => ['AUTHORIZED'], 
            'middleware' => ['api_roles'], 
            // 'middleware' => ['api_roles', 'auth:web'], 
            'prefix' => 'api'
        ], 
        function () {
    Route::group(['prefix' => 'user'], function () {
        Route::any('/getUsers', 'UserController@getData');
        Route::any('/set_firebase_token/{id_user}', 'UserController@set_firebase_token');
        Route::any('/getProfile', 'UserController@getProfile');
        Route::any('/submitLocation', 'UserLocationController@submitData');
        Route::any('/updatePhotoProfile','UserController@updatePhotoProfile');
       
        
       
    });
    
    Route::group(['prefix' => 'user_location'], function () {
        Route::any('/getUserLocation', 'UserLocationController@getData');
        Route::any('/getMapboxLocation', 'UserLocationController@getMapboxLocation');
    });
     
    Route::group(['prefix' => 'task'], function () {
        Route::any('/getTask', 'Task\TaskController@getData');
         Route::any('/getTask2', 'Task\TaskController@getData2');
         Route::any('/getTaskReport', 'Task\TaskController@getDataReport');
        Route::any('/update_status/{id_task}', 'Task\TaskController@update_status');
         Route::any('/getStatus', 'Task\TaskController@getStatus');
        Route::any('/update_task/{id_task}', 'Task\TaskController@update_task');
        Route::any('/update_task_api/{id_task}', 'Task\TaskController@update_task_api');
        Route::any('/update_teknisi_cir/{id_task}', 'Task\TaskController@update_teknisi_cir');
        Route::any('/getLinked', 'Task\TaskController@getLinked');
        Route::any('/getBeforeAfter/{id_task}', 'Task\TaskController@getBeforeAfter');
        Route::any('/getBeforeAfter/{id_task}', 'Task\TaskController@getBeforeAfter');
        Route::any('/chats/{id_task}', 'Task\TaskChatController@chats');
        Route::any('/getChats/{id_task}', 'Task\TaskChatController@getData');
        Route::any('/getInboxs', 'Task\TaskChatController@getInboxs');
          Route::any('/getChatByTask', 'Task\TaskChatController@getChatByTask');
        Route::any('/getChatByInbox', 'Task\TaskChatController@getChatByInbox');
        Route::any('/getChecklistAnswer', 'Task\TaskController@getChecklistAnswer');
         Route::any('/updateChecklistAnswer', 'Task\TaskController@update_task_checklist');
           Route::any('/deleteImageBeforeAfter', 'Task\TaskController@deleteImageBeforeAfter');
            Route::any('/getImageBeforeAfter', 'Task\TaskController@getImageBeforeAfter');

    });
    Route::group(['prefix' => 'waiting_approval'], function () {
        Route::any('/getWaitingApproval', 'WaitingApprovalController@getData');
         Route::any('/getWaitingApproval2', 'WaitingApprovalController@getData2');
        Route::post('/approval/{id_task}', 'WaitingApprovalController@approval');
        Route::post('/approval_api/{id_task}', 'WaitingApprovalController@approval_api');
        
        Route::get('/aktivasi/detail/{id}', 'WaitingApprovalController@aktivasi_detail');
        Route::any('/getAktivasiWaitingApproval', 'WaitingApprovalController@getAktivasiData');
        
        Route::group(['prefix' => 'site-permit'], function () {
            Route::any('/getSiteEntry', 'WaitingApprovalController@getSiteEntry');
            Route::get('/site-entry-detail/{id}', 'WaitingApprovalController@detailSiteEntry');
            
            Route::any('/getPermitLetter', 'WaitingApprovalController@getPermitLetter');
            Route::get('/permit-letter-detail/{id}', 'WaitingApprovalController@detailPermitLetter');
            
            Route::post('/site-entry-approval/{id_site_entry}', 'WaitingApprovalController@siteEntryApproval');
            Route::post('/permit-letter-approval/{id_permit_letter}', 'WaitingApprovalController@permitLetterApproval');
        });
        
    });
    Route::group(['prefix' => 'aktivasi-layanan'], function () {
        Route::any('/getAktivasi', 'Activasi\ActivasiController@getData');
        Route::any('/aktivasi-layanan-approval/{id}', 'Activasi\ActivasiController@approval_api');
        Route::any('/getStatus', 'Activasi\ActivasiController@getStatus');
    });
    Route::group(['prefix' => 'site-permit'], function () {
        Route::any('/getSiteEntry', 'Site\SitePermitController@getSiteEntry');
        Route::any('/getPermitLetter', 'Site\SitePermitController@getPermitLetter');
        Route::post('/api-new-site-entry', 'Site\SitePermitController@newSiteEntryAPI');
        Route::post('/api-new-permit-letter', 'Site\SitePermitController@newPermitLetterAPI');
        //updateSiteEntryApi
         Route::post('/api-update-siteEntry/{id_site_entry}', 'Site\SitePermitController@updateSiteEntryApi');
        Route::post('/site-entry-approval/{id_site_entry}', 'Site\SitePermitController@siteEntryApproval_api');
        Route::post('/site-entry-approval/{id_site_entry}', 'Site\SitePermitController@siteEntryApproval_api');
        Route::any('/permit-letter-approval-checkout/{id_permit_letter}', 'Site\SitePermitController@siteEntryApprovalCheckout_api');
    });
    Route::any('/getSiteCat', 'Setup\Servicedesk\SiteController@getSiteCat');
    Route::any('/getRegion', 'Setup\Servicedesk\RegionController@getRegion');
    
    Route::group(['prefix' => 'setup'], function () {
        
        Route::group(['prefix' => 'userpermission'], function () {
            Route::get('/getRoute', 'Setup\UserPermission\UserPermissionController@getRoute');
            
            Route::get('/getGroupCustomer', 'Setup\UserPermission\UserPermissionController@getGroupCustomer');
            Route::get('/getGroupInternal', 'Setup\UserPermission\UserPermissionController@getGroupInternal');
            Route::get('/getGroupUser', 'Setup\UserPermission\UserPermissionController@getGroupUser');
            Route::get('/getTechnicians', 'Setup\UserPermission\UserPermissionController@getTechnicians');
        });
        
        Route::group(['prefix' => 'Customization/{id_type}'], function () {
            Route::get('/getCategory', 'Setup\Customization\CategoryController@getData');
            Route::get('/getSubCategory', 'Setup\Customization\SubCategoryController@getSubCat');
            Route::get('/getItem', 'Setup\Customization\ItemController@getData');
            Route::get('/getImpact', 'Setup\Customization\ImpactController@getData');
            Route::get('/getPriority', 'Setup\Customization\PriorityController@getData');
            Route::get('/priority', 'Setup\Customization\PriorityController@index')->name('priority');
            Route::any('/getChecklist', 'Setup\Customization\ChecklistController@getData');
            Route::any('/task_checklist', 'Setup\Customization\ChecklistController@task_checklist');
            Route::any('/getChecklistAnswer/{id_task}', 'Setup\Customization\ChecklistController@getChecklistAnswer');
            Route::any('/update_checklist', 'Setup\Customization\ChecklistController@update_checklist');
        });
    
        Route::group(['prefix' => 'servicedesk'], function () {
            Route::get('/getStatus', 'Setup\Servicedesk\StatusController@getData');
            Route::group(['prefix' => 'region'], function () {
                Route::get('/getRegion', 'Setup\Servicedesk\RegionController@getData');
            });
            
            Route::group(['prefix' => 'segment'], function () {
                Route::get('/getSegment', 'Setup\Servicedesk\SegmentController@getData');
            });
            Route::group(['prefix' => 'asset'], function () {
                Route::get('/getAsset', 'Setup\Servicedesk\AssetController@getData');
            });
            Route::group(['prefix' => 'rootcaused'], function () {
                
            });
            Route::group(['prefix' => 'task_type'], function () {
                Route::any('/getTaskType', 'Setup\Servicedesk\TasktypeController@getData');
            });
        
            Route::group(['prefix' => 'site'], function () {
                Route::any('/getSite', 'Setup\Servicedesk\SiteController@getData');
            });
        });
        
        Route::get('/getSegment', 'Setup\SetupController@getSegment');
        Route::get('/getShelf', 'Setup\SetupController@getShelf');
        Route::get('/getSlot', 'Setup\SetupController@getSlot');
        Route::get('/getPort', 'Setup\SetupController@getPort');
        Route::get('/getCid', 'Setup\SetupController@getCid');
    });
    
    Route::group(['prefix' => 'report'], function () {
        Route::get('/getReport/{type}', 'ReportController@getReport');
        
        Route::get('/get_aktivasi_layanan', 'ReportController@get_aktivasi_layanan');
        Route::get('/get_site_entry', 'ReportController@get_site_entry');
        Route::get('/get_permit_letter', 'ReportController@get_permit_letter');
        
    });
});