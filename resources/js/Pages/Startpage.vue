<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import { InertiaLink } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        someString: String,
        availableItems: Array,
    });

    const form = useForm({
        item: null,
    });

    function addItem() {
        form.post(`/`, {
            onSuccess: () => {
                //
            },

            onError: (err) => {
                //
            }
        });
    }
</script>

<template>
    <div>
        <pre>{{ someString }}</pre>

        <pre>{{ availableItems }}</pre>

        <form @submit.prevent="addItem">
            <select v-model="form.item">
                <option v-for="item in availableItems">{{ item.name }}</option>
            </select>

            <div v-if="form.errors.item">
                {{ form.errors.item }}
            </div>

            <br><br>

            <button type="submit">Add Item</button>
        </form>

        <inertia-link href="/restore-items" method="post">Restore Items</inertia-link>
    </div>
</template>
