import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import toast from '@/Composables/toast';

export default reactive({
    tasks: [],
    pagination: {
        first: null,
        last: null,
        next: null,
        prev: null,
        base: null,
        currentPage: 0,
        lastPage: 0,
        total: 0,
    },
    errors: {
        description: null,
        due_date: null,
        status: null,
        title: null,
    },
    openedTask: {
        completion: 0,
        description: null,
        due_date: null,
        id: 0,
        owner: null,
        status: null,
        title: null,
    },
    get(scope = 'all', url = null) {
        this.tasks = [];

        axios.get(url ? url : route('task.all'), {
            params: {
                allTasks: scope
            }
        })
        .then(res => {
            this.tasks = res.data.data;
        })
    },
    single(id) {
        axios.get(route('task.get.one', id))
        .then(res => {
            this.openedTask = res.data.data;
        })
    },
    update() {
        const form = useForm(this.openedTask);
        form.patch(route('task.update', form.id), {
            preserveScroll: true,
            onSuccess: (response) => {
                let responseToast = response.props.toast;
                toast.add(responseToast);
                setTimeout(() => this.get(), 500);
            },
            onError: (errors) => {
                this.errors = errors;
            },
        });
    },
    delete(form) {
        form.delete(route('task.destroy', form.id), {
            preserveScroll: true,
            onSuccess: (response) => {
                let responseToast = response.props.toast;
                toast.add(responseToast);
                setTimeout(() => this.get(), 500);
            }
        });
    },
    reset() {
        this.errors = {
            description: null,
            due_date: null,
            status: null,
            title: null,
        };
    },
    setPagination(data) {
        this.pagination = {
            first: data.links.first,
            last: data.links.last,
            next: data.links.next,
            prev: data.links.prev,
            base: data.meta.path,
            currentPage: data.meta.current_page,
            lastPage: data.meta.last_page,
            total: data.meta.total,
        }
    },
});