<?php

use Illuminate\Support\Facades\Route;

require_once('web2.php');
require_once('firebase.php');
require_once('mobile_api.php');
// no middleware
Route::get('lang/{language}', 'LocalizationController@switch')->name('localization.switch');
Route::any('user/set_firebase_token_web', 'UserController@set_firebase_token_web');
Route::get('/test_sess', function () {
    $task = \App\Model\Task::first();
    // \Session::flash('message', "");
    // \Session::flash('alert-class', 'alert-success');
    // \Session::flash('data', $task);
    return redirect()->to('task')->with('message', "Task Created Successfully!")->with('alert-class', 'alert-success')->with('data', $task);
});
Route::get('/verify_email', function () {
    $id = request()->id;
    $user = \App\User::where('id', $id)->first();
    if (!$user) {
        \Session::flash('message', "Oopss! Something went wrong please try again later!");
        \Session::flash('status', 'info');
        return view('login');
    }
    if ($user->is_verified != "true") {
        $user->is_verified = "true";
        $user->save();
        \Session::flash('message', "Email verified successfully!");
        \Session::flash('status', 'success');
        return view('login');
    }
    return redirect()->to('login');
});

Route::get('/task_report/{any}', function ($one) {
    $path = base_path("public/task_report/$one");
    if (!file_exists($path)) {
        $path = base_path("public/task_report/default.png");
    }
    return response()->file($path);
});

Route::get('test', function () {
    return view('task_schedule.test');
});

// w/ middleware
Route::group(['middleware' => ['auth:web', 'roles'], 'roles' => ['AUTHORIZED'], 'prefix' => ''], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('user');
        Route::get('/detail', 'UserController@userDetail')->name('userDetail');
        Route::get('/create', 'UserController@create')->name('userCreate');
        Route::any('/getUsers', 'UserController@getData');
        Route::any('/getProfile', 'UserController@getProfile');
        Route::post('/new_user', 'UserController@newData');
        Route::any('/set_firebase_token/{id_user}', 'UserController@set_firebase_token');
        Route::any('/remove_user/{id_user}', 'UserController@remove_user');
    });

    Route::group(['prefix' => 'user_location'], function () {
        Route::get('/', 'UserLocationController@index');
        Route::any('/getUserLocation', 'UserLocationController@getData');
        Route::any('/getMapboxLocation', 'UserLocationController@getMapboxLocation');
    });

    Route::get('/home', 'Dashboard\HomeController@index')->name('home');
    Route::get('/dashboard', 'Dashboard\HomeController@index')->name('dashboard');

    // New_Dashboard
    Route::get('/test', 'Dashboard\HomeController@test')->name('dashboard.test');
    Route::get('/trouble', 'Dashboard\HomeController@trouble')->name('dashboard.trouble');
    Route::get('/incident', 'Dashboard\HomeController@incident')->name('dashboard.incident');
    Route::get('/ticket', 'Dashboard\HomeController@ticket')->name('dashboard.ticket');
    Route::get('/achievement', 'Dashboard\HomeController@achievement')->name('dashboard.achievement');
    Route::get('/taskmon', 'Dashboard\HomeController@taskmon')->name('dashboard.taskmon');
    Route::get('/personal', 'Dashboard\HomeController@personal')->name('dashboard.personal');

    // WAREHOUSE
    Route::resource('/material', 'Warehouse\MaterialController');
    Route::resource('/unit', 'Warehouse\UnitController');
    Route::resource('/project', 'Warehouse\ProjectController');
    Route::resource('/location', 'Warehouse\LocationController');
    Route::resource('/materialin', 'Warehouse\MaterialInController');
    Route::resource('/materialout', 'Warehouse\MaterialOutController');
    Route::get('/material/delete/{id}', 'Warehouse\MaterialController@destroy')->name('material.delete');
    Route::get('/unit/delete/{id}', 'Warehouse\UnitController@destroy')->name('unit.delete');
    Route::get('/location/delete/{id}', 'Warehouse\LocationController@destroy')->name('location.delete');
    Route::get('/project/delete/{id}', 'Warehouse\ProjectController@destroy')->name('project.delete');
    Route::get('/material/on-going/approval', 'Warehouse\MaterialOutController@approval')->name('on-going.approval');
    Route::get('/material/on-going/approved', 'Warehouse\MaterialOutController@approval')->name('on-going.approved');
    Route::get('/material/get/json', 'Warehouse\MaterialInController@get_material')->name('get.material');
    Route::get('/location/get/json', 'Warehouse\MaterialInController@get_location')->name('get.location');
    Route::get('/material/approved/status', 'Warehouse\MaterialOutController@approve')->name('material.approval');

    // ---//


    Route::any('/api/getDashboardData', 'Dashboard\HomeController@getDashboardData');
    Route::any('/api/getAktivasiDashboardData', 'Dashboard\HomeController@getAktivasiDashboardData');
    Route::any('/api/getSiteEntryDashboardData', 'Dashboard\HomeController@getSiteEntryDashboardData');
    Route::any('/api/getPermitLetterDashboardData', 'Dashboard\HomeController@getPermitLetterDashboardData');

    Route::get('/dashboard_data_clicked', 'Dashboard\HomeController@dashboard_data_clicked');

    //subDashboard
    // Route::get('/', 'Dashboard\DashboardController@index_testing')->name('dashboard.testing');
    Route::group(['prefix' => 'dashboard1'], function () {
        // Route::get('/dashboard/sla-pairing', 'Dashboard\DashboardController@index_testing')->name('dashboard.sla-pairing');
        Route::get('/', 'Dashboard\DashboardController@index_testing')->name('dashboard.testing');
    });


    Route::any('/save_notif', 'NotifController@save_notif');
    Route::any('/getNotif', 'NotifController@getData');
    Route::any('/deleteNotif', 'NotifController@deleteNotif');

    Route::group(['prefix' => 'report'], function () {
        Route::get('/task', 'ReportController@task');
        Route::get('/task_edit/{id}', 'ReportController@task_edit');
        Route::get('/task_delete/{id}', 'ReportController@task_delete');
        Route::any('/task_columns', 'ReportController@task_columns');
        Route::any('/task/pdf', 'ReportController@task_pdf');
        Route::get('/getReport/{type}', 'ReportController@getReport');

        Route::get('/get_aktivasi_layanan', 'ReportController@get_aktivasi_layanan');
        Route::get('/aktivasi', 'ReportController@aktivasi');
        Route::get('/aktivasi_edit/{id}', 'ReportController@aktivasi_edit');
        Route::get('/aktivasi_delete/{id}', 'ReportController@aktivasi_delete');
        Route::any('/aktivasi_columns', 'ReportController@aktivasi_columns');
        Route::any('/aktivasi/pdf', 'ReportController@aktivasi_pdf');

        Route::get('/get_site_entry', 'ReportController@get_site_entry');
        Route::get('/site_entry', 'ReportController@site_entry');
        Route::get('/site_entry_edit/{id}', 'ReportController@site_entry_edit');
        Route::get('/site_entry_delete/{id}', 'ReportController@site_entry_delete');
        Route::any('/site_entry_columns', 'ReportController@site_entry_columns');
        Route::any('/site_entry/pdf', 'ReportController@site_entry_pdf');

        Route::get('/get_permit_letter', 'ReportController@get_permit_letter');
        Route::get('/permit_letter', 'ReportController@permit_letter');
        Route::get('/permit_letter_edit/{id}', 'ReportController@permit_letter_edit');
        Route::get('/permit_letter_delete/{id}', 'ReportController@permit_letter_delete');
        Route::any('/permit_letter_columns', 'ReportController@permit_letter_columns');
        Route::any('/permit_letter/pdf', 'ReportController@permit_letter_pdf');
    });

    Route::group(['prefix' => 'task'], function () {
        Route::get('/old', 'Task\TaskController@index')->name('task');
        Route::get('/', 'Task\TaskController@index_testing')->name('task.testing');
        Route::get('/exportlistexcel', 'Task\TaskListDownloadController@download_list_excel_test')->name('exportlistexcel.excel');
        Route::get('/exportlistpdf', 'Task\TaskListDownloadController@download_list_pdf_test')->name('exportlistpdf.pdf');
        Route::get('/export7days', 'Task\ExcelTaskController@export7days')->name('export7days.excel');
        Route::get('/form_bulanan/{id_region}', 'FormBulananController@index')->name('form_bulanan.index');
        Route::get('/download_table_2/{id_region}', 'FormBulananController@download_table_2')->name('form_bulanan.download_table_2');
        Route::get('/download_table_3/{id_region}', 'FormBulananController@download_table_3')->name('form_bulanan.download_table_3');
        Route::get('/download_table_4/{id_region}', 'FormBulananController@download_table_4')->name('form_bulanan.download_table_4');
        Route::get('/download_table_5/{id_region}', 'FormBulananController@download_table_5')->name('form_bulanan.download_table_5');
        Route::put('/filter/{filter}', 'Task\TaskController@update_filter')->name('update.filter');
        Route::get('/task_schedule', 'Task\TaskController@index_schedule')->name('task_schedule');
        Route::get('/detail/{id_task}', 'Task\TaskController@detail')->name('task-detail');
        Route::get('/detail_schedule/{id_task}', 'Task\TaskController@detail_schedule')->name('task-detail-schedule');

        Route::get('/create', 'Task\TaskController@create')->name('task.create');
        Route::get('/create_schedule', 'Task\TaskController@create_schedule')->name('task.create.schedule');
        Route::any('/getTask', 'Task\TaskController@getData');
        Route::any('/getTaskSchedule', 'Task\TaskController@getDataSchedule');
        Route::post('/new_task', 'Task\TaskController@new_task');
        Route::post('/new_task_schedule', 'Task\TaskController@new_task_schedule');
        Route::any('/update_status/{id_task}', 'Task\TaskController@update_status');
        Route::any('/delete_task/{id_task}', 'Task\TaskController@delete_task')->name('task.delete');
        Route::any('/delete_task_schedule/{id_task}', 'Task\TaskController@delete_task_schedule');
        Route::any('/update_task/{id_task}', 'Task\TaskController@update_task');
        Route::any('/update_task_schedule/{id_task}', 'Task\TaskController@update_task_schedule');
        Route::any('/update_task_api/{id_task}', 'Task\TaskController@update_task_api');
        Route::any('/image_before_after/{id_task}', 'Task\TaskController@image_before_after');
        Route::any('/remove_image/{id_image}', 'Task\TaskController@remove_image');

        Route::any('/submit_task_checklist/{id_task}', 'Task\TaskController@submit_task_checklist');

        Route::post('/link_task', 'Task\TaskController@link_task');
        Route::post('/new_link_task', 'Task\TaskController@new_link_task')->name('task.new.link.task');
        Route::any('/getLinked', 'Task\TaskController@getLinked');

        Route::any('/download', 'Task\TaskController@download');

        Route::any('/chats/{id_task}', 'Task\TaskChatController@chats');
        Route::any('/chat/new_user/{id_task}', 'Task\TaskChatController@new_user_chat');
        Route::any('/chat/update_user/{id_task}', 'Task\TaskChatController@update_user_chat');
        Route::any('/getChats/{id_task}', 'Task\TaskChatController@getData');
        Route::any('/task_chats', 'Task\TaskChatController@index');
        Route::any('/getInboxs', 'Task\TaskChatController@getInboxs');
        Route::any('/getChatByInbox', 'Task\TaskChatController@getChatByInbox');
        Route::any('/getChatByTask', 'Task\TaskChatController@getChatByTask');

        Route::any('/checklist_answers/pdf', 'Task\TaskController@checklist_answers_pdf');
        Route::any('/pdf_task_plm/pdf', 'Task\TaskController@pdf_task_plm');
        Route::any('/checklist_answers/excel', 'Task\TaskController@checklist_answers_excel');
        Route::any('/plm_task_excel/excel', 'Task\TaskController@task_plm_excel');
    });
    Route::group(['prefix' => 'waiting_approval'], function () {
        Route::get('/', 'WaitingApprovalController@index')->name('waiting_approval');
        Route::get('/detail/{id_task}', 'WaitingApprovalController@detail');
        Route::any('/getWaitingApproval', 'WaitingApprovalController@getData');
        Route::post('/approval/{id_task}', 'WaitingApprovalController@approval');
        Route::post('/approval_api/{id_task}', 'WaitingApprovalController@approval_api');

        Route::get('/aktivasi', 'WaitingApprovalController@aktivasi');
        Route::get('/aktivasi/detail/{id}', 'WaitingApprovalController@aktivasi_detail');
        Route::any('/getAktivasiWaitingApproval', 'WaitingApprovalController@getAktivasiData');

        Route::group(['prefix' => 'site-permit'], function () {
            Route::get('/', 'WaitingApprovalController@site_permit');

            Route::any('/getSiteEntry', 'WaitingApprovalController@getSiteEntry');
            Route::get('/site-entry-detail/{id}', 'WaitingApprovalController@detailSiteEntry');

            Route::any('/getPermitLetter', 'WaitingApprovalController@getPermitLetter');
            Route::get('/permit-letter-detail/{id}', 'WaitingApprovalController@detailPermitLetter');

            Route::post('/site-entry-approval/{id_site_entry}', 'WaitingApprovalController@siteEntryApproval');
            Route::post('/site-entry-approval-checkout/{id_site_entry}', 'SitePermitController@siteEntryApprovalCheckout');
            Route::post('/permit-letter-approval/{id_permit_letter}', 'WaitingApprovalController@permitLetterApproval');

            Route::get('/permit-letter-pdf', 'WaitingApprovalController@pdfPermitLetter');
            Route::get('/site-entry-pdf', 'WaitingApprovalController@pdfSiteEntry');
        });
    });

    Route::group(['prefix' => 'aktivasi-layanan'], function () {
        Route::get('/', 'Activasi\ActivasiController@index')->name('aktivasi');
        Route::get('/create', 'Activasi\ActivasiController@create');
        Route::get('/detail/{id}', 'Activasi\ActivasiController@detail');
        Route::post('/aktivasi-update/{id}', 'Activasi\ActivasiController@update_aktivasi');
        Route::any('/delete_aktivasi/{id}', 'Activasi\ActivasiController@delete_aktivasi');
        Route::post('/new_aktivasi', 'Activasi\ActivasiController@new_aktivasi');
        Route::any('/getAktivasi', 'Activasi\ActivasiController@getData');
        Route::any('/aktivasi-layanan-approval/{id}', 'Activasi\ActivasiController@approval');
        Route::any('/aktivasi-layanan-approval-api/{id}', 'Activasi\ActivasiController@approval_api');

        Route::any('/getStatus', 'Activasi\ActivasiController@getStatus');
    });
    Route::group(['prefix' => 'site-permit'], function () {
        Route::get('/', 'Site\SitePermitController@index')->name('sitePermit');
        Route::get('/site-entry', 'Site\SitePermitController@siteEntry')->name('siteEntry');
        Route::post('/new-site-entry', 'Site\SitePermitController@newSiteEntry');
        Route::any('/getSiteEntry', 'Site\SitePermitController@getSiteEntry');
        Route::get('/site-entry-detail/{id}', 'Site\SitePermitController@detailSiteEntry');
        Route::get('/delete_site_entry/{id}', 'Site\SitePermitController@delete_site_entry');
        Route::post('/site-entry-update/{id}', 'Site\SitePermitController@updateSiteEntry');

        Route::get('/permit-letter', 'Site\SitePermitController@permitLetter')->name('permitLetter');
        Route::post('/new-permit-letter', 'Site\SitePermitController@newPermitLetter');
        Route::any('/getPermitLetter', 'Site\SitePermitController@getPermitLetter');
        Route::get('/permit-letter-detail/{id}', 'Site\SitePermitController@detailPermitLetter');
        Route::post('/permit-letter-update/{id}', 'Site\SitePermitController@updatePermitLetter');

        Route::post('/site-entry-approval/{id_site_entry}', 'Site\SitePermitController@siteEntryApproval');
        Route::post('/site-entry-approval-checkout/{id_site_entry}', 'Site\SitePermitController@siteEntryApprovalCheckout');

        Route::post('/permit-letter-approval/{id_permit_letter}', 'Site\SitePermitController@permitLetterApproval');

        Route::get('/permit-letter-pdf', 'Site\SitePermitController@pdfPermitLetter');
        Route::get('/site-entry-pdf', 'Site\SitePermitController@pdfSiteEntry');
    });

    Route::get('/setup', 'Setup\SetupController@index')->name('setup');
    Route::get('/setup/servicedesk', 'Setup\SetupController@servicedesk')->name('servicedesk');

    Route::any('/getSiteCat', 'Setup\Servicedesk\SiteController@getSiteCat');
    Route::any('/getRegion', 'Setup\Servicedesk\RegionController@getRegion');

    Route::group(['prefix' => 'setup'], function () {

        Route::group(['prefix' => 'userpermission'], function () {
            Route::any('/delete_task_approver', 'Setup\UserPermission\UserPermissionController@delete_task_approver');
            Route::any('/delete_site_entry_approver', 'Setup\UserPermission\UserPermissionController@delete_site_entry_approver');
            Route::any('/delete_aktivasi_approver', 'Setup\UserPermission\UserPermissionController@delete_aktivasi_approver');

            Route::get('/', 'Setup\UserPermission\UserPermissionController@index');
            Route::post('/new_route', 'Setup\UserPermission\UserPermissionController@new_route');
            Route::get('/getRoute', 'Setup\UserPermission\UserPermissionController@getRoute');

            Route::get('/role/{id_role}', 'Setup\UserPermission\UserPermissionController@detailRole');
            Route::post('/role/{id_role}/update_access', 'Setup\UserPermission\UserPermissionController@update_access');
            Route::any('/delete_role', 'Setup\UserPermission\UserPermissionController@delete_role');

            Route::get('/getGroupCustomer', 'Setup\UserPermission\UserPermissionController@getGroupCustomer');
            Route::get('/getGroupInternal', 'Setup\UserPermission\UserPermissionController@getGroupInternal');
            Route::get('/getGroupUser', 'Setup\UserPermission\UserPermissionController@getGroupUser');
            Route::get('/getTechnicians', 'Setup\UserPermission\UserPermissionController@getTechnicians');
            Route::any('/delete_technician/{id_technician}', 'Setup\UserPermission\UserPermissionController@delete_technician');
            Route::any('/update_technician', 'Setup\UserPermission\UserPermissionController@update_technician');


            Route::any('/getCustomer', 'Setup\UserPermission\UserPermissionController@getCustomer');
            Route::any('/new_customer', 'Setup\UserPermission\UserPermissionController@new_customer');
            Route::any('/edit_customer', 'Setup\UserPermission\UserPermissionController@edit_customer');
            Route::any('/delete_customer', 'Setup\UserPermission\UserPermissionController@delete_customer');

            Route::any('/getDepartement', 'Setup\UserPermission\UserPermissionController@getDepartement');
            Route::any('/new_departement', 'Setup\UserPermission\UserPermissionController@new_departement');
            Route::any('/edit_departement', 'Setup\UserPermission\UserPermissionController@edit_departement');
            Route::any('/delete_departement', 'Setup\UserPermission\UserPermissionController@delete_departement');

            Route::post('/new_group_customer', 'Setup\UserPermission\UserPermissionController@new_group_customer');
            Route::post('/new_group_internal', 'Setup\UserPermission\UserPermissionController@new_group_internal');
            Route::any('/delete_group_internal/{id_group_internal}', 'Setup\UserPermission\UserPermissionController@delete_group_internal');
            Route::any('/delete_group_external/{id_group_external}', 'Setup\UserPermission\UserPermissionController@delete_group_external');
            Route::post('/new_group_user/{type}', 'Setup\UserPermission\UserPermissionController@new_group_user');
            Route::post('/new_technician', 'Setup\UserPermission\UserPermissionController@new_technician');
            Route::post('/new_validator', 'Setup\UserPermission\UserPermissionController@new_validator');

            Route::group(['prefix' => 'approver'], function () {
                Route::get('/', 'Setup\UserPermission\ApproverController@index')->name('approver');
                Route::post('/new_approver', 'Setup\UserPermission\ApproverController@new_approver');
                Route::any('/getApprover', 'Setup\UserPermission\ApproverController@getApprover');
                Route::post('/edit_approver', 'Setup\UserPermission\ApproverController@edit_approver');
            });

            Route::group(['prefix' => 'site_entry_approver'], function () {
                Route::get('/', 'Setup\UserPermission\SiteEntryApproverController@index')->name('site_entry_approver');
                Route::post('/new_approver', 'Setup\UserPermission\SiteEntryApproverController@new_approver');
                Route::any('/getApprover', 'Setup\UserPermission\SiteEntryApproverController@getApprover');
                Route::post('/edit_approver', 'Setup\UserPermission\SiteEntryApproverController@edit_approver');
            });

            Route::group(['prefix' => 'aktivasi_approver'], function () {
                Route::get('/', 'Setup\UserPermission\AktivasiApproverController@index')->name('aktivasi_approver');
                Route::post('/new_approver', 'Setup\UserPermission\AktivasiApproverController@new_approver');
                Route::any('/getApprover', 'Setup\UserPermission\AktivasiApproverController@getApprover');
                Route::post('/edit_approver', 'Setup\UserPermission\AktivasiApproverController@edit_approver');
            });
        });

        Route::get('/notif-setting', 'Setup\SetupController@notif')->name('notif');
        Route::get('/Customization', 'Setup\SetupController@Customization')->name('Customization');
        Route::get('/chat', 'Setup\ChatController@chat')->name('chat');

        Route::get('/template-form/{id_type}', 'TaskTemplateController@index')->name('template_form');
        Route::get('/template-form/{id_type}/create', 'TaskTemplateController@create');
        Route::any('/template-form/{id_type}/delete_template/{id}', 'TaskTemplateController@remove_template')->name('template.destroy'); //dz
        Route::post('/template-form/{id_type}/new_task_templates_value', 'TaskTemplateController@new_task_templates_value');
        Route::any('/template-form/{id_type}/template_add_ons', 'TaskTemplateController@template_add_ons');
        Route::any('/template-form/{id_type}/template_addons', 'TaskTemplateController@template_addons');

        Route::group(['prefix' => 'Customization/{id_type}'], function () {
            Route::get('/category', 'Setup\Customization\CategoryController@index')->name('category');
            Route::get('/status', 'Setup\Customization\StatusController@index')->name('status');
            Route::get('/getCategory', 'Setup\Customization\CategoryController@getData');
            Route::post('/new_category', 'Setup\Customization\CategoryController@newData');
            Route::post('/update_category', 'Setup\Customization\CategoryController@updateData');
            Route::any('/delete_category/{id_category}', 'Setup\Customization\CategoryController@remove_category');

            Route::get('/getSubCategory', 'Setup\Customization\SubCategoryController@getSubCat');
            Route::post('/new_sub_category', 'Setup\Customization\SubCategoryController@newData');
            Route::post('/update_sub_category', 'Setup\Customization\SubCategoryController@updateData');

            Route::post('/new_status', 'Setup\Customization\StatusController@newData');
            Route::get('/getStatus', 'Setup\Customization\StatusController@getData');
            Route::post('/update_status', 'Setup\Customization\StatusController@updateData');

            Route::get('/getItem', 'Setup\Customization\ItemController@getData');
            Route::post('/new_item', 'Setup\Customization\ItemController@newData');
            Route::post('/update_item', 'Setup\Customization\ItemController@updateData');

            Route::get('/getImpact', 'Setup\Customization\ImpactController@getData');
            Route::get('/impact', 'Setup\Customization\ImpactController@index')->name('impact');
            Route::post('/new_impact', 'Setup\Customization\ImpactController@newData');
            Route::post('/update_impact', 'Setup\Customization\ImpactController@updateData');
            Route::any('/delete_impact/{id_impact}', 'Setup\Customization\ImpactController@remove_impact');
            Route::get('/getPriority', 'Setup\Customization\PriorityController@getData');
            Route::get('/priority', 'Setup\Customization\PriorityController@index')->name('priority');
            Route::post('/new_priority', 'Setup\Customization\PriorityController@newData');
            Route::post('/update_priority', 'Setup\Customization\PriorityController@updateData');
            Route::any('/delete_priority/{id_priority}', 'Setup\Customization\PriorityController@remove_priority');
            Route::get('/task_type', 'Setup\Customization\TasktypeController@index')->name('taskType');

            Route::any('/getChecklist', 'Setup\Customization\ChecklistController@getData');
            Route::get('/checklist', 'Setup\Customization\ChecklistController@index');
            Route::post('/new_checklist', 'Setup\Customization\ChecklistController@newData');

            Route::get('/new_checklist_2', 'Setup\Customization\ChecklistController@newData2');

            Route::post('/update_checklist', 'Setup\Customization\ChecklistController@updateData');
            Route::any('/delete_checklist/{id_checklist}', 'Setup\Customization\ChecklistController@remove_checklist');
            Route::post('/new_checklist_category', 'Setup\Customization\ChecklistController@new_checklist_category');
            Route::post('/new_checklist_periode', 'Setup\Customization\ChecklistController@new_checklist_periode');
            Route::any('/task_checklist', 'Setup\Customization\ChecklistController@task_checklist');
        });

        Route::group(['prefix' => 'data-administration'], function () {
            Route::get('/data-archive', 'Setup\DataAdministration\DataArchiveController@index')->name('archive');
            Route::get('/system-log', 'Setup\DataAdministration\SystemLogController@index')->name('systemLog');
        });



        #########################################

        Route::group(['prefix' => 'servicedesk'], function () {

            // Status As Parent





            // Region desk As Parent
            Route::group(['prefix' => 'region'], function () {
                Route::get('/getRegion', 'Setup\Servicedesk\RegionController@getData');

                Route::get('/', 'Setup\Servicedesk\RegionController@index')->name('region');
                Route::post('/add', 'Setup\Servicedesk\RegionController@store')->name('region.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\RegionController@edit')->name('region.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\RegionController@update')->name('region.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\RegionController@delete')->name('region.delete');
            });

            Route::group(['prefix' => 'segment'], function () {
                Route::get('/getSegment', 'Setup\Servicedesk\SegmentController@getData');

                Route::get('/', 'Setup\Servicedesk\SegmentController@index')->name('segment');
                Route::post('/add', 'Setup\Servicedesk\SegmentController@store')->name('segment.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\SegmentController@edit')->name('segment.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\SegmentController@update')->name('segment.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\SegmentController@delete')->name('segment.delete');
            });
            Route::group(['prefix' => 'asset'], function () {
                Route::get('/getAsset', 'Setup\Servicedesk\AssetController@getData');

                Route::get('/', 'Setup\Servicedesk\AssetController@index')->name('asset');
                Route::post('/add', 'Setup\Servicedesk\AssetController@store')->name('asset.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\AssetController@edit')->name('asset.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\AssetController@update')->name('asset.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\AssetController@delete')->name('asset.delete');
            });
            Route::group(['prefix' => 'rootcaused'], function () {
                Route::get('/', 'Setup\Servicedesk\RootcausedController@index')->name('rootcaused');
                Route::post('/add', 'Setup\Servicedesk\RootcausedController@store')->name('rootcaused.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\RootcausedController@edit')->name('rootcaused.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\RootcausedController@update')->name('rootcaused.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\RootcausedController@delete')->name('rootcaused.delete');
            });
            Route::group(['prefix' => 'task_type'], function () {
                Route::get('/', 'Setup\Servicedesk\TasktypeController@index')->name('taskType');
                Route::post('/add', 'Setup\Servicedesk\TasktypeController@store')->name('taskType.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\TasktypeController@edit')->name('taskType.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\TasktypeController@update')->name('taskType.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\TasktypeController@delete')->name('taskType.delete');

                Route::any('/getTaskType', 'Setup\Servicedesk\TasktypeController@getData');
            });

            Route::group(['prefix' => 'site'], function () {
                Route::get('/getSite', 'Setup\Servicedesk\SiteController@getData');

                Route::get('/', 'Setup\Servicedesk\SiteController@index')->name('sites');
                Route::get('/new', 'Setup\Servicedesk\SiteController@new');
                Route::post('/add', 'Setup\Servicedesk\SiteController@store')->name('sites.add');
                Route::get('/edit/{id}', 'Setup\Servicedesk\SiteController@edit')->name('sites.edit');
                Route::post('/update/{id}', 'Setup\Servicedesk\SiteController@update')->name('sites.update');
                Route::Post('/delete/{id}', 'Setup\Servicedesk\SiteController@delete')->name('sites.delete');
            });
        });

        Route::group(['prefix' => 'aktivasi_layanan'], function () {
            Route::get('/', 'Setup\AktivasiLayanan\AktivasiLayananController@index');

            Route::group(['prefix' => 'cord'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\CordController@index')->name('cord');
                Route::post('/new_cord', 'Setup\AktivasiLayanan\CordController@new_cord');
                Route::any('/getCord', 'Setup\AktivasiLayanan\CordController@getCord');
                Route::post('/edit_cord', 'Setup\AktivasiLayanan\CordController@edit_cord');
            });
            Route::group(['prefix' => 'layanan'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\LayananController@index')->name('layanan');
                Route::post('/new_layanan', 'Setup\AktivasiLayanan\LayananController@new_layanan');
                Route::get('/getLayanan', 'Setup\AktivasiLayanan\LayananController@getLayanan');
                Route::post('/edit_layanan', 'Setup\AktivasiLayanan\LayananController@edit_layanan');
                Route::any('/delete_layanan/{id_layanan}', 'Setup\AktivasiLayanan\LayananController@remove_layanan');
            });

            Route::group(['prefix' => 'totalcapacity'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\TotalCapacityController@index')->name('totalcapacity');
                Route::post('/new_totalcapacity', 'Setup\AktivasiLayanan\TotalCapacityController@new_totalcapacity');
                Route::get('/getTotalcapacity', 'Setup\AktivasiLayanan\TotalCapacityController@getTotalcapacity');
                Route::post('/edit_totalcapacity', 'Setup\AktivasiLayanan\TotalCapacityController@edit_totalcapacity');
                Route::any('/delete_totalcapacity/{id_total_capacity}', 'Setup\AktivasiLayanan\TotalCapacityController@remove_totalcapacity');
            });

            Route::group(['prefix' => 'cid'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\CidController@index')->name('cid');
                Route::post('/new_data', 'Setup\AktivasiLayanan\CidController@new_data');
                Route::any('/getData', 'Setup\AktivasiLayanan\CidController@getData');
                Route::post('/edit_data', 'Setup\AktivasiLayanan\CidController@edit_data');
            });

            Route::group(['prefix' => 'slot'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\SlotController@index')->name('slot');
                Route::post('/new_data', 'Setup\AktivasiLayanan\SlotController@new_data');
                Route::any('/getData', 'Setup\AktivasiLayanan\SlotController@getData');
                Route::post('/edit_data', 'Setup\AktivasiLayanan\SlotController@edit_data');
            });

            Route::group(['prefix' => 'shelf'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\ShelfController@index')->name('slot');
                Route::post('/new_data', 'Setup\AktivasiLayanan\ShelfController@new_data');
                Route::any('/getData', 'Setup\AktivasiLayanan\ShelfController@getData');
                Route::post('/edit_data', 'Setup\AktivasiLayanan\ShelfController@edit_data');
            });

            Route::group(['prefix' => 'status'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\StatusController@index');
                Route::post('/new_data', 'Setup\AktivasiLayanan\StatusController@new_data');
                Route::any('/getData', 'Setup\AktivasiLayanan\StatusController@getData');
                Route::post('/edit_data', 'Setup\AktivasiLayanan\StatusController@edit_data');
            });
            Route::group(['prefix' => 'status_collocation'], function () {
                Route::get('/', 'Setup\AktivasiLayanan\StatusCollocationController@index');
                Route::post('/new_data', 'Setup\AktivasiLayanan\StatusCollocationController@new_data');
                Route::any('/getData', 'Setup\AktivasiLayanan\StatusCollocationController@getData');
                Route::post('/edit_data', 'Setup\AktivasiLayanan\StatusCollocationController@edit_data');
            });
        });



        Route::get('/getSegment', 'Setup\SetupController@getSegment');
        Route::get('/getShelf', 'Setup\SetupController@getShelf');
        Route::get('/getSlot', 'Setup\SetupController@getSlot');
        Route::get('/getPort', 'Setup\SetupController@getPort');
        Route::get('/getCid', 'Setup\SetupController@getCid');
    });
});

Route::get('/', function () {
    if (Auth::user()) return redirect()->to('dashboard');
    return view('login');
});
Route::get('/login', function () {
    if (Auth::user()) return redirect()->to('dashboard');
    return view('login');
})->name('login');

Route::get('/forgot_password', function () {
    if (Auth::user()) return redirect()->to('dashboard');
    return view('forgot_password');
});

// auth
Auth::routes(['register' => false, 'login' => false]);
Route::post('/auth_login', 'LoginController@login');
Route::any('/reset_password', 'LoginController@reset_password');
Route::any('/api/reset_password', 'LoginController@reset_password');
Route::post('/api/new_password', 'LoginController@new_password');
Route::post('/api/validate_otp', 'LoginController@validate_otp');
Route::any('/api/api_login', 'UserController@api_login');
Route::any('/api/api_logout', 'UserController@api_logout');

Route::get('/user/profile', 'UserController@profile');
Route::any('/user/update_profile/{id}', 'UserController@update_profile');

Route::get('/task_attachment/{any}', function ($one) {
    $path = base_path("public/task_attachment/$one");
    if (!file_exists($path)) {
        $path = base_path("public/images/No_picture_available.png");
    }
    return response()->file($path);
});
Route::get('/task_report/{any}', function ($one) {
    $path = base_path("public/task_report/$one");
    if (!file_exists($path)) {
        $path = base_path("public/images/No_picture_available.png");
    }
    return response()->file($path);
});
Route::get('/checklist_image/{any}', function ($one) {
    $path = base_path("public/checklist_image/$one");
    if (!file_exists($path)) {
        $path = base_path("public/images/No_picture_available.png");
    }
    return response()->file($path);
});
Route::get('/aktivasi/memo/{any}', function ($one) {
    $path = base_path("public/aktivasi/memo/$one");
    if (!file_exists($path)) {
        $path = base_path("public/images/No_picture_available.png");
    }
    return response()->file($path);
});
Route::get('/aktivasi/bakti/{any}', function ($one) {
    $path = base_path("public/aktivasi/bakti/$one");
    if (!file_exists($path)) {
        $path = base_path("public/images/No_picture_available.png");
    }
    return response()->file($path);
});
