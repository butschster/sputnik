import * as userProfile from "./profile"
import * as team from "./team"
import * as subscription from './subscription'
import * as teamBilling from "./team/billing"
import * as userProfileTeam from "./profile/teams"
import * as server from "./server"
import * as serverCron from "./server/cron"
import * as serverEvents from "./server/events"
import * as serverTasks from "./server/tasks"
import * as serverUsers from "./server/users"
import * as serverFirewall from "./server/firewall"
import * as serverDatabases from "./server/database"
import * as serverSupervisor from "./server/supervisor"
import * as sourceProviders from "./sourceProviders"
import * as serverSites from "./server/sites"
import * as serverSiteDeployment from "./server/site/deployment"
import * as serverSiteEnvironment from "./server/site/environment"
import * as serverSiteRepository from "./server/site/repository"

export default {
    subscription,
    sourceProviders,
    team,
    teamBilling,
    userProfile,
    userProfileTeam,
    server,
    serverSites,
    serverSiteDeployment,
    serverSiteEnvironment,
    serverSiteRepository,
    serverEvents,
    serverTasks,
    serverUsers,
    serverFirewall,
    serverCron,
    serverDatabases,
    serverSupervisor,
}