{{ '<?php' }}

namespace Deployer;

require 'recipe/laravel.php';

set('application', '{{ $server->name  }}');
set('repository', '{{ $site->repository }}');
set('git_tty', false);
set('keep_releases', 5);
add('shared_files', [ '.env' ]));
add('shared_dirs', []);
set('release_use_sudo', true);
set('allow_anonymous_stats', false);

host('{{ $server->ip  }}')
    ->port({{ $server->ssh_port  }})
    ->user('sputnik')
    ->set('branch', '{{ $site->repository_branch }}')
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '{{ $site->path() }}');

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');
