import * as userProfile from "./profile"
import * as team from "./team"
import * as teamBilling from "./team/billing"
import * as userProfileTeam from "./profile/teams"
import * as server from "./server"
import * as serverEvents from "./server/events"
import * as serverTasks from "./server/tasks"
import * as serverUsers from "./server/users"
import * as serverFirewall from "./server/firewall"
import * as sourceProviders from "./sourceProviders"

export default {
    sourceProviders,
    team,
    teamBilling,
    userProfile,
    userProfileTeam,
    server,
    serverEvents,
    serverTasks,
    serverUsers,
    serverFirewall
}