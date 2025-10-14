<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Entities\User;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        /** @var User|null $user */
        $user = $session->get('user');

        if (!$user instanceof User) {
            log_message('info', 'Unauthorized access attempt to: ' . uri_string());
            $session->setFlashdata('error', 'Vous devez être connecté pour accéder à cette page.');
            return redirect()->to('/sign-in');
        }

        if (!$user->isActive()) {
            log_message('warning', "Inactive user {$user->id} tried to access: " . uri_string());
            $session->setFlashdata('error', 'Votre compte a été désactivé.');
        }

        $lastActivity = $session->get('last_activity');
        $sessionTimeout = 3600; // 1 heure

        if ($lastActivity && (time() - $lastActivity) > $sessionTimeout) {
            log_message('info', "Session expired for user {$user->id}");
            $session->destroy();
            $session->setFlashdata('error', 'Votre session a expiré. Veuillez vous reconnecter.');
            return redirect()->to('/sign-in');
        }

        $session->set('last_activity', time());

        if (!empty($arguments)) {
            $isAllowed = false;

            foreach ($arguments as $requiredRoleSlug) {
                if ($user->check($requiredRoleSlug)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                log_message('warning', "User {$user->id} tried to access: " . uri_string() . " without required roles: " . implode(', ', $arguments));
                $session->setFlashdata('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
                return redirect()->to('/forbidden');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        return $response;
    }
}
