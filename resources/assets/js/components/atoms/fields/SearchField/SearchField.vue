<template>
    <b-field v-bind="$attrs">
        <b-input
            type="search"
            icon-pack="fas"
            icon="search"
            v-model="inputValue"
        >
        </b-input>
        <p class="control">
            <search-button
                :class="searchButtonClass"
                class="is-primary-050"
                @click="$emit('click:search')"
            >
            </search-button>
        </p>
    </b-field>
</template>

<script>
    import SearchButton from "../../buttons/SearchButton";

    export default {
        name: "SearchField",
        components: {
            SearchButton
        },
        props: {
            value: {
                type: String,
                default: null,
            },
            searchButtonClass: {
                type: [String, Object, Array],
                default: null,
            }
        },
        computed: {
            inputValue: {
                get() {
                    return this.value
                },
                set(newValue) {
                    this.$emit('input', newValue)
                }
            },
        }
    }
</script>

