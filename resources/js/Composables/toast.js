import { reactive } from 'vue';

export default reactive({
    items: [],
    add(toast) {
        setTimeout(() => {
            this.items.push({
                key: Symbol(),
                duration: 3000,
                ...toast
            });
        }, 500);
    },
    remove(index) {
        this.items.splice(index, 1);
    }
});