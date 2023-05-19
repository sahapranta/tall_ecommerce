import "./bootstrap";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import money from "alpinejs-money";
import AlpineFloatingUI from "@awcodes/alpine-floating-ui";
import NotificationsAlpinePlugin from "../../vendor/filament/notifications/dist/module.esm";

window.Alpine = Alpine;

Alpine.plugin(AlpineFloatingUI);
Alpine.plugin(NotificationsAlpinePlugin);
Alpine.plugin(focus);
Alpine.plugin(money);

Alpine.store("toasts", {
    counter: 0,
    list: [],
    createToast(message, type = "info") {
        const index = this.list.length;
        let totalVisible =
            this.list.filter((toast) => {
                return toast.visible;
            }).length + 1;
        this.list.push({
            id: this.counter++,
            message,
            type,
            visible: true,
        });
        setTimeout(() => {
            this.destroyToast(index);
        }, 2000 * totalVisible);
    },
    destroyToast(index) {
        this.list[index].visible = false;
    },
});

Alpine.start();
