<template>
    <div class="row">
        <div class="col-md-6">
            <contact v-bind:id="contact_id" v-bind:ticket_id="id"></contact>
        </div>
        <div class="col-md-6">
            <ticket v-bind:id="id"></ticket>
            <comments v-bind:id="id" v-bind:user_id="user_id"></comments>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'contact_id', 'user_id'],
        mounted() {

        }, data() {
            return {}
        }
    }
</script>
