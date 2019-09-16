import Vue from "vue"
import VueI18Next from "@panter/vue-i18next"
import i18next from "i18next"

Vue.use(VueI18Next)

i18next.init({
    lng: window.user.lang,
    resources: {
        en: {
            translation: require('../../../lang/en.json')
        },
        ru: {
            translation: require('../../../lang/ru.json')
        },
    }
})

export default new VueI18Next(i18next)
