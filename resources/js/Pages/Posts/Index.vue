<template>
    <AppLayout :title="'post'">
        <Container>
            <div>
                <Link v-if="selectedTopic" :href="route('posts.index')" class="text-indigo-500 hover:text-indigo-700 block mb-2">Back to all Posts</Link>
                <PageHeading
                    v-text="selectedTopic ? selectedTopic.name : 'All Posts'"
                />
                <p v-if="selectedTopic" class="mt-1 text-sm text-gray-600">
                    {{ selectedTopic.description }}
                </p>


                <menu class="flex space-x-1 mt-3 overflow-x-auto pb-2 pt-1">
                    <li><Pill :href="route('posts.index')" :filled="! selectedTopic">All Posts</Pill></li>
                    <li v-for="topic in topics" :key="topic.id">
                        <Pill :href="route('posts.index', { topic: topic.slug })"
                              :filled="topic.id === selectedTopic?.id"
                        >
                            {{ topic.name }}
                        </Pill>
                    </li>
                </menu>


            </div>
            <ul class="divide-y">
                <li v-for="post in posts.data" :key="post.id" class="flex flex-col items-baseline justify-between md:flex-row">
                    <Link :href="post.routes.show" class="block group px-2 py-4">
                        <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="first-letter:uppercase block pt-1 text-sm text-gray-600">{{ formattedDate(post) }} ago by {{ post.user.name }}</span>
                    </Link>
                    <Link
                        :href="route('posts.index', {topic: post.topic.slug})"
                        class="mb-2 rounded-full border border-pink-500 px-2 py-0.5 text-pink-500 hover:bg-indigo-500 hover:text-indigo-50"
                    >
                        {{ post.topic.name }}
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" class="mt-2"/>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {Link} from "@inertiajs/vue3";
import {formatDistance, parseISO} from "date-fns";
import PageHeading from "@/Components/PageHeading.vue";
import Pill from "@/Components/Pill.vue";

defineProps(['posts', 'topics', 'selectedTopic']);

const formattedDate = (post) => {
    return formatDistance(parseISO(post.created_at), new Date());
};
</script>
