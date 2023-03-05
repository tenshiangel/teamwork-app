<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { PlusIcon, ChevronDownIcon } from '@heroicons/vue/24/solid';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, nextTick, ref } from 'vue';
import { initDropdowns, initTooltips } from 'flowbite'

onMounted(() => {
    initDropdowns();
    initTooltips();
})

const createModalOpened = ref(false);
const passwordInput = ref(null);

const form = useForm({
    title: '',
    description: '',
    due_date: '',
});

const openCreateTaskModal = () => {
    createModalOpened.value = true;

    nextTick(() => passwordInput.value.focus());
};

const createTask = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    createModalOpened.value = false;

    form.reset();
};

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
                    <div class="flex items-center justify-between pb-4 dark:bg-gray-900">
                        <div class="space-x-4">
                            <PrimaryButton
                                class="inline-flex items-center bg-blue-500 text-white border border-blue-500 focus:outline-none hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 font-medium rounded-lg text-sm px-3 py-1.5"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="openCreateTaskModal"
                            >
                                <PlusIcon class="w-3 h-3 mr-2" />
                                Create new task
                            </PrimaryButton>

                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button">
                                Action
                                <ChevronDownIcon class="w-3 h-3 ml-2" />
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All Task</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Your Tasks</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for tasks">
                        </div>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Task
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Due Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">NS</span>
                                    </div>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">Neil Sims</div>
                                        <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                                    </div>  
                                </th>
                                <td class="px-6 py-4">
                                    React Developer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Completed
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">BG</span>
                                    </div>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">Bonnie Green</div>
                                        <div class="font-normal text-gray-500">bonnie@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    Designer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Completed
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">JL</span>
                                    </div>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">Jese Leos</div>
                                        <div class="font-normal text-gray-500">jese@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    Vue JS Developer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Completed
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">TL</span>
                                    </div>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">Thomas Lean</div>
                                        <div class="font-normal text-gray-500">thomes@flowbite.com</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    UI/UX Engineer
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Incomplete
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                <InputLabel for="title" value="Task name" />

                <TextInput
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="block w-full"
                    placeholder="Task Title"
                />

                <InputError :message="form.errors.title" class="mt-2" />
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

            <div class="space-y-2">
                <InputLabel for="description" value="Due date" />

                <TextArea
                    id="description"
                    v-model="form.description"
                    type="date"
                    class="block w-full"
                />

                <InputError :message="form.errors.description" class="mt-2" />
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
