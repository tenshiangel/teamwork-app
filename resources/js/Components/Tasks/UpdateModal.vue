<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import useTask from '@/Composables/useTask';
import { watch } from 'vue';

const props = defineProps(['task', 'show']);
const emit = defineEmits(['submit', 'close']);

watch(
    () => props.show,
    () => {
        if (props.show)
            useTask.single(props.task.id);
    }
)

const updateTask = () => {
    useTask.update();
};

const close = () => {
    useTask.reset();
    emit('close', false);
}
</script>

<template>
    <Modal :show="show">
        <div class="p-6 space-y-6">
            <h2 class="text-lg font-medium text-gray-900">
                Update Task
            </h2>

            <div class="space-y-2">
                <InputLabel for="title" value="Title" />

                <TextInput
                    id="title"
                    v-model="useTask.openedTask.title"
                    type="text"
                    class="block w-full"
                    placeholder="Task Title"
                    autofocus
                />

                <InputError :message="useTask.errors.title" class="mt-2" />
            </div>

            <div class="space-y-2">
                <InputLabel for="description" value="Description" />

                <TextArea
                    id="description"
                    v-model="useTask.openedTask.description"
                    type="date"
                    class="block w-full"
                />

                <InputError :message="useTask.errors.description" class="mt-2" />
            </div>

            <div class="space-y-2">
                <InputLabel for="due_date" value="Due date" />

                <TextInput
                    id="due_date"
                    v-model="useTask.openedTask.due_date"
                    type="date"
                    class="block w-full"
                />

                <InputError :message="useTask.errors.due_date" class="mt-2" />
            </div>

            <div class="space-y-2">
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Status</h3>
                
                <ul class="grid w-full gap-6 md:grid-cols-3">
                    <li>
                        <input v-model="useTask.openedTask.status" type="radio" id="option-to-do" name="status" value="to-do" class="hidden peer" required>
                        <label for="option-to-do" class="inline-flex items-center justify-between text-center w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-gray-600 peer-checked:bg-gray-200 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100 duration-500">                           
                            <div class="w-full text-md font-semibold">To-Do</div>
                        </label>
                    </li>
                    <li>
                        <input v-model="useTask.openedTask.status" type="radio" id="option-ongoing" name="status" value="ongoing" class="hidden peer">
                        <label for="option-ongoing" class="inline-flex items-center justify-between text-center w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:bg-blue-200 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 duration-500">
                            <div class="w-full text-md font-semibold">Ongoing</div>    
                        </label>
                    </li>
                    <li>
                        <input v-model="useTask.openedTask.status" type="radio" id="option-closed" name="status" value="closed" class="hidden peer">
                        <label for="option-closed" class="inline-flex items-center justify-between text-center w-full p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-600 peer-checked:bg-green-200 peer-checked:text-green-600 hover:text-gray-600 hover:bg-gray-100 duration-500">
                            <div class="w-full text-md font-semibold">Closed</div>
                        </label>
                    </li>
                </ul>

                <InputError :message="useTask.errors.status" class="mt-2" />

                <div v-if="useTask.openedTask.status == 'closed'" class="flex py-4">
                    <div class="flex items-center h-5">
                        <input v-model="useTask.openedTask.completion" id="completion-checkbox" aria-describedby="completion-checkbox-text" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    </div>
                    <div class="ml-4 text-sm">
                        <label for="completion-checkbox" class="font-medium text-gray-900">Mark as completed</label>
                        <p id="completion-checkbox-text" class="text-xs font-normal text-gray-500">Did you finish the task before the due date?</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="close"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="updateTask"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
