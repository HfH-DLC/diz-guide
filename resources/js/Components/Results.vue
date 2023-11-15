<template>
    <div v-if="results.length > 0">
        <h2 aria-live="polite" class="text-xl mb-4" ref="results">
            <strong class="font-bold">{{ results.length }}</strong>
            Resultate
        </h2>
        <div>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Kategorie</th>
                        <th>Signatur</th>
                        <th>Fachliches Thema</th>
                        <th>Medienart</th>
                        <th>Aufbewahrungsort</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="result in results">
                        <td>
                            <span aria-hidden="true" class="hfh-label"
                                >Kategorie</span
                            >{{ result.category.name }}
                        </td>
                        <td>
                            <span aria-hidden="true" class="hfh-label"
                                >Signatur</span
                            >{{ result.signature }}
                        </td>
                        <td>
                            <span aria-hidden="true" class="hfh-label"
                                >Fachliches Thema</span
                            >{{ result.topic }}
                        </td>
                        <td>
                            <span aria-hidden="true" class="hfh-label"
                                >Medienart</span
                            >{{ result.mediaType.name }}
                        </td>
                        <td>
                            <span aria-hidden="true" class="hfh-label"
                                >Aufbewahrungsort</span
                            >
                            <button
                                class="text-thunderbird-red hover:underline"
                                @click="openDialog(result)"
                            >
                                {{ result.location.name }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else class="flex-1 flex items-center justify-center text-xl">
        Für Ihre Suche wurden leider keine passenden Resultate gefunden.
    </div>
    <dialog ref="dialog" class="p-4">
        <div v-if="selectedLocation">
            <div class="flex items-start justify-between gap-x-8">
                <h2 class="text-2xl mb-4">{{ selectedLocation.label }}</h2>
                <button class="block ml-auto w-5" @click="dialog.close">
                    <XMarkIcon class="w-5" />
                </button>
            </div>
            <img
                class="max-w-[75vw]"
                :src="selectedLocation.imageSrc"
                :alt="selectedLocation.imageAlt"
            />
        </div>
    </dialog>
</template>

<script setup lang="ts">
import { PropType, Ref, ref } from "vue";
import type { LocationData, ItemData } from "../types";
import { XMarkIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    results: {
        type: Array as PropType<Array<ItemData>>,
    },
});

const dialog = ref();

const selectedLocation: Ref<LocationData | undefined> = ref();

const openDialog = (result: ItemData) => {
    selectedLocation.value = result.location;
    dialog.value.showModal();
};
</script>

<style scoped>
table {
    border-collapse: collapse;
}

th {
    text-align: left;
}

th,
td {
    border: 1px solid;
    padding: 1rem;
}

td .hfh-label {
    display: none;
}

@media only screen and (max-width: 600px) {
    table {
        display: block;
    }

    caption,
    tr,
    tbody {
        display: block;
    }

    thead {
        position: absolute;
        left: -10000px;
        top: auto;
        width: 1px;
        height: 1px;
        overflow: hidden;
    }

    tr {
        margin-bottom: 2rem;
    }

    td,
    th {
        border-bottom: 0;
        display: block;
        &:last-child {
            border-bottom: 1px solid;
        }
    }

    td .hfh-label {
        display: block;
    }
}
</style>
