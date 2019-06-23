<template>
    <div id="app">
        <expenses-form></expenses-form>
        <b>All: {{expensesCount}}</b>
        <table>
            <thead>
            <td>ID</td>
            <td>type</td>
            <td>contractor</td>
            <td>details</td>
            <td>date</td>
            <td>sum</td>
            </thead>
            <tbody>
            <tr v-for="expense in validExpenses" v-bind:key="expense.id">
                <td>{{expense.type}}</td>
                <td>{{expense.contractor}}</td>
                <td>{{expense.details}}</td>
                <td>{{expense.date}}</td>
                <td>{{expense.sum}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    //TODO: filter, style - material
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'
    import ExpensesForm from './components/ExpensesForm.vue'

    export default {
        name: 'app',
        components: {
            ExpensesForm
        },
        computed: mapGetters(['validExpenses', 'expensesCount']),
        methods: mapActions(['fetchExpenses']),
        async mounted() {
            this.fetchExpenses()
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
</style>
