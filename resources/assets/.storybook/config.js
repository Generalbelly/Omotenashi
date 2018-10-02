import { configure, addDecorator } from '@storybook/vue'

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

addDecorator((story) => ({
    template: `
    <div id="omotenashi">
        <story slot="story"></story>
    </div>
  `
}))

function loadStories() {
    // You can require as many stories as you need.
    require('../stories');

}

configure(loadStories, module);
