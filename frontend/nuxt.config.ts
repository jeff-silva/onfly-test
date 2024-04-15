// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  devtools: { enabled: false },

  runtimeConfig: {
    public: {
      SERVICE_BACKEND_PORT: process.env.SERVICE_BACKEND_PORT,
    },
  },

  modules: [
    ["nuxt-quasar-ui", {}],
  ],
});