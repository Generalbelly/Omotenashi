<template>
    <div>
        <validatable-text-field
            label="Name"
            name="name"
            rules="required"
            :value="name"
            @input="$emit('update:name', $event)"
        ></validatable-text-field>
        <label class="label">
            Domain
            <question-circle-icon
                @click="showDomainHelp = !showDomainHelp"
                size="is-small"
                class="has-cursor-pointer"
            >
            </question-circle-icon>
        </label>
        <b-collapse
            :open="showDomainHelp"
        >
            <b-message
                type="is-info"
                class="has-margin-top-2 has-margin-bottom-4"
            >
                This domain is the one your users actually visit. Omotenashi will send the data to Google Analytics for you.<br>
                <span
                    @click="showDomainHelp = false"
                    class="has-padding-top-3 is-inline-block has-text-info has-cursor-pointer"
                >
                    Close
                </span>
            </b-message>
        </b-collapse>
        <validatable-domain-field
            name="domain"
            rules="required"
            v-model="domainUrl"
        >
        </validatable-domain-field>
        <label class="label">
            Whitelisted domains for tutorials
            <question-circle-icon
                @click="showWhitelistHelp = !showWhitelistHelp"
                size="is-small"
                class="has-cursor-pointer"
            >
            </question-circle-icon>
        </label>
        <b-collapse
            :open="showWhitelistHelp"
        >
            <b-message
                type="is-info"
                class="has-margin-top-2 has-margin-bottom-4"
            >
                These domains are where you can create/edit tutorials code-free with <a href="">Omotenashi Chrome extension.</a><br>
                <span
                    @click="showWhitelistHelp = false"
                    class="has-padding-top-3 is-inline-block has-text-info has-cursor-pointer"
                >
                    Close
                </span>
            </b-message>
        </b-collapse>
        <div
            v-for="(whitelistedDomainEntity, whitelistedDomainEntityIndex) in whitelistedDomainEntities"
            :key="whitelistedDomainEntity.id"
            class="whitelisted-domain"
        >
            <validatable-domain-field
                name="Whitelisted domain"
                rules="required"
                :value="`${whitelistedDomainEntity.protocol}://${whitelistedDomainEntity.domain}`"
                @input="updateWhitelistedDomainEntity($event, whitelistedDomainEntityIndex)"
                expanded
            >
            </validatable-domain-field>
            <div
                class="whitelisted-domain__actions"
                :class="{'whitelisted-domain__actions--single': whitelistedDomainEntity.id && whitelistedDomainEntities.length === 1}"
            >
                <external-link-icon
                    v-if="whitelistedDomainEntity.id"
                    size="is-small"
                    @click="sendTo(whitelistedDomainEntity)"
                    class="whitelisted-domain__icon"
                >
                </external-link-icon>
                <external-link-icon
                    v-else
                    size="is-small"
                    class="whitelisted-domain__icon whitelisted-domain__icon--disabled"
                >
                </external-link-icon>
                <trash-icon
                    v-if="whitelistedDomainEntities.length > 1"
                    size="is-small"
                    @click="deleteWhitelistedDomainEntity(whitelistedDomainEntityIndex)"
                    class="whitelisted-domain__icon"
                >
                </trash-icon>
            </div>
        </div>
        <div>
            <button
                class="button is-text"
                @click="addWhitelistedDomainEntity"
            >
                Add more
            </button>
        </div>
    </div>
</template>

<script>
    import uuidv4 from 'uuid'
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField"
    import ValidatableDomainField from "../fields/ValidatableDomainField";
    import DeleteButton from "../../atoms/buttons/DeleteButton/DeleteButton";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";
    import QuestionCircleIcon from "../../atoms/icons/QuestionCircleIcon";
    import TrashIcon from "../../atoms/icons/TrashIcon";
    import WhitelistedDomainEntity from "../../atoms/Entities/WhitelistedDomainEntity";
    import ExternalLinkIcon from "../../atoms/icons/ExternalLinkIcon/ExternalLinkIcon";

    export default {
        name: "ProjectForm",
        components: {
            ExternalLinkIcon,
            TrashIcon,
            QuestionCircleIcon,
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
            protocol: {
                type: String,
                default: null,
            },
            domain: {
                type: String,
                default: null,
            },
            whitelisted_domain_entities: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                showDomainHelp: false,
                showWhitelistHelp: false,
            }
        },
        computed: {
            domainUrl: {
                get() {
                    return this.protocol && this.domain ? `${this.protocol}://${this.domain}` : null;
                },
                set(newValue) {
                    const splitedDomainUrl = newValue.split('://')
                    this.$emit('update:protocol', splitedDomainUrl[0])
                    this.$emit('update:domain', splitedDomainUrl[1])
                }
            },
            whitelistedDomainEntities: {
                get() {
                    return this.whitelisted_domain_entities
                },
                set(newValue) {
                    return this.$emit('update:whitelisted_domain_entities', newValue)
                },
            }
        },
        watch: {
            whitelisted_domain_entities: {
                immediate: true,
                handler(value) {
                    if (value && value.length === 0) {
                        this.addWhitelistedDomainEntity();
                    }
                }
            }
        },
        created() {
            if (this.$route.name === 'projects.create') {
                this.showDomainHelp = true
                this.showWhitelistHelp = true
            }
        },
        methods: {
            addWhitelistedDomainEntity() {
                this.whitelistedDomainEntities = [
                    ...this.whitelistedDomainEntities,
                    new WhitelistedDomainEntity({
                        protocol: 'https://',
                    })
                ]
            },
            updateWhitelistedDomainEntity(data, index) {
                const splitedDomainUrl = data.split('://')
                this.whitelistedDomainEntities = [
                    ...this.whitelistedDomainEntities.slice(0, index),
                    new WhitelistedDomainEntity({
                        ...this.whitelistedDomainEntities[index],
                        protocol: splitedDomainUrl[0],
                        domain: splitedDomainUrl[1],
                    }),
                    ...this.whitelistedDomainEntities.slice(index+1)
                ]
            },
            deleteWhitelistedDomainEntity(index) {
                this.whitelistedDomainEntities = [
                    ...this.whitelistedDomainEntities.slice(0, index),
                    ...this.whitelistedDomainEntities.slice(index+1),
                ]
            },
            sendTo(whitelistedDomainEntity) {
                const url = `${whitelistedDomainEntity.protocol}://${whitelistedDomainEntity.domain}`
                window.open(url, '_blank')
            }
        }
    }
</script>

<style scoped>
    .whitelisted-domain {
        display: grid;
        grid-template-columns: 1fr minmax(50px, auto);
        grid-column-gap: 20px;
    }
    .whitelisted-domain__actions {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .whitelisted-domain__actions--single {
        justify-content: center;
    }
    .whitelisted-domain__icon {
        margin-top: 0.5em;
        cursor: pointer;
    }
    .whitelisted-domain__icon--disabled {
        opacity: 0.3;
        cursor: unset;
    }
</style>