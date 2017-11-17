<template>
    <div v-if="display">
        <h2>Contact</h2>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Company</label>
                <input v-model="company" v-on:blur="update('company',company)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Website</label>
                <input v-model="website" v-on:blur="update('website',website)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Name</label>
                <input v-model="name" v-on:blur="update('name',name)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Last Name</label>
                <input v-model="lastName" v-on:blur="update('lastname',lastName)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Email 1</label>
                <input v-model="email1" v-on:blur="update('email1',email1)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Email 2</label>
                <input v-model="email2" v-on:blur="update('email2',email2)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Phone 1</label>
                <input v-model="phone1" v-on:blur="update('phone1',phone1)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Phone 2</label>
                <input v-model="phone2" v-on:blur="update('phone2',phone2)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-12">
                <label>Address</label>
                <input v-model="address" v-on:blur="update('address',address)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>Country</label>
                <input v-model="country" v-on:blur="update('country',country)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-6">
                <label>City</label>
                <input v-model="city" v-on:blur="update('city',city)" type="text" class="form-control"/>
            </div>
            <div class="form-group col-md-12">
                <label>Source</label>
                <input v-model="source" v-on:blur="update('source',source)" type="text" class="form-control"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'ticket_id'],
        mounted() {
        },
        data() {
            return {
                display: false,
                company: '',
                website: '',
                name: '',
                lastName: '',
                email1: '',
                email2: '',
                phone1: '',
                phone2: '',
                address: '',
                country: '',
                city: '',
                source: ''
            }
        },
        created() {
            let self = this;
            this.$root.$on('showTicket', function (id) {
                if (self.ticket_id === id) {
                    self.get();
                    self.display = true;
                }
            });
            this.$root.$on('getTickets', function () {
                self.display = false;
            });
        },
        methods: {
            get() {
                let self = this;
                let url = '/api/contact/' + this.id;
                axios.get(url).then(function (response) {
                    self.company = response.data.company;
                    self.name = response.data.name;
                    self.lastName = response.data.lastname;
                    self.email1 = response.data.email1;
                    self.email2 = response.data.email2;
                    self.phone1 = response.data.phone1;
                    self.phone2 = response.data.phone2;
                    self.address = response.data.address;
                    self.country = response.data.country;
                    self.city = response.data.city;
                    self.source = response.data.source;
                });
            },
            update(field, value) {
                let self = this;
                let url = '/api/contact/' + this.id + '/update';
                let data = {field: field, value: value};
                axios.post(url, data);
            }
        }
    }
</script>
