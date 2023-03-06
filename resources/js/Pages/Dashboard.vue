<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const goto = () => {

}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container-fluid bg-gray-300 mx-3 rounded py-5">
            <h1 class="text-center font-bold text-2xl">Menu</h1>

            <div class="content mt-5 text-center space-y-5">
                
                <button>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Inggris - Indonesia
                        </Link>
                </button>
                
                <button>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Inggris - Indonesia
                        </Link>
                </button>
                
                <button>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Tambah Kosakata
                        </Link>
                </button>
                <!-- <button class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600" @click="goto()">Inggris - Indonesia</button>
                <button class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600" @click="">Indonesia - Inggris</button>
                <button class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600" @click="">Tambah Kosakata</button> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
