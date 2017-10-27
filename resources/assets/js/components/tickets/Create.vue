<template>
    <div v-if="display" class="row" style="margin-top: 20px">
        <div class="form-group col-md-12">
            <label>Company</label>
            <input v-model="company" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Name</label>
            <input v-model="name" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Last Name</label>
            <input v-model="lastName" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Email 1</label>
            <input v-model="email1" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Email 2</label>
            <input v-model="email2" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Phone 1</label>
            <input v-model="phone1" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Phone 2</label>
            <input v-model="phone2" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-12">
            <label>Source</label>
            <input v-model="source" type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-12">
            <button v-on:click="cancel()" class="btn btn-default">Cancel</button>
            <button v-on:click="store()" class="btn btn-primary">Save</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        mounted() {

        },
        data() {
            return {
                display: false,
                company: '',
                name: '',
                lastName: '',
                email1: '',
                email2: '',
                phone1: '',
                phone2: '',
                source: '',
                pipeline: 6,
            }
        },
        methods: {
            cancel() {
                this.display = false;
            },
            store() {
                let self = this;
                let url = '/api/ticket/create';
                let data = {
                    user_id: this.user_id,
                    pipeline: this.pipeline,
                    company: this.company,
                    name: this.name,
                    lastname: this.lastName,
                    email1: this.email1,
                    email2: this.email2,
                    phone1: this.phone1,
                    phone2: this.phone2,
                    source: this.source
                };
                axios.post(url, data).then(function (response) {
                    self.$root.$emit('storeTicket');
                    self.display = false;
                    self.company = self.name = self.lastName = self.email1 = self.email2 = self.phone1 = self.phone2 = self.source = '';
                });
            }
        },
        created() {
            let self = this;
            this.$root.$on('newTicket', function () {
                self.display = true;
            });
            this.$root.$on('changePipeline', function (id) {
                self.pipeline = id;
            });
        }
    }
</script>
