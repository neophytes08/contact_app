<template>
    <div>
        <breeze-authenticated-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                            <div>
                                Your Contact lists ({{ this.contacts.length }})
                            </div>
                            
                            <div>
                                <svg @click="modalStatus = true" aria-placeholder="Add New Contact" class="w-8 h-8 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                        </div>
                        
                    </div>

                    <div class="grid grid-cols-3 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                        <div v-for="list in contacts" class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg my-20 mx-10 md:mx-20 lg:mx-10">
                            <div class="flex justify-center md:justify-end -mt-16">
                                <img class="w-20 h-20 object-cover rounded-full border-2 border-indigo-500" :src="list.user.photo" :alt="list.photo">
                            </div>
                            <div>
                                <h2 class="text-gray-800 text-3xl font-semibold">Details</h2>
                                <ul class="mt-2 text-lg text-gray-700">
                                    <li class="p-2">Email Address: {{ list.user.email }}</li>
                                    <li class="p-2">Phone Number: {{ list.user.phone_number }}</li>
                                    <li class="p-2">Address: {{ list.user.address }}</li>
                                    <li class="p-2">City: {{ list.user.city }}</li>
                                    <li class="p-2">Country: {{ list.user.country }}</li>
                                </ul>
                            </div>
                            <div class="flex justify-end mt-4">
                                <a href="#" class="text-xl font-medium text-indigo-500 capitalize">{{ list.user.name }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <card-modal :showing="modalStatus" @close="modalStatus = false">
                <breeze-validation-errors class="mb-4" />
                <form @submit.prevent="createInviteContact">
                <h2 class="text-xl font-bold text-gray-900">Add New Contact</h2>
                <p class="mb-6 text-sm text-gray-500">Type the Email Address to invite to your contact list</p>

                <div>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        </div>
                        <input type="text" v-model="form.email" name="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Email Address" />
                    </div>
                </div>

                <div class="flex justify-end mt-5">
                    <loading-button :loading="form.processing" class="order border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline" type="submit">
                        Add Contact
                    </loading-button>
                </div>
                </form>
            </card-modal>

        </breeze-authenticated-layout>
    </div>
    
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import cardModal from '@/Components/Modal'
    import BreezeValidationErrors from '@/Components/ValidationErrors'
    import LoadingButton from '@/Components/LoadingButton'
    import Swal from 'sweetalert2'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            BreezeAuthenticatedLayout,
            cardModal,
            BreezeValidationErrors,
            LoadingButton
        },

        props: {
            auth: Object,
            errors: Object,
            contacts: Array
        },

        data() {
            return {
                modalStatus: false,
                loading: false,
                form: this.$inertia.form({
                    user_id: this.auth.user.id,
                    email: ''
                })
            }
        },

        methods: {
            createInviteContact( ) {
                this.form.processing = true;
                window.axios.post('/contacts', this.form)
                .then(async (response) => {
                    console.log(response);
                    this.form.processing = false;
                    this.form.reset('email');
                    Inertia.reload()
                    Swal.fire(
                        'Success!',
                        response.data.message,
                        'success'
                    );
                })
                .catch((error) => {
                    console.log(error);
                    this.form.processing = false;
                    // this.$page.props.errors = error.data;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                });
            }
        }
    }
</script>
