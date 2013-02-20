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

interface ProviderInterface
{
    /**
     * Check the payload sent by the git provider and make the update.
     *
     * @param array $payload
     *
     * @return boolean
     */
    function process($payload);
}