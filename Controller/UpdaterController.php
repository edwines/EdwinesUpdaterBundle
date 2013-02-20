<?php

/**
 * This file is part of the EdwinesUpdaterBundle package.
 *
 * (c) Edwin Ibarra <edwines@feniaz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Edwines\UpdaterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Request;

class UpdaterController extends Controller
{
    public function indexAction()
    {
        $repo = $this->get('ed_updater.git');

        return $this->render('EdwinesUpdaterBundle:Updater:index.html.twig', array(
            'repo' => $repo
        ));
    }

    public function hookAction(Request $request)
    {
        $payload = $request->request->get('payload');

        if (null == $payload) {
            throw new \InvalidArgumentException('Payload required.');
        }

        $payload = json_decode($payload, true);

        // If the repo is pulled, then clear the cache
        if ($this->get('ed_updater.provider')->process($payload)) {
            $application = new Application($this->get('kernel'));
            $application->run(new StringInput('cache:clear --env=prod'));

            if(extension_loaded('apc') && ini_get('apc.enabled')) {
                apc_clear_cache();
                apc_clear_cache('user');
                apc_clear_cache('opcode');
            }
        }

        return $this->render('EdwinesUpdaterBundle:Updater:hook.html.twig');
    }
}