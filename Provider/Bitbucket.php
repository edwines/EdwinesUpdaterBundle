<?php

/**
 * This file is part of the EdwinesUpdaterBundle package.
 *
 * (c) Edwin Ibarra <edwines@feniaz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Edwines\UpdaterBundle\Provider;

use Edwines\UpdaterBundle\Service\GitContainer;

/**
 * Payload: {@link https://confluence.atlassian.com/display/BITBUCKET/POST+Service+Management}
 *
 * @author Edwin Ibarra <edwines@feniaz.com>
 */
class Bitbucket implements ProviderInterface
{
    /**
     * @var GitContainer
     */
    protected $repo;

    public function __construct(GitContainer $repo)
    {
        $this->repo = $repo;
    }

    /**
     * {@inheritdoc}
     */
    public function process($payload)
    {
        if (!isset($payload['commits']) && !isset($payload['commits'][0]['branch'])) {
            throw new \InvalidArgumentException('The payload does not seem to come from Bitbucket.');
        }

        $branch = $this->repo->getCurrentBranch();
        $pulled = false;

        // If one of the commits is for the current branch, then update.
        foreach ($payload['commits'] as $commit) {
            if ($commit['branch'] != $branch) {
                continue;
            }

            $this->repo->git(sprintf('pull origin %s', $branch));
            $this->repo->git('submodule init');
            $this->repo->git('submodule update');
            $pulled = true;
            break;
        }

        return $pulled;
    }
}
