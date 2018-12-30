<template>
    <div>
        <validatable-text-field
            label="Name"
            name="name"
            rules="required"
            :value="name"
            @input="$emit('update:name', $event)"
        ></validatable-text-field>
        <validatable-domain-field
            label="Domain"
            name="domain"
            rules="required"
            :value="domain"
            @input="$emit('update:domain', $event)"
        >
        </validatable-domain-field>
        <b-message
            type="is-info"
            class="has-padding-2"
        >
            This domain is the one your users actually visit and Omotenashi will send the data to Google Analytics that you connect to.
        </b-message>
        <label class="label">
            Whitelisted domains
        </label>
        <template v-for="(domain, domainIndex) in whitelistedDomains">
            <div class="whitelisted-domain">
                <validatable-domain-field
                    name="Whitelisted domain"
                    rules="required"
                    :value="domain"
                    @input="updateWhitelistedDomain(domainIndex, $event)"
                    expanded
                >
                </validatable-domain-field>
                <b-icon
                    v-if="whitelistedDomains.length > 1"
                    pack="fas"
                    icon="trash"
                    class="is-small"
                    @click.native="deleteWhitelistedDomain(domainIndex)"
                >
                </b-icon>
            </div>
        </template>
        <div>
            <button
                class="button is-text"
                @click="addWhitelistedDomain"
            >
                Add more
            </button>
        </div>
        <b-message type="is-warning">
            These domains are where you can create/edit tutorials code-free with <a href="">Omotenashi Chrome extension.</a>
        </b-message>
    </div>
</template>

<script>
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField"
    import ValidatableDomainField from "../fields/ValidatableDomainField";
    import DeleteButton from "../../atoms/buttons/DeleteButton/DeleteButton";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";

    export default {
        name: "ProjectForm",
        components: {
            AddButton,
            ValidatableDomainField,
            DeleteButton,
            ValidatableTextField,
        },
        props: {
            name: {
                type: String,
                default: null,
            },
            domain: {
                type: String,
                default: null,
            },
            whitelistedDomains: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        watch: {
            whitelistedDomains: {
                immediate: true,
                handler(value) {
                    if (value.length === 0) {
                        this.addWhitelistedDomain();
                    }
                }
            }
        },
        computed: {
            innerWhitelistedDomainss: {
                get() {
                    return this.whitelistedDomains
                },
                set(newValue) {
                    return this.$emit('update:whitelistedDomains', newValue)
                }
            }
        },
        methods: {
            addWhitelistedDomain() {
                this.$emit('update:whitelistedDomains', [
                    ...this.innerWhitelistedDomainss,
                    'https://'
                ])
            },
            updateWhitelistedDomain(index, domain) {
                console.log(index, domain)
                this.$emit('update:whitelistedDomains', [
                    ...this.innerWhitelistedDomainss.slice(0, index),
                    domain,
                    ...this.innerWhitelistedDomainss.slice(index+1)
                ])
            },
            deleteWhitelistedDomain(index, domain) {
                this.$emit('update:whitelistedDomains', [
                    ...this.innerWhitelistedDomainss.slice(0, index),
                    ...this.innerWhitelistedDomainss.slice(index+1)
                ])
            }
        }
    }
</script>

<style scoped>
    .whitelisted-domain {
        display: grid;
        grid-template-columns: 1fr auto;
        grid-column-gap: 10px;
    }
    .whitelisted-domain .icon {
        margin-top: 0.5em;
    }
</style>