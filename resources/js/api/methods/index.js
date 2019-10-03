import * as userProfile from "./profile"
import * as notifications from "./notifications"
import * as team from "./team"
import * as sites from "./sites"
import * as subscription from './subscription'
import * as teamBilling from "./team/billing"
import * as userProfileTeam from "./profile/teams"
import * as server from "./server"
import * as serverModules from "./server/modules"
import * as serverEvents from "./server/events"
import * as serverTasks from "./server/tasks"
import * as serverUsers from "./server/users"
import * as serverFirewall from "./server/firewall"
import * as sourceProviders from "./sourceProviders"
import * as serverSites from "./server/sites"
import * as serverSiteDeployment from "./server/site/deployment"
import * as serverSiteEnvironment from "./server/site/environment"
import * as serverSiteRepository from "./server/site/repository"

export default {
    notifications,
    subscription,
    sourceProviders,
    team,
    teamBilling,
    userProfile,
    userProfileTeam,
    server,
    sites,
    serverModules,
    serverSites,
    serverSiteDeployment,
    serverSiteEnvironment,
    serverSiteRepository,
    serverEvents,
    serverTasks,
    serverUsers,
    serverFirewall,
}
