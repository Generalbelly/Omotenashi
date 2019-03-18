<template>
    <div>
        <fade-transition-group>
            <div
                v-for="(whitelistedDomainEntity, whitelistedDomainEntityIndex) in innerEntities"
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
                        'whitelisted-domain__actions--single': whitelistedDomainEntity.id && innerEntities.length === 1,
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
                        v-if="innerEntities.length > 1"
                        size="is-small"
                        @click="deleteWhitelistedDomainEntity(whitelistedDomainEntityIndex)"
                        class="whitelisted-domain__icon"
                    >
                    </trash-icon>
                </div>
            </div>
        </fade-transition-group>
        <div class="has-text-right">
            <base-button
                @click="addWhitelistedDomainEntity"
            >
                Add more
            </base-button>
        </div>
    </div>
</template>

<script>
    import WhitelistedDomainEntity from "../../../atoms/Entities/WhitelistedDomainEntity";
    import ExternalLinkIcon from "../../../atoms/icons/ExternalLinkIcon";
    import TrashIcon from "../../../atoms/icons/TrashIcon/TrashIcon";
    import FadeTransitionGroup from "../../../atoms/transitions/FadeTransitionGroup/FadeTransitionGroup";
    import ValidatableDomainField from "../ValidatableDomainField";
    import BaseButton from "../../../../../ext/js/components/atoms/BaseButton/BaseButton";

    export default {
        name: "WhitelistedDomainFields",
        components: {
            BaseButton,
            FadeTransitionGroup,
            ValidatableDomainField,
            TrashIcon,
            ExternalLinkIcon
        },
        props: {
            entities: {
                type: Array,
                default() {
                    return [];
                }
            },
        },
        computed: {
            innerEntities: {
                get() {
                    return this.entities
                },
                set(newValue) {
                    this.$emit('update:entities', newValue)
                },
            },
        },
        watch: {
            entities: {
                immediate: true,
                handler(value) {
                    if (value && value.length === 0) {
                        this.addWhitelistedDomainEntity();
                    }
                }
            },
        },
        methods: {
            addWhitelistedDomainEntity() {
                this.innerEntities = [
                    ...this.innerEntities,
                    new WhitelistedDomainEntity({
                        protocol: 'https://',
                    })
                ]
            },
            updateWhitelistedDomainEntity(data, index) {
                const splitedDomainUrl = data.split('://')
                this.innerEntities = [
                    ...this.innerEntities.slice(0, index),
                    new WhitelistedDomainEntity({
                        ...this.innerEntities[index],
                        protocol: splitedDomainUrl[0],
                        domain: splitedDomainUrl[1],
                    }),
                    ...this.innerEntities.slice(index+1)
                ]
            },
            deleteWhitelistedDomainEntity(index) {
                this.innerEntities = [
                    ...this.innerEntities.slice(0, index),
                    ...this.innerEntities.slice(index+1),
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
</style>