<template>
    <Head>
        <title>{{ currentLink.title }}</title>
        <meta name="description" :content="currentLink.description">
    </Head>
    <ul :class="['menu', isHorizontal ? 'menu-horizontal' : '', 'px-1']">
        <li v-for="link in navlinks" :key="link.link">
            <Link :href="link.link">{{ link.name }}</Link>
        </li>
    </ul>
</template>

<script>
import {links} from "@/data/link";
import {onMounted, ref, computed} from 'vue';
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3'

export default {
    name: 'LinkList',
    components: {
        Link,
        Head
    },

    setup() {
        const isHorizontal = ref(false);

        function handleChange(e) {
            isHorizontal.value = !e.matches;
        }

        onMounted(() => {
            const mediaQuery = window.matchMedia('(max-width: 1024px)');
            isHorizontal.value = !mediaQuery.matches;
            mediaQuery.addEventListener('change', handleChange);

            return () => mediaQuery.removeEventListener('change', handleChange);
        });

        const currentLink = computed(() => {
            const currentPath = window.location.pathname;
            return links.find(link => link.link === currentPath) || links[0];
        });

        return {
            navlinks: links,
            isHorizontal,
            currentLink
        };
    },
};
</script>
