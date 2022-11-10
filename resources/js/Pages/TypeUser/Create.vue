<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    tipos: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("tipo.store"));
};
</script>

<template>
    <Head title="Crear Tipo Usuario" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2
                class="inline-block text-xl font-semibold leading-tight text-gray-800 align-center"
            >
                Crear Tipo Usuario
                <font-awesome-icon icon="fa-solid fa-user-plus" class="ml-2" />
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="my-5">
                            <Link :href="route('users.index')">
                                <BreezeButton class="bg-slate-400"
                                    >Volver</BreezeButton
                                ></Link
                            >
                        </div>
                        <form @submit.prevent="submit">
                            <h2 class="font-bold text-lg text-gray-800">
                                Datos del Tipo Usuario
                            </h2>
                            <br />
                            <div class="grid gap-8 mb-8">
                                <div class="">
                                    <BreezeLabel for="nombre" value="Nombre" />
                                    <BreezeInput
                                        type="text"
                                        v-model="form.name"
                                        name="nombre"
                                        class="w-full"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.name"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.name }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <button
                                    type="submit"
                                    class="inline-block px-6 pt-2.5 pb-2 bg-blue-600 text-white font-medium text-xs leading-normal uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out align-center"
                                    :disabled="form.processing"
                                    :class="{ 'opacity-25': form.processing }"
                                >
                                    Guardar
                                    <font-awesome-icon
                                        icon="fa-solid fa-arrow-right-long"
                                        class="ml-2"
                                    />
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
