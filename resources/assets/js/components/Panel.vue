<template>
    <section id="issues" class="panel panel-default">
        <div class="panel-heading">{{ header }}</div>
        <div class="panel-body">
            <slot>this is a panel body</slot>
        </div>
        <div class="panel-footer">
            {{ footer }}
        </div>
    </section>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted panel.')
        },
        props: ['header', 'footer']
    }
</script>
