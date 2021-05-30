<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Contact
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Invite New Contact
                    </div>
                </div>

                <div class="flex justify-center items-center">
                    <div>
                        <breeze-validation-errors class="mb-4" />
                    </div>
                    <form @submit.prevent="createInviteContact" class="w-full max-w-sm">
                        <div class="flex items-center border-b border-teal-500 py-2">
                            <input v-model="form.email" name="email" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 focus:outline-none" type="text" placeholder="Email Address to invite" aria-label="Full name">
                            <loading-button :loading="form.processing" class="order border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline" type="submit">
                                Invite
                            </loading-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import BreezeValidationErrors from '@/Components/ValidationErrors'
    import LoadingButton from '@/Components/LoadingButton'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BreezeAuthenticatedLayout,
            BreezeValidationErrors,
            LoadingButton,
            Swal
        },

        props: {
            auth: Object,
            errors: Object,
        },
        data() {
            return {
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
