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
        // Normalize: strip index.php so /index.php/admin/pickups becomes /admin/pickups (avoids redirect loop)
        $path = preg_replace('#^/index\.php#', '', $path);
        $path = '/' . ltrim($path, '/');
        $path = rtrim($path, '/') ?: '/';

        // Skip authentication check for login routes
        if (strpos($path, '/admin/login') === 0) {
            return;
        }

        $session = session();

        if (!$session->has('admin_logged_in') || !$session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Driver can only view Pickups and Donors (no dashboard, inventory, recipients, users, or any POST)
        $role = $session->get('admin_role');
        if ($role === 'driver') {
            $method = $request->getMethod();
            $allowed = false;
            if (strtoupper($method) === 'GET') {
                if ($path === '/admin' || $path === '/admin/') {
                    return redirect()->to('/admin/pickups');
                }
                if (strpos($path, '/admin/pickups') === 0 || strpos($path, '/admin/donations') === 0) {
                    $allowed = true;
                }
            }
            if (!$allowed) {
                return redirect()->to('/admin/pickups')->with('error', 'You do not have permission to access this page.');
            }
        }

        // Check role if required (for routes that pass allowed roles)
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
