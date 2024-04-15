import axios from "axios";
// import { useStorage } from "@vueuse/core";

export default defineNuxtPlugin(async (nuxtApp) => {
  // const router = useRouter();

  axios.interceptors.request.use((config) => {
    const conf = useRuntimeConfig();

    // if (config.method == "put") {
    //   config.method = "post";
    //   config.data._method = "put";
    // }

    if (config.url.startsWith("api://")) {
      let api_baseurl = [`${location.protocol}//`, location.hostname];

      if (conf.public.SERVICE_BACKEND_PORT || location.port) {
        api_baseurl.push(
          `:${conf.public.SERVICE_BACKEND_PORT || location.port}`
        );
      }

      api_baseurl.push("/api/");
      api_baseurl = api_baseurl.join("");
      config.url = config.url.replace("api://", api_baseurl);

      const access_token = localStorage.getItem('app_token');
      if (access_token) {
        config.headers["Authorization"] = `Bearer ${access_token}`;
      }
    }

    return config;
  });

  axios.interceptors.response.use(
    (resp) => {
      return resp;
    },
    (error) => {
      if (error.response && error.response.status==401) {
        console.log(location.path);
        // localStorage.setItem('app_redirect', location.href);
        // location.href = `/auth`;
      }
      return Promise.reject(error);
    }
  );

  // nuxtApp.provide('axios', axios);
});
