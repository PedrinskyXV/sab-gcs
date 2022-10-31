<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/PrimaryButton.vue";
import BreezeInput from "@/Components/TextInput.vue";
import BreezeLabel from "@/Components/InputLabel.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";

import { ref, watch } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    tipos: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    tipo_id: props.user.tipos.id,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put(route("users.update", props.user.id));
};

watch(form, async (newData) => {
    console.log(newData.email);
    if(newData.email !== props.user.email)
    {
        console.log('correo!')
    }
})
</script>

<template>
    <Head title="Editar Usuario" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="inline-block text-xl font-semibold leading-tight text-gray-800 align-center">
                Editar Usuario <font-awesome-icon icon="fa-solid fa-user-pen" class="ml-2" />                
            </h2>
        </template>        
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <h2 class="font-bold text-lg text-gray-800">Datos del Usuario</h2>
                            <br>
                            <div class="grid grid-cols-3 gap-8 mb-8">                                
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
                                <div class="">
                                    <BreezeLabel for="email" value="Correo" />
                                    <BreezeInput
                                        type="email"
                                        v-model="form.email"
                                        name="email"
                                        class="w-full"
                                        required
                                    />
                                    <div
                                        v-if="form.errors.email"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.email }}
                                    </div>
                                </div>
                                <div class="">
                                    <BreezeLabel
                                        for="tipo"
                                        value="Tipo de Usuario"
                                    />

                                    <select
                                        name="tipo"
                                        id="tipo"
                                        v-model="form.tipo_id"
                                        class="form-select appearance-none block w-full text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        required
                                    >
                                        <option disabled value="" selected>
                                            Seleccionar Tipo
                                        </option>
                                        <option
                                            v-for="t in tipos"
                                            :value="t.id"
                                            :key="t.id"
                                        >
                                            {{ t.nombre }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="form.errors.tipo_id"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.tipo_id }}
                                    </div>
                                </div>
                                <div class="">
                                    <BreezeLabel
                                        for="pass"
                                        value="Contraseña"
                                    />
                                    <BreezeInput
                                        type="password"
                                        v-model="form.password"
                                        name="pass"
                                        class="w-full"
                                        
                                    />
                                    <small class="text-gray-600">Actualizar contraseña</small>
                                    <div
                                        v-if="form.errors.password"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.password }}
                                    </div>
                                </div>
                                <div class="">
                                    <BreezeLabel
                                        for="email"
                                        value="Confirmar Contraseña"
                                    />
                                    <BreezeInput
                                        type="password"
                                        v-model="form.password_confirmation"
                                        name="email"
                                        class="w-full"
                                        
                                    />
                                    <div
                                        v-if="form.errors.password_confirmation"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.password_confirmation }}
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
                                    Editar
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
