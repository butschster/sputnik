    var Ziggy = {
        namedRoutes: {"api.v1.subscription.plans":{"uri":"api\/v1\/subscription\/plans","methods":["GET","HEAD"],"domain":null},"api.v1.source_providers":{"uri":"api\/v1\/source-providers","methods":["GET","HEAD"],"domain":null},"api.v1.user.profile":{"uri":"api\/v1\/profile","methods":["GET","HEAD"],"domain":null},"api.v1.user.profile.update":{"uri":"api\/v1\/profile","methods":["PUT"],"domain":null},"api.v1.profile.source_providers":{"uri":"api\/v1\/profile\/source-providers","methods":["GET","HEAD"],"domain":null},"api.v1.profile.delete":{"uri":"api\/v1\/profile","methods":["DELETE"],"domain":null},"api.v1.profile.teams":{"uri":"api\/v1\/profile\/teams","methods":["GET","HEAD"],"domain":null},"api.v1.team.show":{"uri":"api\/v1\/team\/{team}","methods":["GET","HEAD"],"domain":null},"api.v1.team.members":{"uri":"api\/v1\/team\/{team}\/members","methods":["GET","HEAD"],"domain":null},"api.v1.team.payment.methods":{"uri":"api\/v1\/team\/{team}\/payment\/methods","methods":["GET","HEAD"],"domain":null},"api.v1.team.payment.method.intent":{"uri":"api\/v1\/team\/{team}\/payment\/intention","methods":["POST"],"domain":null},"api.v1.team.payment.method.store":{"uri":"api\/v1\/team\/{team}\/payment\/method","methods":["POST"],"domain":null},"api.v1.team.payment.method.delete":{"uri":"api\/v1\/team\/{team}\/payment\/method\/{id}","methods":["DELETE"],"domain":null},"api.v1.team.subscription.cancel":{"uri":"api\/v1\/team\/{team}\/cancel-subscription","methods":["DELETE"],"domain":null},"api.v1.team.subscription.resume":{"uri":"api\/v1\/team\/{team}\/resume-subscription","methods":["POST"],"domain":null},"api.v1.team.subscribe":{"uri":"api\/v1\/team\/{team}\/subscribe\/{plan}","methods":["POST"],"domain":null},"api.v1.servers":{"uri":"api\/v1\/servers","methods":["GET","HEAD"],"domain":null},"api.v1.server.show":{"uri":"api\/v1\/server\/{server}","methods":["GET","HEAD"],"domain":null},"api.v1.server.update":{"uri":"api\/v1\/server\/{server}","methods":["PUT"],"domain":null},"api.v1.server.store":{"uri":"api\/v1\/server","methods":["POST"],"domain":null},"api.v1.server.delete":{"uri":"api\/v1\/server\/{server}","methods":["DELETE"],"domain":null},"api.v1.server.events":{"uri":"api\/v1\/server\/{server}\/events","methods":["GET","HEAD"],"domain":null},"api.v1.server.event.last":{"uri":"api\/v1\/server\/{server}\/last-event","methods":["GET","HEAD"],"domain":null},"api.v1.server.cron_job.index":{"uri":"api\/v1\/server\/{server}\/cron","methods":["GET","HEAD"],"domain":null},"api.v1.server.cron_job.store":{"uri":"api\/v1\/server\/{server}\/cron","methods":["POST"],"domain":null},"api.v1.server.cron_job.show":{"uri":"api\/v1\/server\/cron\/{job}","methods":["GET","HEAD"],"domain":null},"api.v1.server.cron_job.delete":{"uri":"api\/v1\/server\/cron\/{job}","methods":["DELETE"],"domain":null},"api.v1.server.database.index":{"uri":"api\/v1\/server\/{server}\/databases","methods":["GET","HEAD"],"domain":null},"api.v1.server.database.store":{"uri":"api\/v1\/server\/{server}\/database","methods":["POST"],"domain":null},"api.v1.server.database.show":{"uri":"api\/v1\/server\/database\/{database}","methods":["GET","HEAD"],"domain":null},"api.v1.server.database.delete":{"uri":"api\/v1\/server\/database\/{database}","methods":["DELETE"],"domain":null},"api.v1.server.firewall.rules":{"uri":"api\/v1\/server\/{server}\/firewall\/rules","methods":["GET","HEAD"],"domain":null},"api.v1.server.firewall.store":{"uri":"api\/v1\/server\/{server}\/firewall","methods":["POST"],"domain":null},"api.v1.server.firewall.show":{"uri":"api\/v1\/server\/firewall\/{rule}","methods":["GET","HEAD"],"domain":null},"api.v1.server.firewall.delete":{"uri":"api\/v1\/server\/firewall\/{rule}","methods":["DELETE"],"domain":null},"api.v1.server.users":{"uri":"api\/v1\/server\/{server}\/users","methods":["GET","HEAD"],"domain":null},"api.v1.server.user.store":{"uri":"api\/v1\/server\/{server}\/user","methods":["POST"],"domain":null},"api.v1.server.user.show":{"uri":"api\/v1\/server\/user\/{user}","methods":["GET","HEAD"],"domain":null},"api.v1.server.user.delete":{"uri":"api\/v1\/server\/user\/{user}","methods":["DELETE"],"domain":null},"api.v1.server.tasks":{"uri":"api\/v1\/server\/{server}\/tasks","methods":["GET","HEAD"],"domain":null},"api.v1.server.task.show":{"uri":"api\/v1\/server\/task\/{task}","methods":["GET","HEAD"],"domain":null},"api.v1.server.task.delete":{"uri":"api\/v1\/server\/task\/{task}","methods":["DELETE"],"domain":null},"api.v1.server.supervisor.index":{"uri":"api\/v1\/server\/{server}\/supervisor\/list","methods":["GET","HEAD"],"domain":null},"api.v1.server.supervisor.store":{"uri":"api\/v1\/server\/{server}\/supervisor\/daemon","methods":["POST"],"domain":null},"api.v1.server.supervisor.show":{"uri":"api\/v1\/server\/supervisor\/{daemon}","methods":["GET","HEAD"],"domain":null},"api.v1.server.supervisor.delete":{"uri":"api\/v1\/server\/supervisor\/{daemon}","methods":["DELETE"],"domain":null},"api.v1.server.sites":{"uri":"api\/v1\/server\/{server}\/sites","methods":["GET","HEAD"],"domain":null},"api.v1.server.site.show":{"uri":"api\/v1\/server\/site\/{site}","methods":["GET","HEAD"],"domain":null},"api.v1.server.site.store":{"uri":"api\/v1\/server\/{server}\/site","methods":["POST"],"domain":null},"api.v1.server.site.delete":{"uri":"api\/v1\/server\/site\/{site}","methods":["DELETE"],"domain":null},"api.v1.server.site.deploy.config":{"uri":"api\/v1\/server\/site\/{site}\/deploy\/config","methods":["GET","HEAD"],"domain":null},"api.v1.server.site.deploy":{"uri":"api\/v1\/server\/site\/{site}\/deploy","methods":["POST"],"domain":null},"api.v1.server.site.environment.upload":{"uri":"api\/v1\/server\/site\/{site}\/environment\/upload","methods":["POST"],"domain":null},"api.v1.server.site.environment.update":{"uri":"api\/v1\/server\/site\/{site}\/environment","methods":["POST"],"domain":null},"api.v1.server.site.environment.delete":{"uri":"api\/v1\/server\/site\/{site}\/environment","methods":["DELETE"],"domain":null},"api.v1.server.site.repository.sync":{"uri":"api\/v1\/server\/site\/{site}\/repository\/sync-remote","methods":["POST"],"domain":null},"api.v1.server.site.repository.update":{"uri":"api\/v1\/server\/site\/{site}\/repository","methods":["POST"],"domain":null}},
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
