<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/*',
        '/api_login',
        '/task/*',
        '/user/*',
        '/setup/servicedesk/task_type/getTaskType',
        '/firebase/*',
        '/setup/Customization/2/getChecklist',
        '/setup/Customization/2/task_checklist',
        '/waiting_approval/*',
        '/site-permit/getPermitLetter/'
    ];
}
