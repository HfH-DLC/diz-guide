import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import AdminLayout from "./Layouts/AdminLayout.vue";
import DefaultLayout from "./Layouts/DefaultLayout.vue";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        if (name.startsWith("Admin/")) {
            page.default.layout = page.default.layout || AdminLayout;
        } else {
            page.default.layout = page.default.layout || DefaultLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
