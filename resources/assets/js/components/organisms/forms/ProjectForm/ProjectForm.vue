<template>
    <div>
        <columns class="is-6">
            <column class="is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Basic</sub-heading>
                <p>
                    The domain is where users will actually visit, while the whitelisted domains are typically staging/design websites where you can create and edit tutorials code-free with <a href="">{{ appName }} Chrome extension</a>.
                </p>
            </column>
            <column>
                <validatable-text-field
                    label="Name"
                    name="Name"
                    rules="required"
                    :value="name"
                    @input="$emit('update:name', $event)"
                ></validatable-text-field>
                <validatable-domain-field
                    label="Domain"
                    name="Domain"
                    rules="required"
                    v-model="domainUrl"
                >
                </validatable-domain-field>
            </column>
        </columns>
        <columns
            class="is-6"
        >
            <column class="is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Tutorials</sub-heading>
                <p>
                    Set rules for tutorials.
                </p>
            </column>
            <column>
                <tutorial-setting-fields
                    :value="tutorial_settings"
                    @input="$emit('update:tutorial_settings', $event)"
                ></tutorial-setting-fields>
            </column>
        </columns>
        <columns
            v-if="id"
            class="is-6"
        >
            <column class="is-two-fifths">
                <sub-heading class="has-text-weight-bold has-margin-bottom-4">Google Analytics</sub-heading>
                <p>
                    We send data such as how many steps users complete, how often those users use your website/webapp, etc., on your behalf to your connected Google Analytics account.
                </p>
            </column>
            <column>
                <div
                    v-if="googleOAuthEntity"
                >
                    <div v-if="googleAnalyticsPropertyEntity && googleAnalyticsPropertyEntity.id && googleAnalyticsAccountOptions.length === 0">
                        <columns>
                            <column>
                                <tag
                                    is-small
                                    class="is-success-200 has-margin-right-4"
                                >
                                    Connected
                                </tag>
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
                            </column>
                        </columns>
                        <columns>
                            <column class="is-half label">
                                Property ID
                            </column>
                            <column>
                                {{ googleAnalyticsPropertyEntity.property_id }}
                            </column>
                        </columns>
                        <columns>
                            <column class="is-half label">
                                Property Name
                            </column>
                            <column>
                                {{ googleAnalyticsPropertyEntity.property_name }}
                            </column>
                        </columns>
                    </div>
                    <b-message v-else type="is-success">
                        <p class="has-margin-bottom-4">
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
            </column>
        </columns>
    </div>
</template>

<script>
    import ValidatableTextField from "../../../molecules/fields/ValidatableTextField";
    import ValidatableDomainField from "../../../molecules/fields/ValidatableDomainField";
    import TrashIcon from "../../../atoms/icons/TrashIcon";
    import SubHeading from "../../../atoms/SubHeading/SubHeading";
    import ConnectGoogleAnalyticsButton from "../../../atoms/buttons/ConnectGoogleAnalyticsButton";
    import GoogleAnalyticsPropertyEntity from "../../../atoms/Entities/GoogleAnalyticsPropertyEntity";
    import StartSelectingGoogleAnalyticsPropertyButton from "../../../atoms/buttons/StartSelectingGoogleAnalyticsPropertyButton";
    import ValidatableSelectField from "../../../molecules/fields/ValidatableSelectField";
    import PenIcon from "../../../atoms/icons/PenIcon/PenIcon";
    import Columns from "../../../atoms/Columns/Columns";
    import Column from "../../../atoms/Column/Column";
    import TutorialSettingFields from "../../../molecules/fields/TutorialSettingFields";
    import Tag from "../../../atoms/Tag/Tag";

    export default {
        name: "ProjectForm",
        components: {
            TutorialSettingFields,
            Tag,
            Column,
            Columns,
            PenIcon,
            ValidatableSelectField,
            StartSelectingGoogleAnalyticsPropertyButton,
            ConnectGoogleAnalyticsButton,
            SubHeading,
            TrashIcon,
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
            },
            tutorial_settings: {
                type: Object,
                default() {
                    return {};
                }
            },
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
                if (this.googleAnalyticsAccount && this.googleAnalyticsWebPropertyId) {
                    return this.googleAnalyticsAccount.webProperties.find(
                        property => property.id === this.googleAnalyticsWebPropertyId
                    )
                }
                return null;
            },
        },
        watch: {
            googleAnalyticsWebProperty(value) {
                if (value) {
                    const googleAnalyticsPropertyEntity = new GoogleAnalyticsPropertyEntity({
                        ...this.googleAnalyticsPropertyEntity,
                        account_id: this.googleAnalyticsAccount.id,
                        account_name: this.googleAnalyticsAccount.name,
                        property_id: value.id,
                        property_name: value.name,
                        website_url: value.websiteUrl,
                    })
                    this.$emit('update:google_analytics_property_entities', [ googleAnalyticsPropertyEntity ])
                }
            },
        },
        methods: {

        }
    }
</script>

<style scoped>
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