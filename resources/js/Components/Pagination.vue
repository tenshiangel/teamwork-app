<script setup>
import { computed } from 'vue'

const props = defineProps(['pagination']);
const emit = defineEmits(['current', 'prev', 'next']);

const range = computed(() => {
    let rangeList = [];
    for (let page = 0; page < props.pagination.lastPage; page++) {
        rangeList.push(page + 1);
    }
    return rangeList;
});

const formatUrl = (url, page) => {
    var currPage = url.substring(url.lastIndexOf('='), url.length);
    return url.replace(currPage, '=' + page);
}
</script>

<template>
    <div v-if="pagination.total" class="flex w-full justify-center py-4 md:py-8">
        <nav aria-label="Page navigation example">
            <ul class="inline-flex items-center space-x-4">
                <li>
                    <a v-if="pagination.prev" @click="$emit('current', pagination.prev)"
                        class="block px-5 py-3 text-md ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-blue-200 hover:text-blue-600 duration-500">
                        <span class="font-bold">Prev</span>
                    </a>
                    <span v-else class="block px-5 py-3 cursor-not-allowed font-bold text-md ml-0 leading-tight bg-gray-200 text-gray-500 border border-gray-300 rounded-lg">Prev</span>
                </li>

                <!-- Range of pagination starts -->
                <li v-for="page in range" :key="page">
                    <a @click="$emit('current', formatUrl(pagination.last, page))"
                        :class="[ pagination.currentPage == page ? 'bg-indigo-500 text-white' : 'text-gray-500 hover:bg-blue-200 hover:text-blue-600']"
                        class="px-5 py-4 text-md leading-tight rounded-full duration-500">
                        {{ page }}
                    </a>
                </li>
                <!-- Range of pagination ends -->

                <li>
                    <a v-if="pagination.next" @click="$emit('current', pagination.next)"
                        class="block px-5 py-3 text-md ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-blue-100 hover:text-blue-600 hover:border-blue-600 duration-500">
                        <span class="font-bold">Next</span>
                    </a>
                    <span v-else class="block px-5 py-3 cursor-not-allowed font-bold text-md ml-0 leading-tight bg-gray-200 text-gray-500 border border-gray-300 rounded-lg">Next</span>
                </li>
            </ul>
        </nav>
    </div>
</template>