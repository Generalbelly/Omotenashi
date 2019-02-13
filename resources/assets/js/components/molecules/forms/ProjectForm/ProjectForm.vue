<template>
    <div>
        <div class="columns is-6">
            <div class="column is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Basic</sub-heading>
                <p>
                    The domain is where users will actually visit, while the whitelisted domains are typically staging/design websites where you can create and edit tutorials code-free with <a href="">{{ appName }} Chrome extension</a>.
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
                            :label="whitelistedDomainEntityIndex===0 ? 'Whitelisted domains' : ''"
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
                    We send data such as how many steps users complete, how often those users use your website/webapp, etc., on your behalf to your connected Google Analytics account.
                </p>
            </div>
            <div class="column">
                <div
                    v-if="googleOAuthEntity"
                    style="margin-top: 40px;"
                    class="has-text-right"
                >
                    <span class="is-inline-flex has-padding-top-2 has-margin-right-3">
                        Connected with the account {{ googleOAuthEntity.email }}
                    </span>
                    <trash-icon
                        @click="$emit('click:ga-delete', googleOAuthEntity)"
                        size="is-small"
                    ></trash-icon>
                </div>
                <div
                    v-else
                    class="connect-google-analytics-button"
                >
                    <connect-google-analytics-button
                        @click="$emit('click:ga-connect', $event)"
                    ></connect-google-analytics-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ValidatableTextField from "../../fields/ValidatableTextField"
    import ValidatableDomainField from "../../fields/ValidatableDomainField";
    import AddButton from "../../../atoms/buttons/AddButton/AddButton";
    import QuestionCircleIcon from "../../../atoms/icons/QuestionCircleIcon";
    import TrashIcon from "../../../atoms/icons/TrashIcon";
    import WhitelistedDomainEntity from "../../../atoms/Entities/WhitelistedDomainEntity";
    import ExternalLinkIcon from "../../../atoms/icons/ExternalLinkIcon";
    import SubHeading from "../../../atoms/SubHeading/SubHeading";
    import FadeTransitionGroup from "../../../atoms/transitions/FadeTransitionGroup";
    import CancelButton from "../../../atoms/buttons/CancelButton";
    import SaveButton from "../../../atoms/buttons/SaveButton";
    import ConfirmButton from "../../../atoms/buttons/ConfirmButton";
    import ConnectGoogleAnalyticsButton from "../../../atoms/buttons/ConnectGoogleAnalyticsButton";
    import DeleteButton from "../../../atoms/buttons/DeleteButton/DeleteButton";

    export default {
        name: "ProjectForm",
        components: {
            DeleteButton,
            ConnectGoogleAnalyticsButton,
            ConfirmButton,
            SaveButton,
            CancelButton,
            FadeTransitionGroup,
            SubHeading,
            ExternalLinkIcon,
            TrashIcon,
            QuestionCircleIcon,
            AddButton,
            ValidatableDomainField,
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
            },
            googleOAuthEntity() {
                return this.oauth_entities.find(entity => entity.service === 'google_analytics');
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
    .connect-google-analytics-button {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>