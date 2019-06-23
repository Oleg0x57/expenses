export default {
    actions: {
        async fetchExpenses(ctx) {
            const res = await fetch('http://localhost:8080/api/v1/expends')
            const expenses = await res.json()
            ctx.commit('updateExpenses', expenses)
        }
    },
    mutations: {
        updateExpenses(state, expenses) {
            state.expenses = expenses
        },
        createExpenses(state, expenses) {
            state.expenses.unshift(expenses)
        }
    },
    state: {
        expenses: []
    },
    getters: {
        validExpenses(state) {
            return state.expenses.filter(t => {
                return t.id
            })
        },
        getExpenses(state) {
            return state.expenses;
        },
        expensesCount(state, getters) {
            return getters.validExpenses.length
        }
    }
}
