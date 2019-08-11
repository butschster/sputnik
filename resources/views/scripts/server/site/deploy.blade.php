
# ================================================
# Deploy site {{ $site->domain }}
# ================================================

if [ ! -d {{ $site->path() }} ]
then
    mkdir -p {{ $site->path() }}
fi

if [ -d {{ $site->path().'/current' }} ]
then
    rm -rf {{ $site->path().'/current' }}
fi

cat > {{ $site->path() }}/deploy.php << EOF
<?php echo '<?php'; ?>

namespace Deployer;

require 'recipe/laravel.php';

set('application', '{{ $server->name  }}');
set('repository', '{{ $site->repository }}');
set('git_tty', false);
set('keep_releases', 5);
add('shared_files', []);
add('shared_dirs', []);
set('release_use_sudo', true);
set('allow_anonymous_stats', false);

host('{{ $server->ip  }}')
    ->port({{ $server->ssh_port  }})
    ->user('root')
    ->set('branch', '{{ $site->repository_branch }}')
    ->identityFile('/root/.ssh/id_rsa')
    ->set('deploy_path', '{{ $site->path() }}')
    ->addSshOption('StrictHostKeyChecking', 'no');

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');

EOF

if [! -d {{ $site->path().'/shared' }} ]
then
    mkdir -p {{ $site->path().'/shared' }}
fi

cat > {{ $site->path().'/shared/.env' }} << EOF
@include('scripts.server.site.env')

EOF


cd {{ $site->path() }} && dep deploy:unlock && dep deploy
