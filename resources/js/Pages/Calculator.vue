<template>
    <h1 class ="title">Not so simple calculator</h1>
    <div class="calculator">
        <input type="text" class="result"
               :value="result" readonly />
        <div class="buttons">
            <button class="number" @click="handleClick('7')">7</button>
            <button class="number" @click="handleClick('8')">8</button>
            <button class="number" @click="handleClick('9')">9</button>
            <button class="operator" @click="operatorClick('/')">/</button>

            <button class="number" @click="handleClick('4')">4</button>
            <button class="number" @click="handleClick('5')">5</button>
            <button class="number" @click="handleClick('6')">6</button>
            <button class="operator" @click="operatorClick('*')">*</button>

            <button class="number" @click="handleClick('1')">1</button>
            <button class="number" @click="handleClick('2')">2</button>
            <button class="number" @click="handleClick('3')">3</button>
            <button class="operator" @click="operatorClick('-')">-</button>

            <button class="clear" @click="clearClick('C')">C</button>
            <button class="number" @click="handleClick('0')">0</button>
            <button class="equal" @click="calculateResult()">=</button>
            <button class="operator" @click="operatorClick('+')">+</button>
        </div>

    </div>

    <div v-if="errorMessage" class="error-message">
        <p>{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            result: '',
            errorMessage: null,
            calculated : false
        };
    },
    methods: {
        handleClick(val){
            if(this.calculated){
                this.result = val;
                this.calculated = false;
            }
            else {
                this.result += val;
            }
        },

        operatorClick(operator){
            let lastchar=this.result[this.result.length-1];
            if(lastchar==='+' || lastchar==='-' || lastchar==='*' || lastchar==='/' ){
                this.result=this.result.slice(0,-1);
            }
            this.result+=operator;
            this.calculated=false;
        },

        clearClick(){
            if(this.calculated){
                this.result='';
                this.calculated=false;
            }
            else {
                this.result = this.result.slice(0, -1);
            }
        },

        async calculateResult(){
            try{
                const response=await axios.post('calculate', {expression: this.result});
                this.result=response.data.result;
                this.calculated=true;
                this.errorMessage=null;
            }
            catch (error){
                this.result='';
                this.errorMessage=error.response?.data?.error || "an error occurred";
            }
        }
    }
};
</script>

<style>
.title {
    text-align: center;
    font-size: 30px;
    color: green;
}

.calculator {
    width: 300px;
    margin: 0 auto;
    border: 1px solid ;
    border-radius: 5px;
    padding: 20px;
}

.result {
    width: 90%;
    padding: 10px;
    font-size: 20px;
    text-align: right;
    margin-bottom: 10px;
}

.buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 10px;
}

button {
    padding: 15px;
    font-size: 18px;
    cursor: pointer;
}

.number  {
    background-color: aqua;
}

.operator{
    background-color: gold;
}

.clear, .equal {
    background-color: #ff66eb;
    color: white;
}

button:hover {
    background-color: #ddd;
}

.error-message {
    color: red;
    font-weight: bold;
    text-align: center;
    font-size: 20px;
}


</style>
