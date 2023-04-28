<script setup>
import { ref,onMounted,watch,computed } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const newVocabularies = ref([])
const alert = ref({
    isOpen: false,
    status: '',
    message: ''
})

const form = useForm({
    indonesia:{
        0: '',
        1: '',
        2: '',
        3: '',
        4: ''
    },
    english: {
        0: '',
        1: '',
        2: '',
        3: '',
        4: ''
    },
    explanation: {
        0: '',
        1: '',
        2: '',
        3: '',
        4: ''
    },
    show_date: '2023-04-09' 
})

const addNewVocabularies = () => {
    form.post(route("vocabularies.add"),
{
    onSuccess:()=>{
        form.reset()
        alert.value = {
            isOpen: true,
            status: 'success',
            message: 'Data Berhasil disimpan'
        }
    }
})
}

const getDateNow = () => {
    const now = new Date();
    let month = (now.getMonth() + 1);               
    let day = now.getDate();
    if (month < 10) 
        month = "0" + month;
    if (day < 10) 
        day = "0" + day;
    return now.getFullYear() + '-' + month + '-' + day;
}

watch(() => [alert.value], (to, from) => {
    if (to) {
        if(to[0].isOpen){
            setTimeout(() => {
                alert.value = {
                    isOpen: false,
                    status: '',
                    message: ''
                }
            }, 5000);   
        }
    }
})

onMounted(() => {
    form.show_date = getDateNow()
})


</script>

<template>
    <AuthenticatedLayout>

        <div class="container my-5">
            <h1 class="text-center font-bold text-2xl">Add new vocabularies</h1>

            <div class="form mt-10 w-full px-8 px-4">
                <transition name="fade">
                    <div class="w-full bg-green-600 py-2 text-center font-bold text-slate-100 rounded mb-10 transition" v-if="alert.isOpen == true">{{alert.message}}</div>
                </transition>
                <div class="vocab md:flex md:space-x-8 mx-auto">
                    <div class="indonesia text-center mt-5 md:w-1/3 space-y-2">
                        <label for="" class="font-bold">Indonesia*</label> <br>
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.indonesia[0]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.indonesia[1]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.indonesia[2]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.indonesia[3]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.indonesia[4]">
                        <div class="text-sm italic text-red-400 text-left" v-if="$attrs.errors.indonesia">{{$attrs.errors.indonesia}}</div>
                    </div>

                    <div class="english text-center mt-5 md:w-1/3 space-y-2">
                        <label for="" class="font-bold">English*</label> <br>
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.english[0]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.english[1]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.english[2]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.english[3]">
                        <input type="text" class="rounded w-full border border-gray-400" v-model="form.english[4]">
                        <div class="text-sm italic text-red-400 text-left" v-if="$attrs.errors.english">{{$attrs.errors.english}}</div>
                    </div>

                    <div class="explanation text-center mt-5 md:w-1/3 space-y-2">
                        <label for="" class="font-bold">Explanation</label> <br>
                        <textarea class="rounded w-full border border-gray-400" v-model="form.explanation[0]" rows="1"></textarea>
                        <textarea class="rounded w-full border border-gray-400" v-model="form.explanation[1]" rows="1"></textarea>
                        <textarea class="rounded w-full border border-gray-400" v-model="form.explanation[2]" rows="1"></textarea>
                        <textarea class="rounded w-full border border-gray-400" v-model="form.explanation[3]" rows="1"></textarea>
                        <textarea class="rounded w-full border border-gray-400" v-model="form.explanation[4]" rows="1"></textarea>
                    </div>
                </div>
                

                <div class="show_date text-center mt-5 w-full">
                    <label for="" class="font-bold">Show Date</label> <br>
                    <input type="date" class="rounded w-full border border-gray-400" v-model="form.show_date">
                </div>

                <div class="submit text-center mt-5">
                    <button class="text-center font-bold w-full hover:bg-green-700 bg-green-600 text-gray-200 rounded py-1 transition" @click="addNewVocabularies()">Submit</button>
                </div>


            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

.fade-enter-from{
    opacity: 0;
}
.fade-enter-to{
    opacity: 1;
}
.fade-enter-active{
    transition: all 1s ease;
}
.fade-leave-from{
    opacity: 1;
}
.fade-leave-to{
    opacity: 0;
}
.fade-leave-active{
    transition: all 1s ease;
}


</style>