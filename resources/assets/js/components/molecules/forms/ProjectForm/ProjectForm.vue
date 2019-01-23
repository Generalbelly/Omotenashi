<template>
    <div>
        <div class="columns is-6">
            <div class="column is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Basic</sub-heading>
                <p>
                    Domain is the one your users actually visit, while whitelisted domains are typically staging/design website ones where You can create/edit tutorials code-free with <a href="">{{ appName }} Chrome extension</a>.
                </p>
            </div>
            <div class="column">
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
                    v-model="domainUrl"
                >
                </validatable-domain-field>
                <fade-transition-group>
                    <div
                        v-for="(whitelistedDomainEntity, whitelistedDomainEntityIndex) in whitelistedDomainEntities"
                        :key="whitelistedDomainEntityIndex"
                        class="whitelisted-domain"
                    >
                        <validatable-domain-field
                            :label="whitelistedDomainEntityIndex===0 ? 'Whitelisted domain' : ''"
                            name="Whitelisted domain"
                            rules="required"
                            :value="`${whitelistedDomainEntity.protocol}://${whitelistedDomainEntity.domain}`"
                            @input="updateWhitelistedDomainEntity($event, whitelistedDomainEntityIndex)"
                            expanded
                        >
                        </validatable-domain-field>
                        <div
                            class="whitelisted-domain__actions"
                            :class="{
                                'whitelisted-domain__actions--single': whitelistedDomainEntity.id && whitelistedDomainEntities.length === 1,
                                'whitelisted-domain__actions--with-label': whitelistedDomainEntityIndex === 0,
                            }"
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
                </fade-transition-group>
                <div class="has-text-right">
                    <button
                        class="button is-text"
                        @click="addWhitelistedDomainEntity"
                    >
                        Add more
                    </button>
                </div>
            </div>
        </div>
        <div class="columns is-6">
            <div class="column is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Google Analytics</sub-heading>
                <p>
                    We send data to the connected Google Analytics such as: How many steps users complete; How often those users use your website/webapp.
                </p>
            </div>
            <div class="column">
                <div v-if="oauth_entities.length === 0" class="connect-google-analytics-button">
                    <connect-google-analytics-button
                        @click="$emit('click:ga-connect', $event)"
                    ></connect-google-analytics-button>
                </div>
                <div v-else>Connected!</div>
            </div>
        </div>
        <div class="columns is-6">
            <div class="column is-two-fifths">
            </div>
            <div class="column">
                <div class="form-actions">
                    <delete-button
                        @click="showDeleteButton = true"
                        class="is-text has-margin-right-auto"
                    ></delete-button>
                    <div class="buttons">
                        <cancel-button
                            @click="$emit('click:cancel', $event)"
                        >
                        </cancel-button>
                        <save-button
                            @click="$emit('click:save', $event)"
                        ></save-button>
                    </div>
                </div>
                <fade-transition>
                    <div v-show="showDeleteButton" class="delete-confirmation">
                        <b-message type="is-danger">
                            <div class="level">
                                <div class="level-left">
                                    <p class="level-item">You are about to delete this project.</p>
                                </div>
                                <div class="level-right">
                                    <confirm-button
                                        @click="$emit('click:delete', $event)"
                                        class="level-item is-danger"
                                    >
                                    </confirm-button>
                                    <cancel-button
                                        @click="showDeleteButton = false"
                                        class="level-item"
                                    >
                                    </cancel-button>
                                </div>
                            </div>
                        </b-message>
                    </div>
                </fade-transition>
            </div>
        </div>
    </div>
</template>

<script>
    import ValidatableTextField from "../../fields/ValidatableTextField"
    import ValidatableDomainField from "../../fields/ValidatableDomainField";
    import DeleteButton from "../../../atoms/buttons/DeleteButton/DeleteButton";
    import AddButton from "../../../atoms/buttons/AddButton/AddButton";
    import QuestionCircleIcon from "../../../atoms/icons/QuestionCircleIcon";
    import TrashIcon from "../../../atoms/icons/TrashIcon";
    import WhitelistedDomainEntity from "../../../atoms/Entities/WhitelistedDomainEntity";
    import ExternalLinkIcon from "../../../atoms/icons/ExternalLinkIcon";
    import SubHeading from "../../../atoms/SubHeading/SubHeading";
    import FadeTransitionGroup from "../../../atoms/transitions/FadeTransitionGroup";
    import CancelButton from "../../../atoms/buttons/CancelButton";
    import SaveButton from "../../../atoms/buttons/SaveButton";
    import FadeTransition from "../../../atoms/transitions/FadeTransition";
    import ConfirmButton from "../../../atoms/buttons/ConfirmButton";
    import ConnectGoogleAnalyticsButton
        from "../../../atoms/buttons/ConnectGoogleAnalyticsButton/ConnectGoogleAnalyticsButton";

    export default {
        name: "ProjectForm",
        components: {
            ConnectGoogleAnalyticsButton,
            ConfirmButton,
            FadeTransition,
            SaveButton,
            CancelButton,
            FadeTransitionGroup,
            SubHeading,
            ExternalLinkIcon,
            TrashIcon,
            QuestionCircleIcon,
            AddButton,
            ValidatableDomainField,
            DeleteButton,
            ValidatableTextField,
        },
        props: {
            id: {
                type: String,
                default: null,
            },
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
            },
            oauth_entities: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                appName: process.env.APP_NAME,
                showDeleteButton: false,
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
        grid-template-columns: 1fr minmax(40px, auto);
        grid-column-gap: 20px;
    }
    .whitelisted-domain__actions {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .whitelisted-domain__actions--with-label {
        margin-top: 2em;
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
    .columns.is-6 {
        margin-bottom: 2em;
    }
    .column > .field {
        margin-bottom: 3em;
    }
    .form-actions {
        margin-top: 3em;
        display: flex;
        flex-direction: row;
    }
    .delete-confirmation {
        margin-top: 2em;
    }
    .connect-google-analytics-button {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>