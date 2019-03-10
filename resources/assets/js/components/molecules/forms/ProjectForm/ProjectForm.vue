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
                            :exception-domains="['https://localhost', 'http://localhost']"
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
                        class="button"
                        @click="addWhitelistedDomainEntity"
                    >
                        Add more
                    </button>
                </div>
            </div>
        </div>
        <div
            v-if="id"
            class="columns is-6"
        >
            <div class="column is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Google Analytics</sub-heading>
                <p>
                    We send data such as how many steps users complete, how often those users use your website/webapp, etc., on your behalf to your connected Google Analytics account.
                </p>
            </div>
            <div class="column">
                <div
                    v-if="googleOAuthEntity"
                >
                    <div v-if="googleAnalyticsPropertyEntity && googleAnalyticsPropertyEntity.id">
                        <div class="columns">
                            <div class="column">
                                <span
                                    class="tag is-medium is-primary-100 has-margin-right-4"
                                >
                                    Connected
                                </span>
                                <pen-icon
                                    class="has-margin-right-3 has-cursor-pointer"
                                    size="is-small"
                                    @click="$emit('click:ga-property-edit', id)"
                                ></pen-icon>
                                <trash-icon
                                    class="has-cursor-pointer"
                                    size="is-small"
                                    @click="$emit('click:ga-delete', googleOAuthEntity)"
                                >
                                </trash-icon>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half label">
                                Property ID
                            </div>
                            <div class="column">
                                {{ googleAnalyticsPropertyEntity.property_id }}
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half label">
                                Property Name
                            </div>
                            <div class="column">
                                {{ googleAnalyticsPropertyEntity.property_name }}
                            </div>
                        </div>
                    </div>
                    <b-message v-else type="is-success">
                        <p class="has-margin-bottom-4">
                            Successfully connected to your Google account!<br>
                            Next step is to select a Google Analytics account and a web property.
                        </p>
                        <div>
                            <start-selecting-google-analytics-property-button
                                v-if="googleAnalyticsAccountOptions.length === 0"
                                @click="$emit('click:ga-property-edit', id)"
                                class="is-success-200"
                            >
                            </start-selecting-google-analytics-property-button>
                            <div v-else>
                                <validatable-select-field
                                    :items="googleAnalyticsAccountOptions"
                                    v-model="googleAnalyticsAccountId"
                                    label="Account"
                                    placeholder="Select account"
                                    name="Account"
                                    rules="required"
                                    horizontal
                                ></validatable-select-field>
                                <validatable-select-field
                                    v-if="googleAnalyticsAccount"
                                    :items="googleAnalyticsWebPropertyOptions"
                                    style="white-space: nowrap;"
                                    label="Property"
                                    placeholder="Select property"
                                    v-model="googleAnalyticsWebPropertyId"
                                    name="Property"
                                    rules="required"
                                    horizontal
                                ></validatable-select-field>
                            </div>
                        </div>
                    </b-message>
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
    import ValidatableTextField from "../../fields/ValidatableTextField";
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
    import DeleteButton from "../../../atoms/buttons/DeleteButton/DeleteButton";
    import ConnectGoogleAnalyticsButton from "../../../atoms/buttons/ConnectGoogleAnalyticsButton";
    import DisconnectGoogleAnalyticsButton from "../../../atoms/buttons/DisconnectGoogleAnalyticsButton";
    import ConnectDifferentGoogleAnalyticsPropertyButton from "../../../atoms/buttons/ConnectDifferentGoogleAnalyticsPropertyButton";
    import GoogleAnalyticsPropertyEntity from "../../../atoms/Entities/GoogleAnalyticsPropertyEntity";
    import StartSelectingGoogleAnalyticsPropertyButton from "../../../atoms/buttons/StartSelectingGoogleAnalyticsPropertyButton";
    import ValidatableSelectField from "../../../../components/molecules/fields/ValidatableSelectField";
    import PenIcon from "../../../atoms/icons/PenIcon/PenIcon";

    export default {
        name: "ProjectForm",
        components: {
            PenIcon,
            ValidatableSelectField,
            StartSelectingGoogleAnalyticsPropertyButton,
            ConnectDifferentGoogleAnalyticsPropertyButton,
            DisconnectGoogleAnalyticsButton,
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
            },
            google_analytics_property_entities: {
                type: Array,
                default() {
                    return []
                }
            },
            googleAnalyticsAccounts: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                appName: process.env.APP_NAME,
                googleAnalyticsAccountId: null,
                googleAnalyticsWebPropertyId: null,
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
                    this.$emit('update:whitelisted_domain_entities', newValue)
                },
            },
            googleOAuthEntity() {
                return this.oauth_entities.find(entity => entity.service === 'google_analytics');
            },
            googleAnalyticsPropertyEntity() {
                if (this.google_analytics_property_entities.length > 0) {
                    return this.google_analytics_property_entities[0];
                }
                return null;
            },
            googleAnalyticsAccountOptions() {
                return this.googleAnalyticsAccounts.map(account => ({
                        text: account.name,
                        value: account.id,
                    }))
            },
            googleAnalyticsAccount() {
                if (!this.googleAnalyticsAccountId) return null;
                return this.googleAnalyticsAccounts.find(account => account.id === this.googleAnalyticsAccountId);
            },
            googleAnalyticsWebPropertyOptions() {
                if (!this.googleAnalyticsAccount) {
                    return [];
                }
                return this.googleAnalyticsAccount.webProperties.map(property => ({
                        text: property.name,
                        value: property.id,
                    }))
            },
            googleAnalyticsWebProperty() {
                if (!this.googleAnalyticsWebPropertyId) return null;
                return this.googleAnalyticsAccount.webProperties.find(
                    property => property.id === this.googleAnalyticsWebPropertyId
                )
            },
        },
        watch: {
            whitelisted_domain_entities: {
                immediate: true,
                handler(value) {
                    if (value && value.length === 0) {
                        this.addWhitelistedDomainEntity();
                    }
                }
            },
            googleAnalyticsWebProperty(value) {
                if (value) {
                    const googleAnalyticsPropertyEntity = new GoogleAnalyticsPropertyEntity({
                        account_id: this.googleAnalyticsAccount.id,
                        account_name: this.googleAnalyticsAccount.name,
                        property_id: value.id,
                        property_name: value.name,
                        website_url: value.websiteUrl,
                    })
                    this.$emit('update:google_analytics_property_entities', [ googleAnalyticsPropertyEntity ])
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