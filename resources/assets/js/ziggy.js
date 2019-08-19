    var Ziggy = {
        namedRoutes: {"cashier.payment":{"uri":"stripe\/payment\/{id}","methods":["GET","HEAD"],"domain":null},"cashier.webhook":{"uri":"stripe\/webhook","methods":["POST"],"domain":null},"passport.authorizations.authorize":{"uri":"oauth\/authorize","methods":["GET","HEAD"],"domain":null},"passport.authorizations.approve":{"uri":"oauth\/authorize","methods":["POST"],"domain":null},"passport.authorizations.deny":{"uri":"oauth\/authorize","methods":["DELETE"],"domain":null},"passport.token":{"uri":"oauth\/token","methods":["POST"],"domain":null},"passport.tokens.index":{"uri":"oauth\/tokens","methods":["GET","HEAD"],"domain":null},"passport.tokens.destroy":{"uri":"oauth\/tokens\/{token_id}","methods":["DELETE"],"domain":null},"passport.token.refresh":{"uri":"oauth\/token\/refresh","methods":["POST"],"domain":null},"passport.clients.index":{"uri":"oauth\/clients","methods":["GET","HEAD"],"domain":null},"passport.clients.store":{"uri":"oauth\/clients","methods":["POST"],"domain":null},"passport.clients.update":{"uri":"oauth\/clients\/{client_id}","methods":["PUT"],"domain":null},"passport.clients.destroy":{"uri":"oauth\/clients\/{client_id}","methods":["DELETE"],"domain":null},"passport.scopes.index":{"uri":"oauth\/scopes","methods":["GET","HEAD"],"domain":null},"passport.personal.tokens.index":{"uri":"oauth\/personal-access-tokens","methods":["GET","HEAD"],"domain":null},"passport.personal.tokens.store":{"uri":"oauth\/personal-access-tokens","methods":["POST"],"domain":null},"passport.personal.tokens.destroy":{"uri":"oauth\/personal-access-tokens\/{token_id}","methods":["DELETE"],"domain":null},"api.v1.subscription.plans":{"uri":"api\/subscription\/plans","methods":["GET","HEAD"],"domain":null},"api.v1.user.profile":{"uri":"api\/profile","methods":["GET","HEAD"],"domain":null},"api.v1.user.source_providers":{"uri":"api\/user\/source-providers","methods":["GET","HEAD"],"domain":null},"api.v1.subscription.cancel":{"uri":"api\/subscription\/cancel","methods":["DELETE"],"domain":null},"api.v1.subscription.subscribe":{"uri":"api\/subscription\/subscribe","methods":["POST"],"domain":null},"api.v1.servers":{"uri":"api\/servers","methods":["GET","HEAD"],"domain":null},"api.v1.server.events":{"uri":"api\/server\/{server}\/events","methods":["GET","HEAD"],"domain":null},"api.v1.server.show":{"uri":"api\/server\/{server}","methods":["GET","HEAD"],"domain":null},"api.v1.server.store":{"uri":"api\/server","methods":["POST"],"domain":null},"api.v1.server.delete":{"uri":"api\/server\/{server}","methods":["DELETE"],"domain":null},"api.v1.server.cron_job.index":{"uri":"api\/server\/{server}\/cron","methods":["GET","HEAD"],"domain":null},"api.v1.server.cron_job.store":{"uri":"api\/server\/{server}\/cron","methods":["POST"],"domain":null},"api.v1.server.cron_job.show":{"uri":"api\/server\/cron\/{job}","methods":["GET","HEAD"],"domain":null},"api.v1.server.cron_job.delete":{"uri":"api\/server\/cron\/{job}","methods":["DELETE"],"domain":null},"api.v1.server.database.index":{"uri":"api\/server\/{server}\/databases","methods":["GET","HEAD"],"domain":null},"api.v1.server.database.store":{"uri":"api\/server\/{server}\/database","methods":["POST"],"domain":null},"api.v1.server.database.show":{"uri":"api\/server\/database\/{database}","methods":["GET","HEAD"],"domain":null},"api.v1.server.database.delete":{"uri":"api\/server\/database\/{database}","methods":["DELETE"],"domain":null},"api.v1.server.firewall.index":{"uri":"api\/server\/{server}\/firewall\/rules","methods":["GET","HEAD"],"domain":null},"api.v1.server.firewall.store":{"uri":"api\/server\/{server}\/firewall","methods":["POST"],"domain":null},"api.v1.server.firewall.show":{"uri":"api\/server\/firewall\/{rule}","methods":["GET","HEAD"],"domain":null},"api.v1.server.firewall.delete":{"uri":"api\/server\/firewall\/{rule}","methods":["DELETE"],"domain":null},"api.v1.server.user.index":{"uri":"api\/server\/{server}\/users","methods":["GET","HEAD"],"domain":null},"api.v1.server.user.store":{"uri":"api\/server\/{server}\/user","methods":["POST"],"domain":null},"api.v1.server.user.show":{"uri":"api\/server\/user\/{user}","methods":["GET","HEAD"],"domain":null},"api.v1.server.user.delete":{"uri":"api\/server\/user\/{user}","methods":["DELETE"],"domain":null},"api.v1.server.task.index":{"uri":"api\/server\/{server}\/tasks","methods":["GET","HEAD"],"domain":null},"api.v1.server.task.show":{"uri":"api\/server\/task\/{task}","methods":["GET","HEAD"],"domain":null},"api.v1.server.task.delete":{"uri":"api\/server\/task\/{task}","methods":["DELETE"],"domain":null},"api.v1.server.supervisor.index":{"uri":"api\/server\/{server}\/supervisor\/list","methods":["GET","HEAD"],"domain":null},"api.v1.server.supervisor.store":{"uri":"api\/server\/{server}\/supervisor\/daemon","methods":["POST"],"domain":null},"api.v1.server.supervisor.show":{"uri":"api\/server\/supervisor\/{daemon}","methods":["GET","HEAD"],"domain":null},"api.v1.server.supervisor.delete":{"uri":"api\/server\/supervisor\/{daemon}","methods":["DELETE"],"domain":null},"api.v1.server.site.show":{"uri":"api\/server\/site\/{site}","methods":["GET","HEAD"],"domain":null},"api.v1.server.site.store":{"uri":"api\/server\/{server}\/site","methods":["POST"],"domain":null},"api.v1.server.site.delete":{"uri":"api\/server\/site\/{site}","methods":["DELETE"],"domain":null},"api.v1.server.site.deploy.config":{"uri":"api\/server\/site\/{site}\/deploy\/config","methods":["GET","HEAD"],"domain":null},"api.v1.server.site.deploy":{"uri":"api\/server\/site\/{site}\/deploy","methods":["POST"],"domain":null},"api.v1.server.site.environment.upload":{"uri":"api\/server\/site\/{site}\/environment\/upload","methods":["POST"],"domain":null},"api.v1.server.site.environment.update":{"uri":"api\/server\/site\/{site}\/environment","methods":["POST"],"domain":null},"api.v1.server.site.environment.delete":{"uri":"api\/server\/site\/{site}\/environment","methods":["DELETE"],"domain":null},"api.v1.server.site.repository.sync":{"uri":"api\/server\/site\/{site}\/repository\/sync-remote","methods":["POST"],"domain":null},"api.v1.server.site.repository.update":{"uri":"api\/server\/site\/{site}\/repository","methods":["POST"],"domain":null},"server.install_script":{"uri":"server\/{server}\/install","methods":["GET","HEAD"],"domain":null},"callback":{"uri":"callback","methods":["GET","HEAD","POST","PUT","PATCH","DELETE","OPTIONS"],"domain":null},"login":{"uri":"login","methods":["GET","HEAD"],"domain":null},"logout":{"uri":"logout","methods":["POST"],"domain":null},"register":{"uri":"register","methods":["GET","HEAD"],"domain":null},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"],"domain":null},"password.email":{"uri":"password\/email","methods":["POST"],"domain":null},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"],"domain":null},"password.update":{"uri":"password\/reset","methods":["POST"],"domain":null},"login.github":{"uri":"login\/github","methods":["GET","HEAD"],"domain":null},"login.github.callback":{"uri":"login\/github\/callback","methods":["GET","HEAD"],"domain":null},"login.bitbucket":{"uri":"login\/bitbucket","methods":["GET","HEAD"],"domain":null},"login.bitbucket.callback":{"uri":"login\/bitbucket\/callback","methods":["GET","HEAD"],"domain":null},"app":{"uri":"{vue?}","methods":["GET","HEAD","POST","PUT","PATCH","DELETE","OPTIONS"],"domain":null}},
        baseUrl: 'http://sputnik-dev.superprojects.space/',
        baseProtocol: 'http',
        baseDomain: 'sputnik-dev.superprojects.space',
        basePort: false,
        defaultParameters: []
    };

    if (typeof window.Ziggy !== 'undefined') {
        for (var name in window.Ziggy.namedRoutes) {
            Ziggy.namedRoutes[name] = window.Ziggy.namedRoutes[name];
        }
    }

    export {
        Ziggy
    }
