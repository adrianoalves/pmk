<template>
    <input :type="type" class="form-control" :class="size === 'lg' ? 'form-control-lg':''" :placeholder="placeholder" />
    <div v-if="validated" :class="valid ? 'valid-feedback' : 'invalid-feedback'">{{ message || 'ok!' }}</div>
</template>

<script>
export default {
    name: "Input",
    props: {
        value: { type: String, default: '' },
        type: { type: String, default: 'text' },
        size: { type: String, default: 'sm' },
        datatype: { type: 'String', default: 'name' },
        placeholder: { type: 'String', required: true }
    },
    data() {
        return {
            validated: false, valid: null,
            message: null
        }
    }
}
</script>

<style scoped>

</style>
