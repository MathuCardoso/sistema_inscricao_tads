<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { onMounted, onUnmounted, ref } from "vue";

const toast = ref({ show: false, type: "success", message: "" });

let timeout;
function showToast(message, type = "success") {
    clearTimeout(timeout);
    toast.value = { show: true, type, message };
    timeout = setTimeout(() => {
        toast.value.show = false;
    }, 5000);
}
let removeListener;
onMounted(() => {
    removeListener = router.on("success", (event) => {
        const flash = event.detail.page.props.flash;
        if (flash?.success) {
            showToast(flash.success, "success");
        } else if (flash?.error) {
            showToast(flash.error, "error");
        }
    });
});
onUnmounted(() => {
    removeListener?.();
    clearTimeout(timeout);
});
</script>

<template>
    <Transition name="toast">
        <div v-if="toast.show" class="toast" :class="`toast-${toast.type}`">
            <div class="toast-icon">
                <span v-if="toast.type === 'success'">✓</span>
                <span v-else>!</span>
            </div>
            <div class="toast-content">
                <strong>
                    {{ toast.type === "success" ? "Sucesso" : "Erro" }}
                </strong>
                <span> {{ toast.message }} </span>
            </div>
            <button
                class="toast-close"
                type="button"
                @click="toast.show = false"
            >
                ×
            </button>
        </div>
    </Transition>
</template>

<style scoped>
.toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 320px;
    max-width: 420px;
    padding: 14px 16px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.08),
        0 4px 10px rgba(0, 0, 0, 0.04);
}
.toast-icon {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 700;
}
.toast-success {
    border-left: 4px solid #16a34a;
}
.toast-success .toast-icon {
    color: #ffffff;
    background: #16a34a;
}
.toast-error {
    border-left: 4px solid #dc2626;
}
.toast-error .toast-icon {
    color: #ffffff;
    background: #dc2626;
}
.toast-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 1;
}
.toast-content strong {
    font-size: 14px;
    color: #111827;
}
.toast-content span {
    font-size: 14px;
    line-height: 1.4;
    color: #6b7280;
}
.toast-close {
    border: none;
    background: transparent;
    padding: 4px;
    color: #9ca3af;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
}
.toast-close:hover {
    color: #374151;
} /* Animação */
.toast-enter-active,
.toast-leave-active {
    transition:
        opacity 0.25s ease,
        transform 0.25s ease;
}
.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
