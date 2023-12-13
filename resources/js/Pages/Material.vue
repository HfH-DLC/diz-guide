<template>
    <div class="hfh-content">
        <h1>Materialliste</h1>
        <p>
            <HfhLink
                href="https://ilias.hfh.ch/goto.php?target=file_168431_download&client_id=ilias-hfh.ch"
                target="_blank"
                >Vollständige Materialliste des DiZ als PDF</HfhLink
            >. Navigieren sie über das Inhaltsverzeichnis, oder nutzen Sie die
            Suchfunktion des Browsers um nach einem bestimmten Artikel zu
            suchen. Anhand der Signatur können Sie über
            <Link href="/signatursuche">
                Weitere Informationen > Signatursuche
            </Link>
            den Aufbewahrungsort finden.
        </p>
        <!-- <iframe
            width="300"
            height="200"
            src="https://ilias.hfh.ch/goto.php?target=file_168431_download&client_id=ilias-hfh.ch"
        >
        </iframe> -->
        <!-- <object
            type="application/pdf"
            data="https://ilias.hfh.ch/goto.php?target=file_168431_download&client_id=ilias-hfh.ch"
        ></object> -->
    </div>
</template>

<script setup lang="ts">
import { HfhLink } from "@hfh-dlc/hfh-styleguide";
import { Link } from "@inertiajs/vue3";
</script>

<style scoped></style>
