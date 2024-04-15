import useApp from "@/composables/useApp";

export default defineNuxtRouteMiddleware(async (to, from) => {
  if (to.path.startsWith('/admin')) {
    const app = useApp();
    
    try {
      const i = setInterval(() => {
        if (!app.ready) return;
        clearInterval(i);

        if (app.ready && app.data && !app.data.user) {
          return navigateTo(`/auth?redirect=${to.path}`);
        }
      }, 10);
    } catch(err) {}
  }
});
