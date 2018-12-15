// import Vue from '../../../../test';
// import {
//     mount,
//     shallowMount,
// } from '@vue/test-utils';
// import ProjectsTemplate from './ProjectsTemplate'
//
// import {
//     ReportEntities
// } from "../../../../test/Entities/ReportEntity";
//
// const reportEntity = ReportEntities({ count: 1 })[0];
// const reportEntities = ReportEntities({ count: 10 });
//
// describe('ProjectsTemplate', () => {
//
//     let index = null;
//     let show = null;
//     let update = null;
//     let destroy = null;
//     beforeEach(() => {
//         index = sinon.fake.returns({
//             data: {
//                 total: reportEntities.length,
//                 start: 0,
//                 end: 0,
//                 models: reportEntities,
//             }
//         });
//         show = sinon.fake.returns({
//             data: reportEntity,
//         });
//         update = sinon.fake.returns({
//             data: reportEntity,
//         });
//         destroy = sinon.fake.returns({
//             data: reportEntity,
//         });
//     });
//     function generateWrapper(options, shallow=false) {
//         const mountOptions = {
//             localVue: Vue,
//             sync: false,
//             ...options,
//         };
//
//         if (shallow) {
//             return shallowMount(ProjectsTemplate, mountOptions);
//         }
//         return mount(ProjectsTemplate, mountOptions);
//     }
//
//     describe('life cycles', () => {
//
//         it('created()', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index,
//                 }
//             }, true);
//
//             wrapper.vm.$nextTick(() => {
//                 expect(index.callCount).to.equal(1);
//                 const params = index.getCall(0).lastArg;
//                 expect(params).to.have.property('q', '');
//                 expect(params).to.have.property('page', undefined);
//                 expect(params).to.have.property('per_page', undefined);
//                 expect(params).to.have.property('desc', undefined);
//                 expect(params).to.have.property('order_by', undefined);
//                 done();
//             });
//         });
//     });
//
//     describe('Reports API', () => {
//
//         it('queryChange', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index,
//                 }
//             }, true);
//
//             const ReportsTemplate = wrapper.find({name: 'ReportsTemplate'});
//             const query = 'report1';
//             ReportsTemplate.vm.$emit('queryChange', query);
//             // lodashのdebounce分遅らせる
//             window.setTimeout(() => {
//                 wrapper.vm.$nextTick(() => {
//                     expect(index.callCount).to.equal(2);
//                     const params = index.getCall(1).lastArg;
//                     expect(params).to.have.property('q', query);
//                     expect(params).to.have.property('page', undefined);
//                     expect(params).to.have.property('per_page', undefined);
//                     expect(params).to.have.property('desc', undefined);
//                     expect(params).to.have.property('order_by', undefined);
//                     done();
//                 });
//             }, 300);
//
//         });
//
//         it('searchClick', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index,
//                 }
//             }, true);
//
//             const ReportsTemplate = wrapper.find({name: 'ReportsTemplate'});
//             const query = 'report2';
//             ReportsTemplate.vm.$emit('searchClick', query);
//             // lodashのdebounce分遅らせる
//             window.setTimeout(() => {
//                 wrapper.vm.$nextTick(() => {
//                     expect(index.callCount).to.equal(2);
//                     const params = index.getCall(1).lastArg;
//                     expect(params).to.have.property('q', query);
//                     expect(params).to.have.property('page', undefined);
//                     expect(params).to.have.property('per_page', undefined);
//                     expect(params).to.have.property('desc', undefined);
//                     expect(params).to.have.property('order_by', undefined);
//                     done();
//                 });
//             }, 300);
//
//         });
//
//         it('editClick', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index, // indexはここでは必要ないが、呼ばないとstubしとかないと本物のAPIが呼ばれてしまうため、入れておく
//                     show,
//                 }
//             }, true);
//
//             const ReportsTemplate = wrapper.find({name: 'ReportsTemplate'});
//             ReportsTemplate.vm.$emit('editClick', reportEntity);
//             wrapper.vm.$nextTick(() => {
//                 expect(show.callCount).to.equal(1);
//                 const params = show.getCall(0).lastArg;
//                 expect(params).to.deep.equal(reportEntity);
//                 done();
//             });
//
//         });
//
//         it('deleteConfirmClick', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index, // indexはここでは必要ないが、呼ばないとstubしとかないと本物のAPIが呼ばれてしまうため、入れておく
//                     destroy
//                 }
//             }, true);
//
//             const ReportsTemplate = wrapper.find({name: 'ReportsTemplate'});
//             ReportsTemplate.vm.$emit('deleteConfirmClick', reportEntity);
//             wrapper.vm.$nextTick(() => {
//                 expect(destroy.callCount).to.equal(1);
//                 const params = destroy.getCall(0).lastArg;
//                 expect(params).to.deep.equal(reportEntity);
//                 done();
//             });
//
//         });
//
//         it('settingConfirmClick', done => {
//             const wrapper = generateWrapper({
//                 methods: {
//                     index, // indexはここでは必要ないが、呼ばないとstubしとかないと本物のAPIが呼ばれてしまうため、入れておく
//                     update,
//                 }
//             }, true);
//
//             const ReportsTemplate = wrapper.find({name: 'ReportsTemplate'});
//             ReportsTemplate.vm.$emit('settingConfirmClick', reportEntity);
//             wrapper.vm.$nextTick(() => {
//                 expect(update.callCount).to.equal(1);
//                 const params = update.getCall(0).lastArg;
//                 expect(params).to.deep.equal(reportEntity);
//                 done();
//             });
//
//         });
//
//     });
// });