<template>
    <div>
        <breeze-authenticated-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Profile
                </h2>
            </template>

            <div class="mt-5">
                <div class="bg-white relative shadow-xl w-5/6 md:w-4/6  lg:w-3/6 xl:w-2/6 mx-auto">
                <div class="flex justify-center">
                        <img :src="form.photo" alt="" class="rounded-full mx-auto absolute -top-20 w-32 h-32 shadow-2xl border-4 border-white">
                </div>
                
                <div class="mt-16">
                    <h1 class="font-bold text-center text-3xl text-gray-900 capitalize">{{ auth.user.name }}</h1>
                    <div class="w-full">
                        <h3 class="font-bold text-gray-600 text-left px-4">Profle Details:</h3>
                        <div class="mt-5 w-full mb-5">
                            <form @submit.prevent="updateProfile">
                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="name" class="block text-sm font-medium text-gray-700">Fullname:</label>
                                <label for="name" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.name }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.name" type="text" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                                <label for="email" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.email }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.email" type="email" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                                <label for="phone" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.phone_number }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.phone_number" type="text" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
                                <label for="address" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.address }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.address" type="text" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="address" class="block text-sm font-medium text-gray-700">City:</label>
                                <label for="address" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.city }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.address" type="text" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="w-full border-t-2 border-gray-100 font-medium text-gray-600 py-4 px-4 w-full block hover:bg-gray-100 transition duration-150">
                                <label for="city" class="block text-sm font-medium text-gray-700">City:</label>
                                <label for="city" class="block text-lg font-medium text-gray-700" v-if="!update">{{ auth.user.city }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm" v-if="update">
                                    <input v-model.trim="this.form.city" type="text" name="user" id="user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="Full Name" />
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-5">
                                <button class="mr-2 p-2 bg-green-700 rounded text-white font-medium" v-if="!update" @click="update = true">Edit Profile</button>
                                <loading-button :loading="form.processing" class="mr-2 btn-indigo" type="submit" v-if="update">
                                    Update Profile
                                </loading-button>
                            </div>
                            <div class="mb-10"></div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            </div>

        </breeze-authenticated-layout>
    </div>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import LoadingButton from '@/Components/LoadingButton'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        components: {
            BreezeAuthenticatedLayout,
            LoadingButton,
            BreezeValidationErrors
        },
        props: {
            auth: Object,
            errors: Object
        },
        data( ) {
            return {
                loading: false,
                update: false,
                form: this.$inertia.form({
                    name: this.auth.user.name,
                    email: this.auth.user.email,
                    id: this.auth.user.id,
                    photo: this.auth.user.photo,
                    phone_number: this.auth.user.phone_number,
                    address: this.auth.user.address,
                    city: this.auth.user.city,
                    country: this.auth.user.country
                }),
            }
        },
        mounted( ) {

        },
        watch: {
            
        },
        methods: {
            updateProfile( ) {
                if (confirm('Are you sure you want to update profile details?')) {
                    this.form.put(this.route('profile.update', this.auth.user.id), {
                        onSuccess: () => {
                            this.update = false;
                        }
                    });
                }
            }
        }
    }
</script>