<template>
    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <breeze-label for="name" value="Name" />
            <breeze-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <breeze-label for="email" value="Email" />
            <breeze-input id="email" :disabled="invite_data" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
        </div>

        <div class="mt-4">
            <breeze-label for="password" value="Password" />
            <breeze-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <breeze-label for="password_confirmation" value="Confirm Password" />
            <breeze-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <breeze-label for="phone" value="Phone" />
            <breeze-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone_number" required autocomplete="phone" placeholder="+63 9064317892" />
        </div>
        
        <div class="mt-4">
            <breeze-label for="address" value="Address" />
            <breeze-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" required autocomplete="address" />
        </div>

        <div class="mt-4">
            <breeze-label for="city" value="City" />
            <breeze-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" required autocomplete="city" />
        </div>

        <div class="mt-4">
            <breeze-label for="country" value="Country" />
            <breeze-input id="country" type="text" class="mt-1 block w-full" v-model="form.country" required autocomplete="country" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
            </inertia-link>

            <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </breeze-button>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from '@/Layouts/Guest'
    import BreezeInput from '@/Components/Input'
    import BreezeLabel from '@/Components/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
        },

        props: {
            auth: Object,
            errors: Object,
            invite_data: Object
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: this.invite_data ? this.invite_data.email : '',
                    password: '',
                    password_confirmation: '',
                    address: '',
                    city: '',
                    country: '',
                    phone_number: '',
                    terms: false,
                    user_id: this.invite_data ? this.invite_data.user_id : '',
                    link: this.invite_data ? this.invite_data.invite_link : ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
