import VueI18n from 'vue-i18n'

const i18n = new VueI18n({
    locale: 'en',
    messages: {
        en: require('../../lang/en.json'),
    }
})

export default i18n
