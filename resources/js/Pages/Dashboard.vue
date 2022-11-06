<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps({
    nUsers: {
        type: Number,
        default: () => ({}),
    },    
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl inline-block">
                            <font-awesome-icon icon="fa-solid fa-door-open"  class="mr-2"/>
                            Bienvenido 
                            <b>{{ $page.props.auth.user.name }}</b></h2>
                    </div>
                </div>
                <br>

                <div class="flex flex-wrap -mx-3">
                    <div
                        class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4"
                    >
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border"
                        >
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div
                                        class="flex-none w-2/3 max-w-full px-3"
                                    >
                                        <div>
                                            <p
                                                class="mb-0 font-sans font-semibold leading-normal text-sm"
                                            >
                                                Usuarios Registrados
                                            </p>
                                            <h5 class="mb-0 font-bold">{{nUsers}}</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="inline-block w-12 h-12 text-center rounded-lg bg-slate-700"
                                        >
                                            <i
                                                class="leading-none text-lg relative top-3.5 text-white"
                                                ><font-awesome-icon
                                                    icon="fa-solid fa-user"
                                            /></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4"
                    >
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border"
                        >
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div
                                        class="flex-none w-2/3 max-w-full px-3"
                                    >
                                        <div>
                                            <p
                                                class="mb-0 font-sans font-semibold leading-normal text-sm"
                                            >
                                                Bienes Registrados
                                            </p>
                                            <h5 class="mb-0 font-bold">21</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="inline-block w-12 h-12 text-center rounded-lg bg-slate-700"
                                        >
                                            <i
                                                class="leading-none text-lg relative top-3.5 text-white"
                                                ><font-awesome-icon icon="fa-solid fa-house-user" /></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>
