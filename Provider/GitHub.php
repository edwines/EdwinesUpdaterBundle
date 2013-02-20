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
 * Payload: {@link https://help.github.com/articles/post-receive-hooks}
 *
 * @todo
 */
class GitHub implements ProviderInterface
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
    {}
}