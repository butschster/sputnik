const makeRoute = (name, params) => {
    if (!params) {
        return {name}
    }

    Object.keys(params).forEach(key => {
        if (params[key] instanceof Object) {
            params[key] = params[key].id
        }
    })

    return {name, params}
}

export function servers() {
    return makeRoute('servers', {id: server})
}

export function server(server) {
    return makeRoute('server.show', {id: server})
}

export function serverEvents(server) {
    return makeRoute('server.events', {id: server})
}

export function serverTasks(server) {
    return makeRoute('server.tasks', {id: server})
}

export function serverTask(task) {
    return makeRoute('server.task.show', {id: task.server_id, task_id: task})
}

export function serverUsers(server) {
    return makeRoute('server.users', {id: server})
}

export function serverFirewall(server) {
    return makeRoute('server.firewall', {id: server})
}

export function serverDatabases(server) {
    return makeRoute('server.database', {id: server})
}

export function serverScheduler(server) {
    return makeRoute('server.scheduler', {id: server})
}

export function serverSupervisor(server) {
    return makeRoute('server.supervisor', {id: server})
}

export function serverSettings(server) {
    return makeRoute('server.settings', {id: server})
}

export function serverSites(server) {
    return makeRoute('server.show', {id: server})
}

export function serverSite(site) {
    return makeRoute('server.site.show', {id: site.server_id, site_id: site})
}

export function serverSiteSettings(site) {
    return makeRoute('server.site.settings', {id: site.server_id, site_id: site})
}

export function serverSiteEnvironment(site) {
    return makeRoute('server.site.environment', {id: site.server_id, site_id: site})
}

export function serverSiteDeployment(site) {
    return makeRoute('server.site.deployment', {id: site.server_id, site_id: site})
}

export function notifications() {
    return makeRoute('notifications')
}

export function profile() {
    return makeRoute('profile')
}

export function profileTeams() {
    return makeRoute('profile.teams')
}

export function profileTeam(team) {
    return makeRoute('profile.team.show', {id: team})
}

export function profileTeamBilling(team) {
    return makeRoute('profile.team.billing', {id: team})
}

export function profileTeamSubscription(team) {
    return makeRoute('profile.team.subscription', {id: team})
}


export {
    makeRoute
}