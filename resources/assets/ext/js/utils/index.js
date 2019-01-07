
export const camelToKebab = string => {
    return string.replace(/([a-z0-9])([A-Z])/g, '$1-$2').toLowerCase()
}

export const convertKeysFromCamelToKebab = (obj, dataSource=null) => {
    return Object.keys(obj).reduce((accumulator, currentValue) => {
        return {
            ...accumulator,
            [camelToKebab(currentValue)]: dataSource ? dataSource[currentValue] : obj[currentValue],
        }
    }, {})
}