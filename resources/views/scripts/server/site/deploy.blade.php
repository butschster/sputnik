# ================================================
# Deploy {{ class_basename($owner) }} {{ $owner->getKey() }}
# ================================================

// TODO
ssh-keyscan -H github.com >> ~/.ssh/known_hosts
ssh-keyscan -H bitbucket.com >> ~/.ssh/known_hosts

if [ ! -d {{ $path }} ]
then
    mkdir -p {{ $path }}
fi

if [ -d {{ $path.'/current' }} ] && [ ! -L {{ $path.'/current' }} ]
then
    rm -rf {{ $path.'/current' }}
fi

cat > {{ $path }}/deploy.php << EOF
@php echo '<?php'; @endphp

namespace Deployer;

require 'recipe/laravel.php';

set('application', '{{ $server->name  }}');
set('repository', '{{ $repository }}');
set('git_tty', false);
set('keep_releases', 5);
add('shared_files', []);
add('shared_dirs', []);
set('release_use_sudo', true);
set('allow_anonymous_stats', false);

host('{{ $server->ip  }}')
    ->port({{ $server->ssh_port  }})
    ->user('root')
    ->set('branch', '{{ $repository_branch }}')
    ->identityFile('/root/.ssh/id_rsa')
    ->set('deploy_path', '{{ $path }}')
    ->addSshOption('StrictHostKeyChecking', 'no');

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');

EOF

if [ ! -d {{ $path.'/shared' }} ]
then
    mkdir -p {{ $path.'/shared' }}
fi

cat > {{ $path.'/shared/.env' }} << EOF
@include('scripts.server.site.env')

EOF

cd {{ $path }} && dep deploy:unlock && dep deploy