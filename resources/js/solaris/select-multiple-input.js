import Helper from "./helper";
import SelectInput from "./select-input";

export default class SelectMultipleInput extends SelectInput {
    constructor(selector) {
        super(selector)
    }

    /**
     * get current value element
     * @returns {[{id:string, name:string}]}
     */
    get() {
        const options = Array.from(this._element.selectedOptions)
            .filter(opt => !Helper.isEmpty(opt.value))

        return options.length > 0 ? 
            options.map(opt => {
                return {
                    id: opt.value,
                    name: opt.text
                }
            }) : null
    }

    /**
     * set value element
     * @param {{id:string, selected:boolean}|[{id:string, selected:boolean}]} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        const options = Array.from(this._element.options)

        if(value === null) {
            options.forEach(opt => {
                opt.selected = false
            })
        } else {
            const setFromObject = (value) => {
                if(!value.hasOwnProperty('id') || !value.hasOwnProperty('selected')) {
                    throw new Error(`Value must have id and selected property`)
                }
    
                if(typeof value.selected !== 'boolean') {
                    throw new Error(`Selected must be boolean`)
                }
    
                const opt = options.find(opt => opt.value == value.id)
                opt.selected = value.selected
            }

            if(Helper.isObject(value)) {
                setFromObject(value)
            } else if(Array.isArray(value)) {
                value.forEach(val => {
                    if(Helper.isObject(val)) {
                        setFromObject(val)
                    } else if(Helper.isString(val)) {
                        const opt = options.find(opt => opt.value == val)
                        opt.selected = true
                    } else {
                        throw new Error("Value is not support")
                    }
                })
            } else {
                throw new Error("Value is not support")
            }
        }

        const isChanged = this.isChanged()
        this._oldValue = this.get()
        if(!isSilent && isChanged) {
            this.trigger('change', this.get())
        }
    }

    isChanged() {
        const value = this.get()
        if (!Array.isArray(this._oldValue) || !Array.isArray(value)) {
            return true
        }

        if(this._oldValue.length !== value.length) {
            return true
        }

        const isDifferent = this._oldValue.some(oldVal => {
            return !value.some(val => val.id === oldVal.id)
        })

        const reverseDifferent = value.some(val => {
            return !this._oldValue.some(oldVal => oldVal.id === val.id)
        })

        return isDifferent || reverseDifferent
    }
}