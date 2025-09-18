import { createI18n } from 'vue-i18n';
import nl from './locales/nl';
import en from './locales/en';

const i18n = createI18n({
    legacy: false,
    locale: 'nl',
    fallbackLocale: 'en',
    messages: {
        nl,
        en
    },

    missing: (locale, key) => {
        console.warn(`Missing translation: ${key} for locale: ${locale}`);
        return key;
    }
});

export default i18n;
