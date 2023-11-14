<template>
    <div>
        <h1>Eintrag</h1>
        <h2 class="hfh-label">Kategorie</h2>
        <p>
            {{ item.category.name }}
        </p>
        <h2 class="hfh-label">Signatur</h2>
        <p>
            {{ item.signature }}
        </p>
        <h2 class="hfh-label">Aufbewahrungsort</h2>
        <p>
            {{ item.location.name }}
        </p>
        <h2 class="hfh-label">Medienart</h2>
        <p>
            {{ item.mediaType.name }}
        </p>
        <h2 class="hfh-label">Fachliches Thema</h2>
        <p>
            {{ item.topic.name }}
        </p>
        <Link
            :href="`/admin/items/${item.id}/edit`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow mt-4"
            >Bearbeiten</Link
        >
        <HfhButton class="block mt-4" @click="deleteItem">Löschen</HfhButton>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { ItemResource } from "../../types";
import { HfhButton } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    itemResource: {
        type: Object as PropType<ItemResource>,
        required: true,
    },
});

const item = computed(() => props.itemResource.data);

const deleteItem = () => {
    if (confirm(`Willst du diesen Eintrag wirklich löschen?`)) {
        router.delete(`/admin/items/${item.value.id}`);
    }
};
</script>

<style lang="scss" scoped>
img {
    max-width: calc(min(100%, 60rem));
}
</style>
