<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { PlusIcon, ChevronDownIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { initDropdowns, initTooltips } from 'flowbite'

onMounted(() => {
    initDropdowns();
    initTooltips();
})

const createModalOpened = ref(false);
const toggleAllTasks = ref(true);
const tasks = ref([]);

const form = useForm({
    title: '',
    description: '',
    due_date: '',
    processing: false,
});

const openCreateTaskModal = () => {
    createModalOpened.value = true;
};

const createTask = () => {
    form.post(route('task.store'), {
        preserveScroll: true,
        onSuccess: () => {
            getTasks();
            closeModal();
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    createModalOpened.value = false;
    form.reset();
};

const toggleTasks = () => {
    toggleAllTasks.value = !toggleAllTasks.value;
};

const getTasks = () => {
    axios.get(route('task.all'))
    .then(res => {
        console.log(res.data.data)
        tasks.value = res.data.data;
    })
};

getTasks();
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-hidden py-4 px-2 sm:rounded-lg">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 pb-4">
                        <div class="flex p-4 justify-center md:justify-start md:p-0 space-x-4">
                            <PrimaryButton
                                class="inline-flex items-center bg-blue-500 text-white border border-blue-500 focus:outline-none hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-3 py-1.5"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="openCreateTaskModal"
                            >
                                <PlusIcon class="w-3 h-3 mr-2" />
                                Create
                            </PrimaryButton>

                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button">
                                {{ !toggleAllTasks ? 'My Tasks' : 'All Tasks' }}
                                <ChevronDownIcon class="w-3 h-3 ml-2" />
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                    <li @click="toggleTasks">
                                        <a href="#" :class="[ toggleAllTasks ? 'bg-gray-500 text-white' : 'hover:bg-gray-100', 'block px-4 py-2']">All Task</a>
                                    </li>
                                    <li @click="toggleTasks">
                                        <a href="#" :class="[ !toggleAllTasks ? 'bg-gray-500 text-white' : 'hover:bg-gray-100', 'block px-4 py-2']">My Tasks</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex justify-center md:justify-end md:p-0">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for tasks">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6"> 
                        <div v-for="task in tasks" class="relative overflow-hidden bg-white rounded-md shadow-sm">
                            <div class="px-8 py-4">
                                <span v-if="task.completion == 0" :class="[ task.status == 'removed' ? 'bg-red-200 text-red-600' : (task.status == 'ongoing' ? 'bg-blue-200 text-blue-600' : 'bg-gray-200 text-gray-600'), 'capitalize text-xs font-bold mr-2 px-2.5 py-0.5 rounded']">{{ task.status }}</span>
                                <span v-else class="capitalize bg-green-200 text-green-500 text-xs font-bold mr-2 px-2.5 py-0.5 rounded">Completed</span>
                                <h3 class="mt-2 text-xl">{{ task.title }}</h3>
                                <p class="mt-3 text-gray-500 text-sm">{{ task.description }}</p>
                            </div>
                            <div class="absolute p-4 space-x-4 z-2 text-gray-400 top-0 right-0">
                                <PencilSquareIcon class="w-6 h-6 ml-2 inline-block hover:text-gray-800" />
                                <TrashIcon class="w-6 h-6 ml-2 inline-block hover:text-red-800" />
                            </div>
                            <div class="absolute w-full z-2 bottom-0 left-0 h-1">
                                <div :class="[ task.completion == 1 ? 'w-full h-full bg-green-500' : 'w-1/2 h-full bg-blue-500' ], 'h-full'"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="createModalOpened" @close="closeModal">
        <div class="p-6 space-y-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a Task
            </h2>

            <div class="space-y-2">
                <InputLabel for="title" value="Title" />

                <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="block w-full"
                    placeholder="Task Title"
                    autofocus
                />

                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="space-y-2">
                <InputLabel for="description" value="Description" />

                <TextArea
                    id="description"
                    v-model="form.description"
                    type="date"
                    class="block w-full"
                />

                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="space-y-2">
                <InputLabel for="due_date" value="Due date" />

                <TextInput
                    id="due_date"
                    v-model="form.due_date"
                    type="date"
                    class="block w-full"
                />

                <InputError :message="form.errors.due_date" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="createTask"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
