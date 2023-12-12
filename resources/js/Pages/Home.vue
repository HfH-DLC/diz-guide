<template>
    <header>
        <HfhHeader
            :primaryItems="primaryMenuItems"
            :tertiaryItems="tertiaryMenuItems"
        ></HfhHeader>
    </header>
    <main class="mx-4 xl:max-w-container xl:mx-auto pb-20 mt-3 lg:mt-20">
        <div class="hfh-content">
            <h1>Wilkommen im DiZ</h1>
            <img
                src="/images/DiZ_Welcome.jpg"
                alt=""
                class="w-full h-auto max-w-full block mb-16"
            />
            <p>
                Entdecken SIe die vielfältige Sammlung an Materialien des DiZ
                für Diagnose, Therapie, Beratung und Prävention. Dieser Guide
                hilft Ihnen, sich in unseren Regalen, Schränken und Schubladen
                zurechtzufinden.
            </p>
            <p>
                Nutzen Sie das Kategorienmenü, um nach Hauptbereichen wie
                beispielsweise Heilpädagogik oder Mathematik zu filtern. Hier
                sehen Sie, welche fachlichen Tehmen abgedeckt sind und finden
                die entsprechenden Materialien im Raum.
            </p>
            <p>
                Die Stichwortsuche im Menü ermöglicht Ihnen eine Freitextsuche
                über mehr als 150 Fachthemen.
            </p>
            <p>
                Unter Weitere Informationen finden Sie die vollständige
                Materialliste des DiZ mit über 2000 Büchern, Spielen, Tests und
                Filmen.
            </p>
        </div>
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
            href: "/kategorien",
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
                label: "Filtern nach Aufbewahrungsorten",
                link: {
                    href: "/aufbewahrungsortsuche",
                },
            },
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
        ],
    },
];

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

<style scoped></style>
