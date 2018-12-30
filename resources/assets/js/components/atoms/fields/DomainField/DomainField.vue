<template>
    <b-field v-bind="$attrs">
        <b-field
            class="has-margin-bottom-0"
            :type="$attrs.type"
        >
            <b-select
                v-model="protocol"
                placeholder="Protocol"
            >
                <option>https://</option>
                <option>http://</option>
            </b-select>
            <b-input
                v-model="domain"
                placeholder="docker.omotenashi.today"
                expanded
            ></b-input>
        </b-field>
    </b-field>
</template>

<script>
    export default {
        name: "DomainField",
        props: {
            value: {
                type: String,
                default: null
            },
        },
        data() {
            return {
                protocol: 'https://',
                domain: null,
            }
        },
        watch: {
            value: {
                immediate: true,
                handler(value) {
                    console.log(value);
                    if (value && value.includes('://')) {
                        const data = value.split('://')
                        this.protocol = `${data[0]}://`
                        this.domain = data[1]
                    }
                },
            },
            domainUrl(value) {
                this.$emit('input', value);
            }
        },
        computed: {
            domainUrl() {
                return this.protocol+this.domain ? this.domain : ''
            }
        }
    }
</script>

<style scoped>

</style>