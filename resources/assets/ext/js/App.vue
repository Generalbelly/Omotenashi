<template>
    <div id="omotenashi">
        <div
            class="user-not-editing-actions has-padding-4"
            v-show="userState === 'editing' || userState === 'previewing'"
        >
            <div class="buttons">
                <button
                    class="button is-small"
                    @click.stop.prevent="onPreviewClick"
                >
                    <span class="icon">
                        <font-awesome-icon icon="play"></font-awesome-icon>
                    </span>
                    <span>Preview</span>
                </button>
                <button
                    class="button is-small"
                    @click="onHomeClick"
                >
                    <span class="icon">
                        <font-awesome-icon icon="home"></font-awesome-icon>
                    </span>
                    <span>Home</span>
                </button>
            </div>
        </div>

        <div
            class="user-editing-actions has-padding-4"
            v-show="userState === 'editingPopover'"
        >
            <button
                class="button is-success"
                @click="onAddClick"
            >
                Add
            </button>
            <button
                class="button"
                @click="onCancelClick"
            >
                Cancel
            </button>
        </div>

        <div
            class="container"
            v-show="userState === 'home'"
        >
            <div class="has-background-dark"></div>
            <nav class="navbar level has-background-dark has-margin-bottom-0 has-padding-4 is-fixed-bottom">
                <div class="level-left">
                    <h1 class="has-text-white is-size-4">Omotenashi</h1>
                </div>
                <div class="level-right">
                    <p class="level-item">
                        <button
                            class="button is-success"
                            @click.stop.prevent="onStartClick"
                        >
                            {{ steps.length === 0 ? 'Create a' : 'Edit the' }} tutorial
                        </button>
                    </p>
                    <p class="level-item">
                        <a class="button" href="#">
                            Feedback
                        </a>
                    </p>
                </div>
            </nav>

            <Modal
                v-show="modal.isShown"
                :content="modal.content"
                :action-button-text="modal.actionButtonText"
                @startClick="onStartClick"
                @closeClick="() => { modal.isShown = false }"
            >
            </Modal>

        </div>

        <Message
            v-show="message.isShown"
            class="nav-bar message"
            :header="message.header"
            :body="message.body"
            :additional-class="message.additionalClass"
            @closeClick="() => { message.isShown = false }"
        ></Message>
    </div>
</template>
<script>
import Driver from 'driver.js/dist/driver.min.js';
import Message from './Message';
import Modal from './Modal';

const userStates = {
    editing: 'editing',
    editingPopover: 'editingPopover',
    previewing: 'previewing',
    home: 'home',
};

export default {
    created() {
        document.body.addEventListener('click', this.onUserScreenClick);
        this.driver = new Driver({
            allowClose: false,
        });
    },
    mounted() {
        if (localStorage.getItem('omotenashi-ext')) {
            try {
                this.extLog = JSON.parse(localStorage.getItem('omotenashi-ext'));
                this.modal.isShown = this.extLog.userIsFirstTime;
            } catch(e) {
                localStorage.removeItem('omotenashi-ext');
            }
        }
    },
    data() {
        return {
            extLog: {
                userIsFirstTime: true,
            },
            userState: userStates.home,
            showModal: true,
            driver: null,
            steps: [],
            modal: {
                isShown: true,
                content:
                    '<h1>Omotenashi</h1>\n' +
                    '<p class="has-padding-2 has-margin-bottom-4">\n' +
                    'Omotenashi enables you to create tutorials for user onboading for your web app/service\n' +
                    'without coding.<br/>\n' +
                    'Let\'s makes your website more interactive and fun :)<br/><br/>\n' +
                    'If you have any question or feedback, please click the feedback button below and submit a\n' +
                    'feedback form.\n' +
                    '</p>',
                actionButtonText: 'Let\'s get started',
            },
            message: {
                header: '',
                body: '',
                additionalClass: [],
                isShown: false,
            },
        };
    },
    watch: {
        userState(value) {
            if (value === userStates.editingPopover) {
                document.querySelector('.driver-popover-title').setAttribute('contenteditable', true);
                document.querySelector('.driver-popover-description').setAttribute('contenteditable', true);
            } else {
                document.querySelector('.driver-popover-title').removeAttribute('contenteditable');
                document.querySelector('.driver-popover-description').removeAttribute('contenteditable');
            }
        }
    },
    methods: {
        setUserState(state = null) {
            if (!Object.values(userStates).includes(state)) return;
            this.userState = state;
        },
        onHomeClick() {
            this.setUserState(userStates.home);
        },
        onStartClick() {
            this.modal.isShown = false;
            this.setUserState(userStates.editing);

            if (this.extLog.userIsFirstTime) {
                this.extLog.userIsFirstTime = false;
                localStorage.setItem('omotenashi-ext', JSON.stringify(this.extLog));
            }
        },
        onAddClick() {
            const activeElement = this.driver.getHighlightedElement();
            const popover = activeElement.getPopover();
            const title = popover.getTitleNode().innerHTML;
            const description = popover.getDescriptionNode().innerHTML;

            const activeNode = activeElement.getNode();

            this.steps = [
                ...this.steps,
                {
                    element: activeNode,
                    popover: {
                        title: title,
                        description: description,
                    }
                }
            ];

            this.quitEditingPopover();
        },
        onCancelClick() {
            this.quitEditingPopover();
        },
        quitEditingPopover() {
            this.setUserState(userStates.editing);
            this.driver.reset();
        },
        onUserScreenClick(e) {
            if (this.userState === userStates.home || this.userState === userStates.editing) {
                if (e.composedPath().find(el => el.id === 'omotenashi')) return;
                e.stopPropagation(); // for driver.js
                e.preventDefault(); // for driver.js
                this.highlightElement(e);
            }
        },
        highlightElement(e) {
            if (this.message.isShown) {
                this.message.isShown = false;
            } else if (this.userState === userStates.editing) {
                this.setUserState(userStates.editingPopover);
                this.driver.highlight({
                    element: e.composedPath()[0],
                    popover: {
                        title: 'Edit me!',
                        description: 'Some description here',
                    }
                });
            }
        },
        onPreviewClick() {
            if (this.steps.length === 0) {
                this.message = {
                    header: "Oops",
                    body: "You haven't added any step yet.",
                    additionalClass: ['is-warning', 'is-small'],
                    isShown: true,
                };
                return;
            }
            this.setUserState(userStates.previewing);
            this.play();
        },
        play() {
            this.driver.options.allowClose = true;
            this.driver.defineSteps(this.steps);
            this.driver.start();
        }
    },
    components: {
        Message,
        Modal,
    }
}
</script>
<style scoped>
    .container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .user-not-editing-actions {
        position: fixed;
        bottom:0;
        right: 0;
    }
    .user-editing-actions {
        position: fixed;
        bottom:0;
        right: 0;
        height: 50px;
        z-index: 100000000;
    }
    .message {
        position: fixed;
        bottom: 80px;
        right: 0;
        width: 30vw;
    }
</style>