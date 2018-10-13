import { storiesOf } from '@storybook/vue';

import BaseButton from '../assets/ext/js/components/atoms/BaseButton'

storiesOf('BaseButton', module)
    .add('story as a component', () => ({
        components: { BaseButton },
        template: '<BaseButton is-outlined>rounded</BaseButton>'
    }));