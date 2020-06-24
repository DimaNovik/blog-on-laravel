<template>
    <b-row>
        <b-col md="4" cols="12">
            <b-form-input
                    v-model="filter"
                    type="search"
                    id="filterInput"
                    placeholder="Пошук..."
                    class="mb-4"
            ></b-form-input>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "ServicesFilter",
        data() {
            return {
                filter: null
            }
        },
        watch: {
            'filter': {
                immediate: false,
                handler(val) {
                    this.$emit('filter', val)
                }
            }
        }
    }
</script>