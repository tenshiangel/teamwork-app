<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['modalTitle']);
const emit = defineEmits(['submit', 'close']);

const form = useForm({
    title: '',
    description: '',
    due_date: '',
});

const createTask = () => {
    form.post(route('task.store'), {
        preserveScroll: true,
        onSuccess: (response) => {
            let responseToast = response.props.toast;
            toast.add(responseToast);
            emit('close', true);
        }
    });
};
</script>

<template lang="">
    <Modal>
        <div class="p-6 space-y-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ props.modalTitle }}
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
                <SecondaryButton @click="$emit('close', false)"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="createTask"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
