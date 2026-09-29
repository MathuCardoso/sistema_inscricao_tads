<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Toast from "@/components/ui/Toast.vue";
import DashboardHeader from "@/components/dashboard/DashboardHeader.vue";
import ParticipantToolbar from "@/components/dashboard/ParticipantToolbar.vue";
import ParticipantsTable from "@/components/dashboard/ParticipantsTable.vue";
import ParticipantModal from "@/components/dashboard/ParticipantModal.vue";

const props = defineProps({
    participants: Object,
    activities: Object,
    filters: Object,
    registrations: Object,
});

const showModal = ref(false);
const editingParticipant = ref(null);
const search = ref(props.filters?.search ?? "");

const form = useForm({
    name: "",
    email: "",
    cpf: "",
    phone: "",
    activity_ids: [],
});

function togglePresence(registration) {
    router.patch(
        `/registrations/${registration.id}/presence`,
        {},
        { preserveScroll: true },
    );
}

function openModal() {
    editingParticipant.value = null;
    form.reset();
    form.clearErrors();
    showModal.value = true;
}

function openEditModal(participant) {
    editingParticipant.value = participant;
    form.clearErrors();

    const participantRegistrations = props.registrations.filter(
        (registration) => registration.participant_id == participant.id,
    );

    form.name = participant.name;
    form.email = participant.email;
    form.cpf = participant.cpf;
    form.phone = participant.phone;
    form.activity_ids = participantRegistrations.map((registration) =>
        Number(registration.activity_id),
    );

    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    editingParticipant.value = null;
    form.reset();
    form.clearErrors();
}

function submit() {
    if (editingParticipant.value) {
        form.put(`/participantes/${editingParticipant.value.id}`, {
            preserveScroll: true,
            onSuccess: closeModal,
        });
        return;
    }

    form.post("/participantes", {
        preserveScroll: true,
        onSuccess: closeModal,
    });
}

let searchTimeout;

watch(search, (value) => {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        router.get(
            "/dashboard",
            { search: value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        );
    }, 300);
});
</script>

<template>
    <Toast />

    <main class="page">
        <DashboardHeader />

        <section class="content">
            <ParticipantToolbar
                v-model:search="search"
                @create="openModal"
            />

            <ParticipantsTable
                :participants="participants"
                :activities="activities"
                :registrations="registrations"
                @toggle-presence="togglePresence"
                @edit="openEditModal"
            />
        </section>

        <ParticipantModal
            v-if="showModal"
            :form="form"
            :activities="activities"
            :editing-participant="editingParticipant"
            @close="closeModal"
            @submit="submit"
        />
    </main>
</template>

<style scoped>
.page {
    min-height: 100vh;
    background: #161615;
    color: white;
}

.content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 32px 48px;
}
</style>