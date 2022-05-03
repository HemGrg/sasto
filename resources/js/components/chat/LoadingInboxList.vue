<template>
<div>
    <div v-for="n in parseInt(5) " class="loading-inbox-item mb-2 py-2" v-bind:key="n">
        <div>
            <div class="icon"></div>
        </div>
        <div class="detail"></div>
    </div>
</div>
</template>

<script>
export default {}
</script>

<style scoped>
.loading-inbox-item {
    display: flex;
    gap: 1rem;
    align-items: center;
    animation: 1.5s pulse infinite;
}
.loading-inbox-item .icon {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background-color: #395972;
}

.loading-inbox-item .detail {
    width: 100%;
    height: 2rem;
    background-color: #395972;
    border-radius: 3px;
}
@keyframes pulse {
    50% {
        opacity: 50%;
    }
}
</style>