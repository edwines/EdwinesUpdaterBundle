<?php

/**
 * This file is part of the EdwinesUpdaterBundle package.
 *
 * (c) Edwin Ibarra <edwines@feniaz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Edwines\UpdaterBundle\Service;

class GitContainer
{
    /**
     * @var \PHPGit_Repository
     */
    protected $repo;

    /**
     * @param string $path The path to the repository
     */
    public function __construct($repoPath, $executablePath)
    {
        $this->repo = new \PHPGit_Repository($repoPath, false, array('git_executable' => $executablePath));
    }

    /**
     * Magic function to use the shortcuts methods provided by PHPGit_Repository
     * see: {@link https://github.com/ornicar/php-git-repo#get-branches-informations}
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->repo, $name)) {
            return call_user_func_array(array($this->repo, $name), $arguments);
        }
    }

    /**
     * @param string $comand
     */
    public function git($command)
    {
        return $this->repo->git($command);
    }
}