<script setup>
defineProps({});
</script>

<template>
    <header class="header">
        <div>
            <span class="system-label">SEMANA ACADÊMICA</span>
            <h1>Participantes</h1>
            <p>Gerencie os participantes inscritos no evento.</p>
        </div>

        <form action="/logout" method="post">
            <button type="submit" class="logout-button">Sair</button>
        </form>
    </header>
</template>

<style scoped>
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 32px 48px;
    border-bottom: 1px solid #e2e7e4;
}

.system-label {
    display: block;
    margin-bottom: 6px;
    color: #ed5e14;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
}

h1 {
    margin: 0;
    font-size: 1.8rem;
}

.header p {
    margin: 6px 0 0;
    color: #66716c;
}

.logout-button {
    padding: 9px 16px;
    border: 1px solid #ed5e14;
    border-radius: 7px;
    color: white;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.2s ease;
}

.logout-button:hover {
    background-color: #ed5e14;
}
</style>