<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        
        // Skip authentication check for login routes
        if (strpos($path, '/admin/login') === 0) {
            return;
        }
        
        $session = session();
        
        if (!$session->has('admin_logged_in') || !$session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Check role if required
        if (!empty($arguments)) {
            $userRole = $session->get('admin_role');
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/admin/dashboard')->with('error', 'You do not have permission to access this page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
