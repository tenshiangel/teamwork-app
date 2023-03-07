<script setup>
import ToastItem from '@/Components/Toast/Toast.vue';
import { onUnmounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import toast from '@/Composables/toast';

const page = usePage();

const remove = (index) => {
    toast.remove(index);
};

let toastEventListener = router.on('finish', (event) => {
    if (page.props.toast) {
        toast.add(page.props.toast);
    }
})

onUnmounted(() => toastEventListener());
</script>

<template>
    <TransitionGroup
        tag="div"
        class="fixed bottom-4 right-4 z-50 space-y-4"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0">
        <ToastItem v-for="(item, index) in toast.items" :key="item.key" :toast-type="item.type" :message="item.message" @remove="() => remove(index)" :duration="3000" />
    </TransitionGroup>
</template>
