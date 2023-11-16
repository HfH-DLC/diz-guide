<template>
    <div>
        <h1>Eintrag</h1>
        <dl class="mb-4 grid gap-y-1">
            <div>
                <dt class="hfh-label mb-0">Signatur</dt>
                <dd>{{ item.signature }}</dd>
            </div>
            <div>
                <dt class="hfh-label mb-0">Kategorie</dt>
                <dd>{{ item.category ? item.category.name : "-" }}</dd>
            </div>

            <div>
                <dt class="hfh-label mb-0">Aufbewahrungsort</dt>
                <dd>{{ item.location.name }}</dd>
            </div>
            <div>
                <dt class="hfh-label mb-0">Medienart</dt>
                <dd>{{ item.mediaType.name }}</dd>
            </div>
            <div>
                <dt class="hfh-label mb-0">Fachliches Thema</dt>
                <dd>{{ item.topic }}</dd>
            </div>
        </dl>
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
