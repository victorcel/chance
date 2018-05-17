<template>
    <div>
        <span v-if="this.counter !=1"><button class="btn btn-danger" v-on:click="descrementCounter">-</button> </span>
        <input min="1" max="100" v-model="counter" :id=getProd disabled>
        <span v-if="this.counter !=10"><button class="btn btn-success" v-on:click="incrementCounter">+</button></span>
    </div>

</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                counter: 1,

            };
        },
        mounted() {

        },
        watch:{
            getId() {
                return concat('product_','hola')
            }
        },
        computed: {
            getProd() {
                return 'product_'+ this.message
            }
        },

        methods: {
            incrementCounter: function () {
                this.counter += 1
            },
            descrementCounter: function () {
                this.counter -= 1
            }
        },
    }
</script>
