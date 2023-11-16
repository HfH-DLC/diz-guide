<template>
    <div>
        <h1>Einträge</h1>
        <Link
            :href="`/admin/items/create`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow"
            >Neuer Eintrag</Link
        >
        <div class="hfh-content">
            <table v-if="items.length > 0" class="mt-4">
                <thead>
                    <tr>
                        <td>Kategorie</td>
                        <td>Signatur</td>
                        <td>Aufbewahrungsort</td>
                        <td>Fachliches Thema</td>
                        <td>Medienart</td>
                        <td><span class="hfh-sr-only">Aktionen</span></td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items">
                        <td>
                            {{ item.category ? item.category.name : "-" }}
                        </td>
                        <td>
                            {{ item.signature }}
                        </td>
                        <td>
                            {{ item.location.name }}
                        </td>
                        <td>
                            {{ item.topic }}
                        </td>
                        <td>
                            {{ item.mediaType.name }}
                        </td>
                        <td>
                            <Link
                                :href="`/admin/items/${item.id}`"
                                class="hover:text-thunderbird-red"
                                >Bearbeiten</Link
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { ItemsResource } from "@/types";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    itemsResource: {
        type: Object as PropType<ItemsResource>,
        required: true,
    },
});

const items = computed(() => props.itemsResource.data);
</script>

<style scoped></style>
