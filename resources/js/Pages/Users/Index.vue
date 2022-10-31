<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

const props = defineProps({
    users: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm();

function destroy(id) {
    if (confirm("Esta seguro de eliminar el usuario?")) {
        form.delete(route("users.destroy", id));
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    // Then specify how you want your dates to be formatted
    return new Intl.DateTimeFormat("es-ES", {dateStyle: 'long', timeStyle: 'short' }).format(
        date
    );
}
</script>

<template>
    <Head title="Usuarios" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Control de Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    v-if="$page.props.flash.message"
                    class="alert bg-green-200 rounded-lg py-5 px-6 mb-3 text-base text-green-800 inline-flex items-center w-full alert-dismissible fade show"
                    role="alert"
                >
                    <font-awesome-icon
                        icon="fa-regular fa-circle-check"
                        class="mr-2"
                    />
                    {{ $page.props.flash.message }}

                    <button
                        type="button"
                        class="btn-close box-content w-4 h-4 p-1 ml-auto text-yellow-900 border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-yellow-900 hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <Link :href="route('users.create')">
                                <BreezeButton
                                    >Agregar Usuario</BreezeButton
                                ></Link
                            >
                        </div>

                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        >
                            <table
                                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Nombre
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Correo
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Ultimo inicio
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Creado el
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Tipo Usuario
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Editar
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Eliminar
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(user, index) in users"
                                        :key="user.id"
                                        class="bg-zinc-100 border-b"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                        >
                                            {{ index + 1 }}
                                        </th>
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                        >
                                            {{ user.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ user.email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ user.ultima_vez === null ? "Sin inicio aun" : formatDate(user.ultima_vez) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ formatDate(user.created_at) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold text-white rounded w-full"
                                                :class="[
                                                    user.tipos.id === 1
                                                        ? 'bg-yellow-600'
                                                        : '',
                                                    user.tipos.id === 2
                                                        ? 'bg-green-600'
                                                        : '',
                                                    user.tipos.id === 3
                                                        ? 'bg-teal-600'
                                                        : '',
                                                ]"
                                                >{{ user.tipos.nombre }}</span
                                            >
                                        </td>

                                        <td class="px-6 py-4">
                                            <Link
                                                :href="
                                                    route('users.edit', user.id)
                                                "
                                                class="px-4 py-2 text-white bg-blue-600 rounded-lg uppercase"
                                                >Editar</Link
                                            >
                                        </td>
                                        <td class="px-6 py-4">
                                            <button
                                                type="button"
                                                class="px-4 py-2 text-white bg-red-600 rounded-lg uppercase"
                                                @click="destroy(user.id)"
                                            >
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
