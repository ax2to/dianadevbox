<template>
    <div class="container-fluid" style="margin-top: 20px">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">New Ticket</div>

                    <div class="panel-body">
                        <div class="row">
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
                                <button v-on:click="storage()" class="btn btn-primary">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                company: '',
                name: '',
                lastName: '',
                email1: '',
                email2: '',
                phone1: '',
                phone2: '',
            };
        },
        methods: {
            storage() {
                let self = this;
                let url = '/api/ticket/create';
                let data = {
                    company: self.company,
                    name: self.name,
                    lastname: self.lastName,
                    email1: self.email1,
                    email2: self.email2,
                    phone1: self.phone1,
                    phone2: self.phone2,
                };
                axios.post(url, data).then(function (response) {
                    self.$parent.$data.isNewTicket = false;
                    self.$parent.$options.methods.getTickets(self.$parent.$data.current);
                    self.company = self.name = self.lastName = self.email1 = self.email2 = self.phone1 = self.phone2 = '';
                })
            }
        }
    }
</script>
