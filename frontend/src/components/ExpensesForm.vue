<template>
    <form @submit.prevent="submit">
        <input v-model="type" type="text">
        <input v-model="contractor" type="text">
        <input v-model="details" type="text">
        <input v-model="date" type="text">
        <input v-model="sum" type="text">
        <button type="submit">Save</button>
    </form>
</template>

<script>
    import {mapMutations} from 'vuex'

    export default {
        name: "ExpensesForm",
        data() {
            return {
                type: '',
                contractor: '',
                details: '',
                date: '',
                sum: '',
            }
        },
        methods: {
            ...mapMutations(['createExpenses']),
            submit() {
                this.createExpenses({
                    type: this.type,
                    contractor: this.contractor,
                    details: this.details,
                    date: this.date,
                    sum: this.sum
                })
                this.title = ""
            }
        }
    }
</script>

<style scoped>

</style>