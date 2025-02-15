<template>
    <div>
        <h1>Simple Calculator</h1>
        <input type="number" v-model="num1" placeholder="enter first number">
        <select v-model="operator">
            <option value="add">+</option>
            <option value="subtract">-</option>
            <option value="multiply">*</option>
            <option value="divide">/</option>
        </select>
        <input type="number" v-model="num2" placeholder="enter second number">
        <button @click="calculate">Calculate</button>

        <h2 v-if="result != null">Result: {{ result }}</h2>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            num1: null,
            num2: null,
            operator: null,
            result: null,
            errorMessage: null
        };
    },
    methods: {
        async calculate() {
            try {
                const response = await axios.post("/calculate", {
                    num1: this.num1,
                    num2: this.num2,
                    operator: this.operator
                });
                this.result = response.data.result;
                this.errorMessage = null;
            } catch (error) {
                this.result = null;
                this.errorMessage = error.response?.data?.error || "an error occurred.";
            }
        }
    }
};
</script>

<style>
input, select, button {
    margin: 5px;
    padding: 5px;
}

.error-message {
    color: red;
    font-size: 40px;
}
</style>
