<template>
    <header>
        <HfhHeader
            :primaryItems="primaryMenuItems"
            :tertiaryItems="tertiaryMenuItems"
            :linkComponent="Link"
            :currentItem="currentItem"
            :key="new Date().toTimeString()"
        ></HfhHeader>
    </header>
    <main class="mx-4 xl:max-w-container xl:mx-auto pb-20 mt-3 lg:mt-20">
        <slot></slot>
    </main>
    <footer>
        <HfhFooter>
            <template #tagline
                ><p>
                    wissenschaftsbasiert, praxisorientiert, breit verankert
                </p></template
            >
            <template #contact-address
                ><p>
                    Schaffhauserstrasse 239<br />Postfach 5850<br />CH-8050
                    Zürich
                </p></template
            >
            <template #contact-other>
                <p>T +41 44 317 11 11</p>
                <p><a href="mailto:info@hfh.ch">info@hfh.ch</a></p>
            </template>
            <template #socials>
                <HfhSocialBlock
                    icon="facebook"
                    href="https://www.facebook.com/hfh.edu"
                />
                <HfhSocialBlock
                    icon="youtube"
                    href="https://www.youtube.com/user/hfhzuerich"
                />
                <HfhSocialBlock
                    icon="linkedin"
                    href="https://www.linkedin.com/company/hfh.edu"
                />
                <HfhSocialBlock
                    icon="instagram"
                    href="https://www.instagram.com/hfh_edu/"
                />
                <HfhSocialBlock
                    icon="twitter"
                    href="https://twitter.com/hfh_edu"
                />
                <HfhSocialBlock
                    icon="issuu"
                    href="https://issuu.com/hochschule_fuer_heilpaedagogik"
                />
            </template>
            <template #copyright
                >© Copyright {{ new Date().getFullYear() }} HfH</template
            >
        </HfhFooter>
    </footer>
</template>

<script setup lang="ts">
import { HfhHeader, HfhFooter } from "@hfh-dlc/hfh-styleguide";
import { HfhSocialBlock } from "@hfh-dlc/hfh-styleguide";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const primaryMenuItems = [
    {
        label: "Willkommen",
        link: {
            href: "/",
        },
    },
    {
        label: "Kategorien",
        link: {
            href: "/kategoriesuche",
        },
    },
    {
        label: "Stichwortsuche",
        link: {
            href: "/stichwortsuche",
        },
    },
    {
        label: "Weitere Informationen",
        children: [
            {
                label: "Vollständige Materialliste des DiZ",
                link: {
                    href: "/materialliste",
                },
            },
            {
                label: "Signatursuche",
                link: {
                    href: "/signatursuche",
                },
            },
            {
                label: "Suche nach Aufbewahrungsorten",
                link: {
                    href: "/ortsuche",
                },
            },
        ],
    },
];

const currentItem = computed(() => {
    return usePage().url;
});

const tertiaryMenuItems = [
    {
        label: "Didaktisches Zentrum",
        link: {
            href: "https://www.hfh.ch/services/didaktisches-zentrum",
            target: "_blank",
        },
    },
    { label: "hfh.ch", link: { href: "https://hfh.ch", target: "_blank" } },
];
</script>

<style lang="scss" scoped></style>
