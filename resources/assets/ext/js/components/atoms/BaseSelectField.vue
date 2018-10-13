<template>
    <span class="select">
        <select
            :value="value"
            @change="$emit('change', $event.target.value)"
            @input="$emit('input', $event.target.value)"
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
            }
        }
    }
</script>