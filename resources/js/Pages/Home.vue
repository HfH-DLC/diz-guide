<template>
    <div class="hfh-content">
        <h1>Wilkommen im DiZ</h1>
        <img
            src="/images/DiZ_Welcome.jpg"
            alt=""
            class="w-full h-auto max-w-full block mb-16"
        />
        <p>
            Entdecken Sie die vielfältige Sammlung an Materialien des
            Didaktischen Zentrums DiZ für Diagnose, Therapie, Beratung und
            Prävention. Dieser Guide hilft Ihnen, sich in unseren Regalen,
            Schränken und Schubladen zurechtzufinden. Eine Suche nach einzelnen
            Medien ist nicht möglich.
        </p>
        <p>
            Nutzen Sie das <Link href="/kategoriesuche">Kategorienmenü</Link>,
            um nach Hauptbereichen wie beispielsweise Heilpädagogik oder
            Mathematik zu filtern. Hier sehen Sie, welche fachlichen Themen
            abgedeckt sind und finden die entsprechenden Materialien im Raum.
        </p>
        <p>
            Die <Link href="/stichwortsuche">Stichwortsuche</Link> im Menü
            ermöglicht Ihnen eine Freitextsuche über mehr als 150 Fachthemen.
        </p>
        <p>
            Unter
            <button
                @click="displayMenu"
                class="text-thunderbird-red font-bold hover:underline focus:underline"
            >
                Weitere Informationen
            </button>
            finden Sie die vollständige Materialliste des DiZ mit über 3500
            Büchern, Spielen, Tests und Filmen.
        </p>
    </div>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { menuState } from "@/menuState";
import { nextTick } from "vue";

const displayMenu = () => {
    if (
        menuState.value.primaryItems &&
        menuState.value.primaryItems.length === 4
    ) {
        menuState.value.primaryItems![3].open = true;
        nextTick(() => {
            const button = document.querySelector<HTMLButtonElement>(
                ".hfh-menu__entry--open"
            );
            button?.focus();
        });
    }
};
</script>

<style scoped></style>
