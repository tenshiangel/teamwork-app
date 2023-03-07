<script setup>
import useTask from '@/Composables/useTask';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
const props = defineProps(['task']);
const emit = defineEmits(['update', 'afterDelete']);

const delForm = useForm({
    id: props.task.id
});

const updateTask = (form) => {
    form.patch(route('task.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // getTasks();
            // toggleModal();
        }
    });
};

const deleteTask = () => {
    useTask.delete(delForm);
};
</script>

<template>
    <div v-if="task" class="relative overflow-hidden bg-white rounded shadow">
        <!-- Task details -->
        <div class="p-4 pl-8 space-y-5">
            <div class="space-y-3">
                <span v-if="task.completion == 0" :class="[ task.status == 'removed' ? 'bg-red-200 text-red-600' : (task.status == 'ongoing' ? 'bg-blue-200 text-blue-600' : 'bg-gray-200 text-gray-600'), 'capitalize text-xs font-bold mr-2 px-2.5 py-0.5 rounded']">{{ task.status }}</span>
                <span v-else class="capitalize bg-green-200 text-green-500 text-xs font-bold mr-2 px-2.5 py-0.5 rounded">Completed</span>
                <h3 class="text-xl font-bold">{{ task.title }}</h3>
            </div>

            <div class="flex items-center">
                <div class="relative inline-flex items-center justify-center w-6 h-6 overflow-hidden bg-gray-400 rounded-full mr-2">
                    <span class="text-xs font-medium text-white">{{ task.owner.initials }}</span>
                </div>
                <span class="text-gray-500 text-sm">{{ task.owner.name }}</span>
            </div>

            <div class="space-y-2">
                <h5 class="font-medium">Description:</h5>
                <p class="text-gray-500 text-sm">{{ task.description }}</p>
            </div>
        </div>

        <!-- Task options -->
        <div v-if="task.owner.id == user.id" class="absolute p-4 space-x-4 z-2 text-gray-400 top-0 right-0">
            <PencilSquareIcon class="w-6 h-6 ml-2 inline-block cursor-pointer hover:text-gray-800" />
            <TrashIcon @click="deleteTask" class="w-6 h-6 ml-2 inline-block cursor-pointer hover:text-red-800" />
        </div>

        <!-- Task progress bar -->
        <div class="absolute w-full z-2 bottom-0 left-0 h-1 bg-gray-100">
            <div :class="[ task.completion == 1 ? 'w-full h-full bg-green-500' : (task.status == 'removed' ? 'w-1/2 h-full bg-red-500' : 'w-1/2 h-full bg-blue-500') ]"></div>
        </div>
    </div>

    <div v-else class="relative overflow-hidden bg-white rounded shadow">
        <div class="animate-pulse">
            <div class="p-4 pl-8 space-y-5">
                <div class="space-y-3">
                    <div class="bg-gray-300 w-16 text-xs px-2.5 py-0.5 rounded">&nbsp;</div>
                    <h3 class="bg-gray-300 rounded text-xl font-bold">&nbsp;</h3>
                </div>
                <div class="flex items-center">
                    <div class="relative inline-flex items-center justify-center w-6 h-6 overflow-hidden bg-gray-300 rounded-full mr-2">
                        <span class="text-xs font-medium">&nbsp;</span>
                    </div>
                    <span class="bg-gray-300 rounded text-sm w-20">&nbsp;</span>
                </div>
                <div class="space-y-2">
                    <h5 class="font-medium bg-gray-300 rounded">&nbsp;</h5>
                    <p class="bg-gray-300 rounded text-sm">&nbsp;</p>
                </div>
            </div>

            <div class="absolute p-4 space-x-4 z-2 top-0 right-0">
                <span v-for="index in 2" class="w-6 h-6 ml-2 inline-block rounded bg-gray-300"></span>
            </div>
        </div>
        <div class="absolute w-full z-2 bottom-0 left-0 h-1 bg-gray-300"></div>
    </div>
</template>
