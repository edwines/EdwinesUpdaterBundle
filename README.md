# Updater Bundle

[![Total Downloads](https://poser.pugx.org/edwines/updater-bundle/downloads.png)](https://packagist.org/packages/edwines/updater-bundle)
[![Latest Unstable Version](https://poser.pugx.org/edwines/updater-bundle/v/unstable.png)](https://packagist.org/packages/edwines/updater-bundle)

This bundle allow updating the repository in production; using git
service hooks provided by some git hosting system (like GitHub). Currently these
providers are supported:

- GitHub
- Bitbucket

But you can build your custom provider.

## Requirements

The production server needs to have git installed and configured to connect with
 the provider. Also the repository of the Symfony project need to has write
permissions to the web user (usually named ``www-data``).

## Installation

### Step 1: Download EdwinesUpdaterBundle

Add the following dependency in your composer.json

```json
{
    "require": {
        "edwines/updater-bundle": "dev-master",
    }
}
```
Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update edwines/updater-bundle
```

### Step 2: Enable de bundle

Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Edwines\UpdaterBundle\EdwinesUpdaterBundle(),
    );
}
```

### Step 3: Configure the bundle

By default you don't need to set the configuration. But if you want to change the
default values, just follow the next instructions:

The bundle set the directory of the repository to `%kernel.root_dir%/../` to edit
it just set the `repo_path`:

```yml
# app/config/config.yml

edwines_updater:
    repo_path: /project/repository/path/
```
By default the provider is GitHub, if you want to use Bitbucket:

```yml
# app/config/config.yml

edwines_updater:
    provider: Edwines\UpdaterBundle\Provider\Bitbucket
```

### Step 4: Add routes

If you want to have all the routes (the route for update the system, and another
one to see the git status)

```yml
# app/config/routing.yml

ed_updater:
    resource: "@EdwinesUpdaterBundle/Resources/config/routing/updater.yml"
    prefix:   /my-updater-prefix
```

Or if only want the route to update the project:

```yml
# app/config/routing.yml

ed_updater:
    resource: "@EdwinesUpdaterBundle/Resources/config/routing/hook.yml"
    prefix:   /my-hook-prefix
```

### Step 5: Add POST service to your provider

Now, you need to add a new service hook in your provider (see the 
[GitHub help][1]). Your hook url will be 
``http://my-domain.com/my-updater-prefix/hook/`` or if you configure to only use
the hook url: ``http://my-domain.com/my-hook-prefix/``

## How it works

When the bundle receives the payload of the provider, it compare if the modified
branch is the same of the current project.. then automatically run the command
``git pull origin {current_branch}``, and finally erase the cache.

You can see the git status of your project and the last commits in the url
 ``http://my-domain.com/my-updater-prefix/``

[1]: https://help.github.com/articles/post-receive-hooks
