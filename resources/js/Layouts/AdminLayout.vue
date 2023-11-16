<template>
    <header>
        <div
            class="min-h-[4rem] border-b border-gray-300 flex justify-between pl-4"
        >
            <div class="flex items-center">
                <Link href="/"><HfhLogo class="w-auto h-8"></HfhLogo></Link>
            </div>
            <nav class="flex gap-x-10">
                <Link
                    v-for="item in navItems"
                    :class="
                        page.url === item.href ? itemActiveClasses : itemClasses
                    "
                    :href="item.href"
                >
                    {{ item.label }}</Link
                >
            </nav>
            <LogoutButton class="mr-4"></LogoutButton>
        </div>
        <div class="p-4" v-if="breadcrumbs">
            <HfhBreadcrumbs :breadcrumbs="breadcrumbs"></HfhBreadcrumbs>
        </div>
    </header>
    <main class="p-4">
        <slot></slot>
    </main>
</template>

<script setup lang="ts">
import { PropType } from "vue";
import { HfhBreadcrumbs, HfhLogo } from "@hfh-dlc/hfh-styleguide";
import type { Breadcrumb } from "@hfh-dlc/hfh-styleguide/types/types";
import { Link, usePage } from "@inertiajs/vue3";
import LogoutButton from "@/Components/LogoutButton.vue";

defineProps({
    breadcrumbs: {
        type: Array as PropType<Array<Breadcrumb>>,
    },
});

const page = usePage();

const itemClasses =
    "text-base text-gray-700 border-b-2 border-transparent hover:border-gray-300 inline-flex items-center px-2";
const itemActiveClasses =
    "text-base text-gray-900 border-b-2 border-thunderbird-red inline-flex items-center px-2";

const navItems = [
    {
        label: "Einträge",
        href: "/admin/items",
    },
    {
        label: "Kategorien",
        href: "/admin/categories",
    },
    {
        label: "Aufbewahrungsorte",
        href: "/admin/locations",
    },
    {
        label: "Medienarten",
        href: "/admin/media-types",
    },
];
</script>

<style lang="scss" scoped></style>
