<?php

namespace OpenCFP\Domain\Services;

use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface UserAccess
{
    /**
     * If a user doesn't have access to a page they get redirected, otherwise nothing happens
     *
     * @param Application $app
     *
     * @return RedirectResponse|void
     */
    public static function userHasAccess(Application $app);
}
