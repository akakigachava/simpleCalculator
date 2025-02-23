<template>
    <h1 class ="title">Not so simple calculator</h1>
    <div class="calculator">
        <input type="text" class="result"
               :value="form.expression" readonly />
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

            <button class="clear" @click="clearClick()">C</button>
            <button class="number" @click="handleClick('0')">0</button>
            <button class="equal" @click="calculateResult()">=</button>
            <button class="operator" @click="operatorClick('+')">+</button>
        </div>

    </div>

    <div v-if="form.errorMessage" class="error-message">
        <p>{{ form.errorMessage }}</p>
    </div>


</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    expression: '',
    calculated: false,
    errorMessage: null
});


const handleClick = (val) => {
    if (form.calculated) {
        form.expression = val;
        form.calculated = false;
    } else {
        form.expression += val;
    }
};


const operatorClick = (operator) => {
    let lastchar = form.expression[form.expression.length - 1];
    if (lastchar==='+' || lastchar==='-' || lastchar==='*' || lastchar==='/' ) {
        form.expression = form.expression.slice(0, -1);
    }
    form.expression += operator;
    form.calculated = false;
};


const clearClick = () => {
    if (form.calculated) {
        form.expression = '';
        form.calculated = false;
    } else {
        form.expression = form.expression.slice(0, -1);
    }
};

const calculateResult = () => {
    form.post('calculate', {
        data: {
            expression : form.expression
        },
        onSuccess: (page) => {
            if(page.props.errorMessage!=null){
                form.errorMessage=page.props.errorMessage;
                form.expression=page.props.result;
                form.calculated=false;
            }
            else{
                form.expression = page.props.result;
                form.calculated = true;
                form.errorMessage = null;
            }
        },
        onError: (errors) => {
            form.errorMessage = errors.errorMessage || 'an error occurred during calculation';
        }
    });
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
