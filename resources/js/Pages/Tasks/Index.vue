<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TaskModal from '@/Components/TaskModal.vue';
import TaskCard from '@/Components/Tasks/Card.vue';
import Pagination from '@/Components/Pagination.vue';
import { PlusIcon, ChevronDownIcon } from '@heroicons/vue/24/outline';
import { Head } from '@inertiajs/vue3';
import { onMounted, reactive, watch } from 'vue';
import { initDropdowns } from 'flowbite'
import useTask from '@/Composables/useTask';

onMounted(() => {
    initDropdowns();
})

const state = reactive({
    toggleType: 'all',
    isOpened: false,
})

watch(
    () => state.toggleType,
    (newValue, oldValue) => {
        if (newValue != oldValue)
            setTimeout(() => useTask.get(state.toggleType), 250);
    }
)

const openCreateTaskModal = () => {
    state.isOpened = true;
};

const closeModal = (isSuccess) => {
    state.isOpened = false;
    if (isSuccess)
        useTask.get(state.toggleType);
};

const toggleTasks = (searchType) => {
    state.toggleType = searchType;
};

useTask.get(state.toggleType);
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
                                @click="openCreateTaskModal"
                            >
                                <PlusIcon class="w-3 h-3 mr-2" />
                                Create
                            </PrimaryButton>

                            <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button">
                                {{ state.toggleType == 'all' ? 'All Tasks' : 'My Tasks' }}
                                <ChevronDownIcon class="w-3 h-3 ml-2" />
                            </button>
                            
                            <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                    <li @click="toggleTasks('all')">
                                        <a href="#" :class="[ state.toggleType == 'all' ? 'bg-gray-500 text-white' : 'hover:bg-gray-100', 'block px-4 py-2']">All Task</a>
                                    </li>
                                    <li @click="toggleTasks('self')">
                                        <a href="#" :class="[ state.toggleType == 'self' ? 'bg-gray-500 text-white' : 'hover:bg-gray-100', 'block px-4 py-2']">My Tasks</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex justify-center md:justify-end md:p-0">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" id="table-search-users" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for tasks">
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="useTask.tasks.length > 0" class="space-y-6">
                        <TaskCard v-for="task in useTask.tasks" :key="task.id" :task="task" />
                        
                        <Pagination :pagination="useTask.pagination" @current="(url) => useTask.get(state.toggleType, url)"/>
                    </div>
                    <div v-else>
                        <!-- <Pagination :pagination="useTask.pagination" @current="(url) => useTask.get(state.toggleType, url)"/> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <TaskModal :show="state.isOpened" @close="(success) => closeModal(success)" />
</template>
