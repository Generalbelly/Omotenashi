<template>
    <div>
        <span class="select">
            <select
                :value="value"
                @change="$emit('change', $event.target.value)"
                @input="$emit('input', $event.target.value)"
                :id="id"
                :name="name"
            >
                <option
                    v-for="(item, itemIndex) in items"
                    :key="itemIndex"
                    :value="item[itemValue]"
                    :selected="item[itemValue] === value"
                >
                    {{ item[itemText] }}
                </option>
            </select>
        </span>
        <p
            v-for="errorMessage in errorMessages"
            :key="errorMessage"
            class="has-text-danger has-margin-top-3"
        >
            {{ errorMessage }}
        </p>
    </div>
</template>

<script>
    export default {
        name: "BaseSelectField",
        props: {
            value: {
                type: String,
                default: null,
            },
            items: {
                type: Array,
                default() {
                    return [];
                },
            },
            itemText: {
                type: String,
                default: 'text',
            },
            itemValue: {
                type: String,
                default: 'value',
            },
            id: {
                type: String,
                default: '',
            },
            name: {
                type: String,
                default: '',
            },
            errorMessages: {
                type: Array,
                default() {
                    return [];
                }
            }
        }
    }
</script>