import { reactive } from 'vue';
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
    get(scope = 'all', url = null) {
        this.tasks = [];

        axios.get(url ? url : route('task.all'), {
            params: {
                allTasks: scope
            }
        })
        .then(res => {
            this.tasks = res.data.data;
            this.setPagination(res.data);
        })
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
});