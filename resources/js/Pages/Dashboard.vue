<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref,onMounted,watch,computed } from 'vue'
import axios from 'axios';

const vocabularies = ref()
const tanggal = ref({
    from: '',
    to: ''
}) 
const isShowVocabularies = ref(false)

const getVocabularies = () => {
    axios.get(route('vocabularies.get', {
        tanggal: tanggal.value
    })).then(res => {
        vocabularies.value = res.data
    }).catch(e => {
        console.log(`error get vocabularies -> ${e}`)
    })
}

const resetTanggal = () => {
    tanggal.value = {
        from: '',
        to: ''
    }
}

onMounted(() => {
    getVocabularies()
})

watch(() => [tanggal.value.to], (to, from) => {
    if (to) {
        getVocabularies()
    }
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container-fluid mx-3 rounded py-5">
            <h1 class="text-center font-bold text-2xl">Menu</h1>

            <div class="content mt-5 text-center space-y-5">
                
                <div>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Indonesia - Inggris
                        </Link>
                </div>
                
                <div>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Inggris - Indonesia
                        </Link>
                </div>
                
                <div>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('vocabularies')"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Tambah Kosakata
                        </Link>
                </div>
                <div>
                    <button
                        @click="isShowVocabularies = !isShowVocabularies"
                        class="font-bold bg-green-500 px-10 py-1 text-xl rounded active:bg-green-600"
                        >Show Vocabularies
                        </button>
                </div>

                <transition
                    enter-active-class="transition ease-out duration-500"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <div v-if="isShowVocabularies" class="rounded lg:w-1/3 mx-auto space-y-4">
                        <div class="tanggal flex space-x-2">
                            <input type="date" class="rounded w-full border border-gray-400 w-2/5" v-model="tanggal.from">
                            <input type="date" class="rounded w-full border border-gray-400 w-2/5" v-model="tanggal.to">
                            <button class="1/5 bg-yellow-400 hover:bg-yellow-600 px-2 rounded-full" @click="resetTanggal()">Reset</button>
                        </div>
                        <div class="mt-4 bg-gray-100 space-y-1" v-for="allVocabularies, i in vocabularies">
                            <div class="w-full bg-slate-800 text-gray-100">{{ i }}</div>
                            <div class="p-2 bg-slate-200" v-for="vocabulary in allVocabularies" :class="[(vocabulary.explanation == null) ? '' : 'lg:flex']">
                                <div class="my-auto" :class="[(vocabulary.explanation == null) ? 'lg:w-full' : 'border-b-2 lg:border-b-0 border-slate-400 pb-3 lg:pb-0 lg:w-1/2']">{{vocabulary.indonesia}} - {{vocabulary.english}}</div>
                                <div class="lg:w-1/2 mt-3 lg:mt-0">{{vocabulary.explanation}}</div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
