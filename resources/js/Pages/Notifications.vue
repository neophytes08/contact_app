<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifications
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Your Notifications
                    </div>

                    <div v-for="list in notifications" class="flex w-full p-4 justify-between">
                        <div>
                            <p class="text-lg font-medium"><span class="text-lg font-semibold">{{ list.data.name }}</span> added you as contact, do you want to add this user as your contact?</p>
                        </div>
                        <div>
                            <div class="flex justify-between" v-if="list.data.status == 0">
                                <button @click="changeContactStatus(list, 1)" type="button" class="border border-green-500 bg-green-500 text-white rounded-md px-2 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                                    Accept
                                </button>
                                <button type="button" class="border border-red-500 bg-red-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline"
                                >
                                    Cancel
                                </button>
                            </div>
                            <div class="flex justify-between" v-if="list.data.status == 1">
                                <button
                                    type="button"
                                    class="border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline"
                                >
                                    Added as Contact
                                </button>
                            </div>

                            <div class="flex justify-between" v-if="list.data.status == 2">
                                <button
                                    type="button"
                                    class="border border-gray-700 bg-gray-700 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                                >
                                    Rejected as Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
        BreezeAuthenticatedLayout,
        },

        props: {
            auth: Object,
            errors: Object,
            notifications: Array
        },
        created() {
            window.Echo.private(`App.Models.User.${ this.$page.props.auth.user.id }`)
                .notification((notification) => {
                console.log(notification);
                switch(notification.type) {
                    case 'App\\Notifications\\SendUserNotification':
                    Inertia.reload({ only: ['notifications'] })
                    break;
                }
            });
        },
        methods: {
            changeContactStatus(list, status) {
                let data = {
                    name:  list.data.name,
                    user_id: list.data.user_id,
                    contact_id: list.data.contact_id,
                    status: status,
                    direct_invite: list.data.direct_invite,
                    id: list.id
                }

                this.$inertia.post(route('notifications.update_status'), data);
            }
        }
    }
</script>
