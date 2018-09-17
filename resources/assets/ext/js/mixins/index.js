const getActualPropertyNames = (obj, property='') => {
    if (!Object.keys(obj).includes(property)) return [];
    return Object.keys(obj[property]);
};

const files = require.context('.', false, /\.js$/);
const mixins = files.keys().reduce((combinedMixins, key) => {
    if (key === './index.js') return combinedMixins;
    let updatedMixins = { ...combinedMixins };
    try {
        const mixin = files(key).default;
        const propertyNames = Object.keys(mixin); // e.g. data, methods, props, etc...
        propertyNames.forEach(propertyName => {
            const actualPropertyNamesInCombinedMixin = getActualPropertyNames(combinedMixins, propertyName);
            const actualPropertyNames = getActualPropertyNames(mixin, propertyName); // 実際のmethod名やprop名
            actualPropertyNames.forEach(actualPropertyName => {
                if (actualPropertyNamesInCombinedMixin.includes(actualPropertyName)) {
                    throw Error(`${propertyName}: ${actualPropertyName} in ${key} is already used.`);
                }
                updatedMixins = {
                    ...updatedMixins,
                    [propertyName]: {
                        ...updatedMixins[propertyName],
                        [actualPropertyName]: mixin[propertyName][actualPropertyName],
                    },
                };
            });
        });
        return updatedMixins;
    } catch (e) {
        console.error(e.name + ': ' + e.message);
    }
}, {});
export default mixins;
