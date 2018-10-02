import Vue from 'vue';

import { storiesOf } from '@storybook/vue';

import BaseButton from '../assets/ext/js/components/BaseButton'

storiesOf('BaseButton', module)
    .add('story as a template', () => '<base-button>story as a function template</base-button>')
    .add('story as a component', () => ({
        components: { BaseButton },
        template: '<base-button>rounded</base-button>'
    }));